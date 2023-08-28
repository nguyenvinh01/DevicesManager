<?php

require_once "./app/Models/Model.php";
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
        return [
            'status' => 'success',
            'data' => $data,
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM loaithietbi WHERE id = $id;";
        $rs = $this->conn->query($query);

        return $rs->fetch_assoc();
    }
    function addDeviceType($ten)
    {
        $query = "INSERT INTO loaithietbi (ten) 
        VALUES ( '{$ten}') ";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicetype?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công"
            ];
        } else {
            // header("Location: ../devicetype?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại có lỗi xảy ra"
            ];
        }
    }
    function editDeviceType($ten, $id)
    {
        $query = "UPDATE `loaithietbi` 
        SET `ten`='{$ten}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Sửa thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Sửa thất bại có lỗi xảy ra"
            ];
        }
    }
    function deleteDeviceType($id)
    {
        $check = "SELECT * FROM thietbi WHERE loaithietbi_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: ../devicetype?msg=2");
            return [
                "status" => "error",
                "message" => "Xóa thất bại có lỗi xảy ra"
            ];
        } else {
            $query = "DELETE FROM loaithietbi WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../devicetype?msg=1");
            return [
                "status" => "success",
                "message" => "Xóa thành công"
            ];
        }
    }
}
