<?php

require_once "./app/Models/Model.php";
class FindDeviceModel extends Model
{
    function getDeviceList()
    {
        $query = "SELECT a.*,b.ten as 'tenloai'
        FROM thietbi as a,loaithietbi as b
        WHERE a.loaithietbi_id = b.id 
        ORDER BY a.id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getDeviceType()
    {
        $query = "SELECT * FROM loaithietbi Order by id desc";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function borrowDevice($idtb, $ngaymuon, $ngaytra)
    {
        $query = "INSERT INTO muon (thietbi_id, ngaymuon, ngaytra, nguoidung_id, trangthai) 
            VALUES ( '{$idtb}', '{$ngaymuon}', '{$ngaytra}', '{$_SESSION["id"]}', 'Chờ phê duyệt') ";
        $result = $this->conn->query($query);
        if ($result) {
            $update = "UPDATE `thietbi` 
                SET `soluong`= soluong - 1
                WHERE `id`='{$idtb}'";
            $this->conn->query($update);
            // header("Location: ../finddevice?msg=1");
            return [
                "status" => "success",
                "message" => "Mượn thành công. Vui lòng chờ quản lý xét duyệt"
            ];
        } else {
            // header("Location: ../finddevice?msg=2");
            return [
                "status" => "success",
                "message" => "Mượn thất bại. Có lỗi xảy ra"
            ];
        }
    }
    function getLocation()
    {
        $query = "SELECT * FROM diadiem";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
