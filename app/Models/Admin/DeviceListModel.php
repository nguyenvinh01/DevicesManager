<?php

require_once "./app/Models/Model.php";
class DeviceListModel extends Model
{
    function getDeviceList($keyword, $page, $type, $cate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*, b.ten as 'tenloai'
        FROM thietbi as a,loaithietbi as b, danhmuc as c
        WHERE a.loaithietbi_code = b.maloai AND b.madanhmuc = c.madanhmuc";

        if ($keyword != '') {
            $query .= " AND a.ten LIKE '%$keyword%'";
        }
        if ($type != '') {
            $query .= " AND a.loaithietbi_code = '$type'";
        }
        if ($cate != '') {
            $query .= " AND a.madanhmuc = '$cate' AND c.madanhmuc = '$cate'";
        }
        $queryCount = $query;

        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryDevicetype = "SELECT lt.*, COUNT(tb.id) AS so_luong
        FROM loaithietbi lt
        LEFT JOIN thietbi tb ON lt.maloai = tb.loaithietbi_code
        WHERE lt.madanhmuc = '$cate'
        GROUP BY lt.maloai;";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        // $lastId = $this->getLastId('thietbi');
        // return $data;
        return [
            'status' => 'success',
            'data' => $data,
            'devicetype' => $dataType,
            'count' => count($rsCount->fetch_all()),
            'categories' => $this->getDeviceCategories()
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function getDeviceType($cate)
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT lt.*, COUNT(tb.id) AS so_luong
        FROM loaithietbi lt
        LEFT JOIN thietbi tb ON lt.maloai = tb.loaithietbi_code
        WHERE lt.madanhmuc = '$cate'
        GROUP BY lt.ten;";
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
    function getDeviceCategories()
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT dm.*, COUNT(tb.madanhmuc) AS so_luong
        FROM danhmuc dm
        LEFT JOIN thietbi tb ON dm.madanhmuc = tb.madanhmuc
        GROUP BY dm.madanhmuc;";
        $queryAll = "SELECT COUNT(*) AS soluong_all
        FROM thietbi as tb";
        $rs = $this->conn->query($query);
        $rsAll = $this->conn->query($queryAll);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'all' => $rsAll->fetch_assoc()
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        $queryDevicetype = "SELECT * FROM loaithietbi WHERE madanhmuc = '{$data['madanhmuc']}'";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        $queryDevicecate = "SELECT * FROM danhmuc";
        $rsCate = $this->conn->query($queryDevicecate);
        $dataCate = array();
        while ($row = $rsCate->fetch_assoc()) {
            $dataCate[] = $row;
        }
        return [
            'data' => $data,
            'devicetype' => $dataType,
            'cate' => $dataCate
        ];
    }

    function addDevice($ten, $tinhtrang, $ltb, $dtkt, $image, $cate)
    {
        $queryLastId = "SELECT MAX(mathietbi) AS count
        FROM thietbi
        WHERE madanhmuc = '$cate' AND loaithietbi_code = '$ltb';";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $ma_thiet_bi = $ltb . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);

        $query = "INSERT INTO thietbi ( ten, hinhanh, tinhtrang, loaithietbi_code, dactinhkithuat, mathietbi, madanhmuc, trangthai) 
        VALUES ( '{$ten}', '{$image}', '{$tinhtrang}', '{$ltb}', '{$dtkt}', '{$ma_thiet_bi}', '{$cate}', 'Sẵn Sàng') ";


        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công",
                "query" => $query,
                "last" => $queryLastId

            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại",
                "query" => $query,
                "last" => $queryLastId
            ];
        }
    }
    function duplicateDevice($id, $ten, $tinhtrang, $ltb, $dtkt, $image, $cate)
    {
        $imageTb = $image;
        $queryLastId = "SELECT MAX(mathietbi) AS count
        FROM thietbi
        WHERE madanhmuc = '$cate' AND loaithietbi_code = '$ltb';";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $ma_thiet_bi = $ltb . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);
        if ($image == null) {
            $queryImage = "SELECT hinhanh FROM thietbi WHERE id = $id";
            $rsImage = $this->conn->query($queryImage)->fetch_assoc();

            $imageTb = $rsImage['hinhanh'];
        }
        $query = "INSERT INTO thietbi ( ten, hinhanh, tinhtrang, loaithietbi_code, dactinhkithuat, mathietbi, madanhmuc, trangthai) 
        VALUES ( '{$ten}', '{$imageTb}', '{$tinhtrang}', '{$ltb}', '{$dtkt}', '{$ma_thiet_bi}', '{$cate}', 'Sẵn Sàng') ";


        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công",
                "query" => $query,
                "last" => $queryLastId

            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại",
                "query" => $query,
                "last" => $queryLastId
            ];
        }
    }
    function editDevice($id, $ten, $tinhtrang, $ltb, $dtkt, $image, $cate)
    {
        // $query = "UPDATE `thietbi` 
        // SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
        // WHERE `id`='{$id}'";

        if ($image != null) {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`dactinhkithuat`='{$dtkt}', `tinhtrang`='{$tinhtrang}', `loaithietbi_code`='{$ltb}' , `hinhanh`='{$image}', `madanhmuc` = '{$cate}' 
            WHERE `id`='{$id}'";
        } else {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}', `dactinhkithuat`='{$dtkt}', `tinhtrang`='{$tinhtrang}', `loaithietbi_code`='{$ltb}', `madanhmuc` = '{$cate}' 
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
                "message" => "Sửa thất bại",
                "query" => $query
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
    function getDeviceTypeCode($id)
    {
        $query = "SELECT maloai FROM loaithietbi WHERE id = $id";
        $result = $this->conn->query($query);
        $maloai = $result->fetch_assoc();
        return $maloai['maloai'];
    }
}
