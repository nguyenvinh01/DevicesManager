<?php

require_once "./app/Models/Model.php";
class BorrowHistoryModel extends Model
{
    function getBorrowHistoryList($keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*,b.ten, b.hinhanh
        FROM muon as a,thietbi as b
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = '{$_SESSION["id"]}'";
        if ($status != '') {
            $query .= " AND trangthai = '$status'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND ngaytra <= '$eDate' AND ngaymuon >= '$sDate'";
        }
        if ($keyword != '') {
            $query .= " AND b.ten LIKE '%$keyword%'";
        }
        $queryCount = $query;
        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'count' => count($rsCount->fetch_all())
        ];
    }
    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
}
