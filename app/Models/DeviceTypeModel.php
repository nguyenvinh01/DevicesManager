<?php

require_once "Model.php";
class DeviceTypeModel extends Model
{
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
    function addDeviceType($ten)
    {
        $query = "INSERT INTO loaithietbi (ten) 
        VALUES ( '{$ten}') ";
        $result = $this->conn->query($query);
        if ($result) {
            header("Location: ../devicetype?msg=1");
        } else {
            header("Location: ../devicetype?msg=2");
        }
    }
    function editDeviceType($ten, $id)
    {
        $query = "UPDATE `loaithietbi` 
        SET `ten`='{$ten}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            header("Location: ../devicetype?msg=1");
        } else {
            header("Location: ../devicetype?msg=2");
        }
    }
    function deleteDeviceType($id)
    {
        $check = "SELECT * FROM thietbi WHERE loaithietbi_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            header("Location: ../devicetype?msg=2");
        } else {
            $query = "DELETE FROM loaithietbi WHERE `id`='{$id}'";
            $this->conn->query($query);
            header("Location: ../devicetype?msg=1");
        }
    }
}
