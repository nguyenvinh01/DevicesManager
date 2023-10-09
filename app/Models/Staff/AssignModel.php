<?php

require_once "./app/Models/Model.php";
class AssignModel extends Model
{
    function getAssignList($id, $filter, $keyword, $page, $department, $eDate, $sDate, $status)
    {
        $offset = $page * 10;

        $query = "SELECT
        ql.id,
        ql.madoncapphat,
        ql.ngaykiemtra,
        ql.tinhtrang,
        ql.nhanvien_id,
        T.ten AS ten_thietbi,
        PB.tenpb AS ten_phongban,
        TN.tentoanha AS ten_toanha,
        DD.phong AS ten_diadiem,
        nv.hoten AS ten_nv
    FROM
        quanly AS ql
    LEFT JOIN
        thietbi AS T ON ql.id_thietbi = T.id
    LEFT JOIN
        phongban AS PB ON ql.phongban = PB.id
    LEFT JOIN
        toanha AS TN ON ql.toanha = TN.id
    LEFT JOIN
        diadiem AS DD ON ql.diadiem = DD.id
    LEFT JOIN
        nguoidung AS nv ON ql.nhanvien_id = nv.id
    WHERE ql.nhanvien_id = $id";
        if ($status != '') {
            $query .= " AND ql.tinhtrang = '$status'";
        }
        if ($filter == 'hoten') {
            $query .= " AND nv.hoten LIKE '%$keyword%'";
        } elseif ($filter == 'thietbi') {
            $query .= " AND T.ten LIKE '%$keyword%'";
        }
        if ($department != '') {
            $query .= " AND PB.id = '$department'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND ql.ngaykiemtra <= '$eDate' AND ql.ngaykiemtra >= '$sDate'";
        }
        $query .= " GROUP BY ql.madoncapphat";

        $queryCount = $query;
        $query .= " ORDER BY ql.id DESC LIMIT 10 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'count' => count($rsCount->fetch_all()),
            'query' => $query
        ];
    }

    function getAssignDetail($idCapPhat)
    {

        $query = "SELECT
        ql.id,
        ql.id_thietbi,
        ql.madoncapphat,
        ql.ngaykiemtra,
        ql.tinhtrang as trangthai,
        ql.soluong,
        T.ten AS ten_thietbi,
        T.mathietbi AS mathietbi,
        PB.tenpb AS ten_phongban,
        TN.tentoanha AS ten_toanha,
        DD.phong AS ten_diadiem,
        nv.hoten AS ten_nv
    FROM
        quanly AS ql
    LEFT JOIN
        thietbi AS T ON ql.id_thietbi = T.id
    LEFT JOIN
        phongban AS PB ON ql.phongban = PB.id
    LEFT JOIN
        toanha AS TN ON ql.toanha = TN.id
    LEFT JOIN
        diadiem AS DD ON ql.diadiem = DD.id
    LEFT JOIN
        nguoidung AS nv ON ql.nhanvien_id = nv.id
    WHERE
        ql.madoncapphat = '${idCapPhat}'";
        $rs = $this->conn->query($query);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'query' => $query
        ];
    }

    function getDeviceByType($idType)
    {
        $query = "SELECT * FROM thietbi WHERE loaithietbi_id = $idType;";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }

    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        // while ($row = $rs->fetch_assoc()) {
        //     $data[] = $row;
        // }
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
    function getDepartment()
    {
        $query = "SELECT * FROM phongban;";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }

    function getDataAddModal()
    {
        $dataDeviceType = $this->getDeviceType();
        $dataDepartment = $this->getDepartment();
        return [
            'status' => 'success',
            'dataDeviceType' => $dataDeviceType,
            'dataDepartment' => $dataDepartment,
        ];
    }
    function getStaff()
    {
        $query = "SELECT * FROM nguoidung WHERE quyen_id = 3;";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            "status" => "success",
            "data" => $data
        ];
    }
    function getDeviceType()
    {
        $query = "SELECT * FROM loaithietbi";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    function sendRepair($idtb, $noidung)
    {
        $query = "INSERT INTO suachua (thietbi_id, noidung, nguoidung_id, tinhtrang) 
            VALUES ( '{$idtb}', '{$noidung}','{$_SESSION['id']}', 'Chờ xử lý') ";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Gửi thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi gửi"
            ];
        }
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM quanly WHERE id = $id";
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
    function updateStatusRepair($id, $status)
    {
        $query = "UPDATE `quanly` 
        SET `tinhtrang`= '$status'
        WHERE `id`=$id";
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
    function updateAssignStatus($tinhtrang, $id)
    {

        foreach ($tinhtrang as $keyValue) {
            $query = "UPDATE quanly SET tinhtrang = '{$keyValue['value']}' WHERE madoncapphat = '$id' AND id_thietbi = '{$keyValue['key']}'";
            $this->conn->query($query);
            if ($keyValue['value'] == 'Thu hồi') {
                $queryUpdate = "UPDATE thietbi SET tinhtrang = 'Sẵn Sàng' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Sửa chữa') {
                $queryUpdate = "UPDATE thietbi SET tinhtrang = 'Chờ sửa chữa' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Thất lạc') {
                $queryUpdate = "UPDATE thietbi SET tinhtrang = 'Thất lạc' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            }
        }
        // $result = $this->conn->query($query);
        // if ($result) {
        // if ($tinhtrang == "Đã trả" || $tinhtrang == "Từ chối yêu cầu") {
        //     $update = "UPDATE `thietbi` 
        //     SET `trangthai`= 'Sẵn Sàng'
        //     WHERE `id`='{$idtb}'";
        //     $this->conn->query($update);
        // }
        return [
            "status" => "success",
            "message" => "Cập nhật thành công",
            "query" => $query,
            // "" => $queryUpdate
        ];
        // } else {
        //     return [
        //         "status" => "error",
        //         "message" => "Cập nhật thất bại"
        //     ];
        // }
    }
}
