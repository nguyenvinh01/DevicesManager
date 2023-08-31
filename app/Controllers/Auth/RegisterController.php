<?php

require_once('./app/Models/Auth/RegisterModel.php');
class RegisterController extends Controller
{
    var $register;
    public function __construct()
    {
        $this->register = new RegisterModel();
    }

    public function Show()
    {
        $this->view("Views/Auth/register");
    }
    public function Verify()
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $response = $this->register->VerifyToken($token);

            $this->view("Views/Auth/verify");

            header('Content-Type: application/json');
            echo json_encode($response);
        }
        $this->view("Views/Auth/verify");
    }
    public function registerUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $sodienthoai  = $_POST['sodienthoai'];
        $diachi = $_POST['diachi'];
        $phongban = $_POST['phongban'];
        $taikhoan  = $_POST['taikhoan'];
        $matkhau  = $_POST['matkhau'];

        $response = $this->register->Register($hoten, $email, $sodienthoai, $diachi, $taikhoan, $matkhau, $phongban);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDepartment()
    {
        $response = $this->register->getDepartment();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
