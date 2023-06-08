<?php

require_once "Model.php";
class UserListModel extends Model
{
    public function getUserList()
    {
        $query = "SELECT *
            FROM nguoidung 
            WHERE quyen_id = 2
            ORDER BY id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
