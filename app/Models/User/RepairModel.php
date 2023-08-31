<?php

require_once "./app/Models/Model.php";
class RepairModel extends Model
{
    function getRepairList($id)
    {

        $query = "SELECT a.*, c.ten as tentb
            FROM suachua as a, thietbi as c
            WHERE a.nguoidung_id = '{$id}'
            AND a.thietbi_id = c.id
            ORDER BY a.id DESC";
        $rs = $this->conn->query($query);
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
            'staff' => $dataStaff
            // 'count' => count($rsCount->fetch_all())
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
