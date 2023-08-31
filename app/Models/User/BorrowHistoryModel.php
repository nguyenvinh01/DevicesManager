<?php

require_once "./app/Models/Model.php";
class BorrowHistoryModel extends Model
{
    function getBorrowHistoryList()
    {
        $query = "SELECT a.*,b.ten, b.hinhanh
        FROM muon as a,thietbi as b
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = '{$_SESSION["id"]}'
        ORDER BY a.id DESC";
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
}
