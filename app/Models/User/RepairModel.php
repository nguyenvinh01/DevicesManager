<?php

require_once "./app/Models/Model.php";
class RepairModel extends Model
{
    function getRepairList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*, c.ten AS tentb
            FROM suachua AS a
            INNER JOIN thietbi AS c ON a.thietbi_id = c.id
            WHERE 1=1"; // Sử dụng điều kiện "1=1" để có thể thêm các điều kiện một cách linh hoạt

        if ($filter == '') {
            $query .= " AND a.nguoidung_id = '{$_SESSION['id']}'";
        }
        if ($status != '') {
            $query .= " AND a.tinhtrang = '$status'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND a.ngaygui <= '$eDate' AND a.ngaygui >= '$sDate'";
        }
        if ($filter == 'nguoisuachua') {
            $query .= " AND EXISTS (SELECT 1 FROM nguoidung AS b WHERE b.id = a.phancong AND b.quyen_id = 3 AND b.hoten LIKE '%$keyword%')";
        } elseif ($filter == 'thietbi') {
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
            'count' => $queryCount
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
        ];
    }
    public function getDataModal($id)
    {
        $queryDevice = "SELECT m.*, t.ten  FROM muon as m, thietbi as t WHERE m.nguoidung_id = $id AND m.thietbi_id = t.id";
        $rsDevice = $this->conn->query($queryDevice);
        $dataDevice = array();
        while ($row = $rsDevice->fetch_assoc()) {
            $dataDevice[] = $row;
        }
        return [
            'staff' => $dataDevice,
        ];
    }
    function sendRepair($idtb, $noidung)
    {
        $query = "INSERT INTO suachua (thietbi_id, noidung, nguoidung_id, tinhtrang) 
            VALUES ( '{$idtb}', '{$noidung}','{$_SESSION['id']}', 'Chờ xử lý') ";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../repair?msg=1");
            return [
                "status" => "success",
                "message" => "Gửi thành công"
            ];
        } else {
            // header("Location: ../repair?msg=2");
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi gửi"
            ];
        }
    }
    function confirmRepair($thoigian, $chiphi, $id)
    {
        $query = "UPDATE `suachua` 
        SET `chiphi`='{$chiphi}', `thoigian`='{$thoigian}', `tinhtrang`='Đã xử lý'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../repair?msg=1");
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            // header("Location: ../repair?msg=2");
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi cập nhật"
            ];
        }
    }
}
