<?php

require_once "./app/Models/Model.php";
class RegisterModel extends Model
{
    function Register($hoten, $email, $sodienthoai, $diachi, $taikhoan, $matkhau)
    {
        $query = "INSERT INTO nguoidung ( hoten, email, sodienthoai, diachi, taikhoan, matkhau, quyen_id) VALUES ( '{$hoten}', '{$email}', '{$sodienthoai}', '{$diachi}', '{$taikhoan}', '{$matkhau}', 2) ";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Đăng ký thành công',
            ];
            // header("Location: login.php?msg=1");
        } else {
            return [
                'status' => 'error',
                'message' => 'Đăng ký không thành công',
            ];
            // header("Location: register.php?msg=2");
        }
    }
}
