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
    function generateOTP($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $otp;
    }
    function getLastId($table)
    {
        $query = "SELECT MAX(id) AS last_id FROM $table";
        $rs = $this->conn->query($query);
        $id = $rs->fetch_assoc();
        return $id['last_id'];
    }
}
