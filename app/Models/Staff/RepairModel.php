<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once "./app/config/library.php";
class RepairModel extends Model
{
    function getRepairList($id, $filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*, c.ten AS tentb, b.hoten 
            FROM suachua AS a, nguoidung AS b, thietbi AS c  
            WHERE 1=1 AND a.thietbi_id = c.id AND a.nguoidung_id = b.id AND a.phancong = '$id'"; // Sử dụng điều kiện "1=1" để có thể thêm các điều kiện một cách linh hoạt

        // if ($filter == '' && $keyword == '') {
        //     $query .= " AND a.phancong = '$id'";
        // }
        if ($status != '') {
            $query .= " AND a.tinhtrang = '$status'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND a.ngaygui <= '$eDate' AND a.ngaygui >= '$sDate'";
        }
        if ($filter == 'nguoigui' && $keyword != '') {
            $query .= " AND EXISTS (SELECT 1 FROM nguoidung AS b WHERE b.id = a.nguoidung_id AND b.quyen_id = 2 AND b.hoten LIKE '%$keyword%')";
        } elseif ($filter == 'thietbi' && $keyword != '') {
            $query .= " AND c.ten LIKE '%$keyword%'";
        }

        $queryCount = $query; // Truy vấn đếm sẽ được thiết lập tương tự
        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryStaff = "SELECT * FROM nguoidung WHERE quyen_id = 3";
        $rsStaff = $this->conn->query($queryStaff);
        $dataStaff = array();
        while ($row = $rsStaff->fetch_assoc()) {
            $dataStaff[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'staff' => $dataStaff,
            'count' => count($rsCount->fetch_all()),
            'query' => $query,
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM suachua WHERE id = $id";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryStaffAssign = "SELECT * FROM suachua WHERE id = $id";
        $rsStaffAssign = $this->conn->query($queryStaffAssign);
        $dataStaffAssign = array();
        while ($row = $rsStaffAssign->fetch_assoc()) {
            $dataStaffAssign[] = $row;
        }
        return [
            'data' => $data,
            'staffAssign' => $dataStaffAssign
        ];
    }
    function getDeviceType()
    {
        $query = "SELECT * FROM thietbi WHERE id IN (Select thietbi_id From muon WHere nguoidung_id = '{$_SESSION['id']}' AND trangthai = 'Đang mượn')";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
    function getUserById($id)
    {
        $query = "SELECT hoten, email, sodienthoai FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();

        return [
            "status" => "success",
            "data" => $data
        ];
    }
    function updateStatusRepair($id, $status)
    {
        $queryGetId = "SELECT thietbi_id, madonmuon FROM suachua WHERE id = '$id'";
        $rsId = $this->conn->query($queryGetId);
        $dataId = $rsId->fetch_assoc();
        $query = "UPDATE `suachua` 
        SET `tinhtrang`= '$status'
        WHERE `id`=$id";
        if ($status == 'Hoàn thành') {
            $queryUpdateDevice = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE id = '{$dataId['thietbi_id']}'";
            $queryUpdateBorrow = "UPDATE muon SET trangthai = 'Hoàn thành sửa' WHERE thietbi_id = '{$dataId['thietbi_id']}' AND madonmuon = '{$dataId['madonmuon']}'";
            $this->conn->query($queryUpdateDevice);
            $this->conn->query($queryUpdateBorrow);
        }
        if ($status == 'Hỏng') {
            $queryUpdateDevice = "UPDATE thietbi SET trangthai = 'Hỏng' WHERE id = '{$dataId['thietbi_id']}'";
            $queryUpdateBorrow = "UPDATE muon SET trangthai = 'Hoàn thành sửa' WHERE thietbi_id = '{$dataId['thietbi_id']}' AND madonmuon = '{$dataId['madonmuon']}'";

            $this->conn->query($queryUpdateDevice);
            $this->conn->query($queryUpdateBorrow);
        }
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi cập nhật"
            ];
        }
    }
}
