<?php

require_once "./app/Models/Model.php";
class DeviceListModel extends Model
{
    function getDeviceList($keyword, $page, $type)
    {
        $offset = $page * 5;

        $query = "SELECT a.*,b.ten as 'tenloai'
        FROM thietbi as a,loaithietbi as b
        WHERE a.loaithietbi_id = b.id";

        if ($keyword != '') {
            $query .= " AND a.ten LIKE '%$keyword%'";
        }
        if ($type != '') {
            $query .= " AND a.loaithietbi_id = $type";
        }
        $queryCount = $query;

        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryDevicetype = "SELECT * FROM loaithietbi Order by id desc";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        // return $data;
        return [
            'status' => 'success',
            'data' => $data,
            'devicetype' => $dataType,
            'count' => count($rsCount->fetch_all())

            // 'count' => count($rsCount->fetch_all())
        ];
    }
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
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $queryDevicetype = "SELECT * FROM loaithietbi Order by id desc";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        return [
            'data' => $rs->fetch_assoc(),
            'devicetype' => $dataType
        ];
    }
    function addDevice($ten, $tinhtrang, $soluong, $ltb, $dtkt, $image)
    {
        $query = "INSERT INTO thietbi ( ten, hinhanh, soluong, tinhtrang, loaithietbi_id, dactinhkithuat) 
        VALUES ( '{$ten}', '{$image}', '{$soluong}',  '{$tinhtrang}', '{$ltb}', '{$dtkt}') ";
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
    function editDevice($id, $ten, $tinhtrang, $soluong, $ltb, $dtkt, $image)
    {
        // $query = "UPDATE `thietbi` 
        // SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
        // WHERE `id`='{$id}'";

        if ($image != null) {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
            WHERE `id`='{$id}'";
        } else {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' 
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
                "message" => "Xóa thất bại",
                "query" => $check
            ];
        } else {
            $query = "DELETE FROM thietbi WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Xóa thành công",
                "query" => $check

            ];
        }
    }
}
