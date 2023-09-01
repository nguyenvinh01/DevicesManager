<?php

require_once "./app/Models/Model.php";
class FindDeviceModel extends Model
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
            $query .= " AND a.loaithietbi_id = '$type'";
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

    function borrowDevice($idtb, $ngaymuon, $ngaytra, $toanha, $phong)
    {
        $queryNameBuilding = "SELECT tentoanha FROM toanha WHERE id = $toanha";
        $resultNameBuilding = $this->conn->query($queryNameBuilding);
        $nameBuilding = $resultNameBuilding->fetch_assoc();
        $query = "INSERT INTO muon (thietbi_id, ngaymuon, ngaytra, nguoidung_id, diadiem, trangthai) 
            VALUES ( '{$idtb}', '{$ngaymuon}', '{$ngaytra}', '{$_SESSION["id"]}', '{$nameBuilding['tentoanha']}-{$phong}' , 'Chờ phê duyệt');";
        $result = $this->conn->query($query);
        if ($result) {
            $update = "UPDATE `thietbi` 
                SET `soluong`= soluong - 1
                WHERE `id`='{$idtb}'";
            $this->conn->query($update);
            return [
                "status" => "success",
                "message" => "Mượn thành công. Vui lòng chờ quản lý xét duyệt",
                'query' => $query
            ];
        } else {
            return [
                "status" => "success",
                "message" => "Mượn thất bại. Có lỗi xảy ra"
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
