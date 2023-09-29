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
    public function getDataCateModal($id)
    {
        $query = "SELECT * FROM danhmuc WHERE id = $id;";
        $rs = $this->conn->query($query);

        return $rs->fetch_assoc();
    }
    function getDeviceCategories()
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT dm.*, COUNT(tb.madanhmuc) AS so_luong
        FROM danhmuc dm
        LEFT JOIN thietbi tb ON dm.madanhmuc = tb.madanhmuc
        GROUP BY dm.madanhmuc;";
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
    function addDeviceType($ten, $cate)
    {
        $queryLastId = "SELECT COUNT(tb.madanhmuc) AS count
        FROM danhmuc AS dm
        JOIN loaithietbi AS ltb ON dm.madanhmuc = ltb.madanhmuc
        JOIN thietbi AS tb ON ltb.madanhmuc = tb.madanhmuc
        WHERE dm.madanhmuc = '$cate';";
        $rsLastId = $this->conn->query($queryLastId);
        $lastId = $rsLastId->fetch_assoc();
        $ma_loai_thiet_bi = $cate . str_pad($lastId['count'] + 1, 2, "0", STR_PAD_LEFT);
        $query = "INSERT INTO loaithietbi (ten, maloai, madanhmuc) 
        VALUES ( '{$ten}', '{$ma_loai_thiet_bi}', '{$cate}') ";
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
    function addDeviceCate($ten, $cate)
    {
        // $queryLastId = "SELECT COUNT(tb.madanhmuc) AS count
        // FROM danhmuc AS dm
        // JOIN loaithietbi AS ltb ON dm.madanhmuc = ltb.madanhmuc
        // JOIN thietbi AS tb ON ltb.madanhmuc = tb.madanhmuc
        // WHERE dm.madanhmuc = '$cate';";
        // $rsLastId = $this->conn->query($queryLastId);
        // $lastId = $rsLastId->fetch_assoc();
        // $ma_loai_thiet_bi = $cate . str_pad($lastId['count'] + 1, 2, "0", STR_PAD_LEFT);
        $queryCheckName = "SELECT * FROM danhmuc WHERE tendanhmuc = '$ten'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if ($rsCheckName->fetch_assoc()) {
            return [
                "status" => "error",
                "message" => "Tên danh mục đã tồn tại"
            ];
        }
        $queryCheckCode = "SELECT * FROM danhmuc WHERE madanhmuc = '$cate'";
        $rsCheckCode = $this->conn->query($queryCheckCode);
        if ($rsCheckCode->fetch_assoc()) {
            return [
                "status" => "error",
                "message" => "Mã danh mục đã tồn tại"
            ];
        }
        $query = "INSERT INTO danhmuc (tendanhmuc, madanhmuc) 
        VALUES ( '{$ten}', '{$cate}') ";
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
    function editDeviceCate($ten, $madanhmuc, $id)
    {
        $queryCheckName = "SELECT * FROM danhmuc WHERE tendanhmuc = '$ten' AND `id` != '$id'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if (mysqli_num_rows($rsCheckName) > 0) {
            return [
                "status" => "error",
                "message" => "Tên danh mục đã tồn tại"
            ];
        }
        $queryCheckCode = "SELECT * FROM danhmuc WHERE madanhmuc = '$madanhmuc' AND `id` != '$id'";
        $rsCheckCode = $this->conn->query($queryCheckCode);
        if (mysqli_num_rows($rsCheckCode) >= 1) {
            return [
                "status" => "error",
                "message" => "Mã danh mục đã tồn tại"
            ];
        }
        $query = "UPDATE `danhmuc` 
        SET `tendanhmuc`='{$ten}', `madanhmuc` = '{$madanhmuc}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => $queryCheckName
            ];
        } else {
            return [
                "status" => "error",
                "message" => $query
            ];
        }
    }
    function deleteDeviceCate($id)
    {
        $check = "SELECT * FROM thietbi WHERE madanhmuc = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: ../devicetype?msg=2");
            return [
                "status" => "error",
                "message" => "Xóa thất bại có lỗi xảy ra"
            ];
        } else {
            $query = "DELETE FROM danhmuc WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../devicetype?msg=1");
            return [
                "status" => "success",
                "message" => "Xóa thành công",
                "" => $query
            ];
        }
    }
}
