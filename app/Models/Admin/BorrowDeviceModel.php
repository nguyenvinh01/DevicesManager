<?php

require_once "./app/Models/Model.php";
class BorrowDeviceModel extends Model
{
    function getBorrowDeviceList()
    {
        $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id
        ORDER BY a.id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    function updateBorrowStatus($tinhtrang, $idtb, $id)
    {
        $query = "UPDATE `muon` 
        SET `trangthai`='{$tinhtrang}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            if ($tinhtrang == "Đã trả" || $tinhtrang == "Bị từ chối") {
                $update = "UPDATE `thietbi` 
                SET `soluong`= soluong + 1
                WHERE `id`='{$idtb}'";
                $this->conn->query($update);
            }
            // header("Location: ../borrowdevice?msg=1");
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            // header("Location: ../borrowdevice?msg=2");
            return [
                "status" => "error",
                "message" => "Cập nhật thất bại"
            ];
        }
    }
}
