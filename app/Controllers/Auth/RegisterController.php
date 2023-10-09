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
            $token = trim($_GET['token']);
            $response = $this->register->VerifyToken($token);

            $this->view("Views/Auth/verify");

            header('Content-Type: application/json');
            echo json_encode($response);
        }
        $this->view("Views/Auth/verify");
    }
    public function registerUser()
    {
        $hoten = isset($_POST['hoten']) ? trim($_POST['hoten']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $sodienthoai = isset($_POST['sodienthoai']) ? trim($_POST['sodienthoai']) : '';
        $diachi = isset($_POST['diachi']) ? trim($_POST['diachi']) : '';
        $phongban = isset($_POST['phongban']) ? trim($_POST['phongban']) : '';
        $taikhoan = isset($_POST['taikhoan']) ? trim($_POST['taikhoan']) : '';
        $matkhau = isset($_POST['matkhau']) ? trim($_POST['matkhau']) : '';

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
