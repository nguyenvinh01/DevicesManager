<?php

require_once "./app/Models/Model.php";
class DeviceListModel extends Model
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

    function addDevice($ten, $tinhtrang, $soluong, $giatri, $ltb, $dtkt, $image)
    {
        $query = "INSERT INTO thietbi ( ten, hinhanh, soluong, giatri, tinhtrang, loaithietbi_id, dactinhkithuat) 
        VALUES ( '{$ten}', '{$image}', '{$soluong}', '{$giatri}', '{$tinhtrang}', '{$ltb}', '{$dtkt}') ";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công"
            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại"
            ];
        }
    }
    function editDevice($id, $ten, $tinhtrang, $soluong, $giatri, $ltb, $dtkt, $image)
    {
        // $query = "UPDATE `thietbi` 
        // SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
        // WHERE `id`='{$id}'";

        if ($image != null) {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
            WHERE `id`='{$id}'";
        } else {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' 
            WHERE `id`='{$id}'";
        }

        // $query . "WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Sửa thành công"
            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Sửa thất bại"
            ];
        }
    }
    function deleteDevice($id)
    {
        $check = "SELECT thietbi_id FROM muon WHERE thietbi_id = '{$id}'
        UNION ALL
        SELECT thietbi_id FROM suachua WHERE thietbi_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Xóa thất bại"
            ];
        } else {
            $query = "DELETE FROM thietbi WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Xóa thành công"
            ];
        }
    }
}
