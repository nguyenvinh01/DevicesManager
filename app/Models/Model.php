<?php
require_once("./app/config/connect.php");
class Model
{
    var $conn;
    function __construct()
    {
        $conn_obj = new connection();
        $this->conn = $conn_obj->conn;
    }
}
