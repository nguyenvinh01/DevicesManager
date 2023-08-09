<?php
require_once("./app/config/connect.php");

class Model
{
    var $conn;
    var $hashPassword;
    function __construct()
    {
        $conn_obj = new connection();
        $this->conn = $conn_obj->conn;
    }
    public function hashPassword($pass)
    {
        $options = ['cost' => 12];
        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT,  $options);
        return $hashedPassword;
    }
}
