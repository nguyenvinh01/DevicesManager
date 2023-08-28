<?php

require_once "./app/Models/Model.php";
class AssignModel extends Model
{
    function getRepairList($id)
    {
        if ($_SESSION['quyen'] == 1) {
            $query = "SELECT a.*, b.hoten, c.ten as tentb
            FROM suachua as a, nguoidung as b, thietbi as c
            WHERE a.nguoidung_id = b.id
            AND a.thietbi_id = c.id
            ORDER BY a.id DESC";
        } else {
            $query = "SELECT a.*, c.ten as tentb
            FROM suachua as a, thietbi as c
            WHERE a.nguoidung_id = '{$id}'
            AND a.thietbi_id = c.id
            ORDER BY a.id DESC";
        }
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    function getDeviceType()
    {
        $query = "SELECT * FROM thietbi WHERE id IN (Select thietbi_id From muon WHere nguoidung_id = '{$_SESSION['id']}' AND trangthai = 'Đang mượn')";
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
