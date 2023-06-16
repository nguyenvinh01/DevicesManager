<?php

require_once('./app/Models/RegisterModel.php');
class RegisterController extends Controller
{
    var $register;
    public function __construct()
    {
        $this->register = new RegisterModel();
    }

    public function Show()
    {
        // require_once('./app/Views/register.php');
        $this->view("Views/register", []);
    }
    public function registerUser()
    {
        // if (isset($_POST['register'])) {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $sodienthoai  = $_POST['sodienthoai'];
        $diachi = $_POST['diachi'];
        $taikhoan  = $_POST['taikhoan'];
        $matkhau  = $_POST['matkhau'];

        $response = $this->register->Register($hoten, $email, $sodienthoai, $diachi, $taikhoan, $matkhau);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
