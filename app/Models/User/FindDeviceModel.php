<?php

require_once "./app/Models/Model.php";
class FindDeviceModel extends Model
{
    function getDeviceList($keyword, $page, $type, $cate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*,b.ten as 'tenloai'
        FROM thietbi as a,loaithietbi as b, danhmuc as c
        WHERE a.loaithietbi_code = b.maloai AND a.trangthai = 'Sẵn Sàng'  AND b.madanhmuc = c.madanhmuc";
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

        $query .=  " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $location = $this->getLocation();
        return [
            'status' => 'success',
            'data' => $data,
            'location' => $location,
            'count' => count($rsCount->fetch_all())
        ];
    }
    function getMultiDevice($deviceIds)
    {
        $query = "SELECT * FROM thietbi WHERE id IN (" . implode(",", $deviceIds) . ")";
        $rs = $this->conn->query($query);
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            // 'location' => $location,
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function getDataModal($id)
    {
        $query = "SELECT tb.*, ltb.ten as loaitb FROM thietbi as tb, loaithietbi as ltb 
        WHERE tb.id = $id
        ORDER BY id DESC";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return [
            'status' => 'success',
            'data' => $data,
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function getDeviceCategories()
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT dm.*, COUNT(tb.madanhmuc) AS so_luong
        FROM danhmuc dm
        LEFT JOIN thietbi tb ON dm.madanhmuc = tb.madanhmuc
        WHERE tb.trangthai = 'Sẵn Sàng'
        GROUP BY dm.madanhmuc;";
        $queryAll = "SELECT COUNT(*) AS soluong_all
        FROM thietbi as tb
        WHERE trangthai = 'Sẵn Sàng'";
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

    function borrowDevice($idtb, $ngaymuon, $ngaytra, $toanha, $phong, $mathietbi)
    {
        $queryNameBuilding = "SELECT tentoanha FROM toanha WHERE id = $toanha";
        $resultNameBuilding = $this->conn->query($queryNameBuilding);
        $nameBuilding = $resultNameBuilding->fetch_assoc();
        $query = "INSERT INTO muon (thietbi_id, ngaymuon, ngaytra, nguoidung_id, diadiem, trangthai, mathietbi) 
            VALUES ( '{$idtb}', '{$ngaymuon}', '{$ngaytra}', '{$_SESSION["id"]}', '{$nameBuilding['tentoanha']}-{$phong}' , 'Chờ phê duyệt', '$mathietbi');";
        $result = $this->conn->query($query);
        if ($result) {
            $update = "UPDATE `thietbi` 
                SET `trangthai`= 'Đang mượn'
                WHERE `id`='{$idtb}'";
            $this->conn->query($update);
            return [
                "status" => "success",
                "message" => "Mượn thành công. Vui lòng chờ quản lý xét duyệt",
                'query' => $query
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Mượn thất bại. Có lỗi xảy ra",
                'query' => $query

            ];
        }
    }
    function borrowMultiDevice($idtbs, $ngaymuon, $ngaytra, $toanha, $phong)
    {
        $queryLastId = "SELECT MAX(madonmuon) AS count
        FROM muon
        WHERE nguoidung_id = '{$_SESSION["id"]}';";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $madonmuon = "U" . $_SESSION["id"] . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);
        $queryNameBuilding = "SELECT tentoanha FROM toanha WHERE id = $toanha";
        $resultNameBuilding = $this->conn->query($queryNameBuilding);
        $nameBuilding = $resultNameBuilding->fetch_assoc();
        $ids = array();
        $ids = explode(",", $idtbs);
        $queryMultiBorrow = "INSERT INTO muon (thietbi_id, ngaymuon, ngaytra, nguoidung_id, diadiem, trangthai, mathietbi,  madonmuon) VALUES";
        foreach ($ids as $i) {
            $queryMathietbi = "SELECT mathietbi FROM thietbi WHERE id = $i";
            $rs = $this->conn->query($queryMathietbi);
            $mathietbi = $rs->fetch_assoc();
            $queryMultiBorrow .= " ('{$i}', '{$ngaymuon}', '{$ngaytra}', '{$_SESSION["id"]}', '{$nameBuilding['tentoanha']}-{$phong}' , 'Chờ phê duyệt', '{$mathietbi['mathietbi']}', '$madonmuon'),";
        }
        $queryMultiBorrow = rtrim($queryMultiBorrow, ',');
        $ids = implode(',', $ids); // Chuyển mảng ID thành chuỗi, ví dụ: '1,2,3'

        $result = $this->conn->query($queryMultiBorrow);
        if ($result) {
            $update = "UPDATE thietbi SET trangthai = 'Đang mượn' WHERE id IN ($ids)";
            $this->conn->query($update);
            return [
                "status" => "success",
                "message" => "Mượn thành công. Vui lòng chờ quản lý xét duyệt",
                'query' => $queryMultiBorrow
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Mượn thất bại. Có lỗi xảy ra",
                'query' => $queryMultiBorrow

            ];
        }
    }
    function getLocation()
    {
        $query = "SELECT DISTINCT (tn.tentoanha) as toanha, (tn.id) as id_toanha 
        FROM diadiem as dd, toanha as tn
        WHERE tn.id = dd.toanha";
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
    function getRoom($toanha)
    {
        $query = "SELECT phong FROM diadiem WHERE diadiem.toanha = '{$toanha}'";
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
}
