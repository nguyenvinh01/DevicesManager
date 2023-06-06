<?php

require_once "./app/Models/Model.php";
class LoginModel extends Model
{
    function CheckLogin()
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
