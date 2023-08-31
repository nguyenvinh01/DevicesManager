<?php

require_once('./app/Models/Auth/VerifyModel.php');
require_once('./app/core/Controller.php');

class VerifyController extends Controller
{
    var $verify;
    public function __construct()
    {
        $this->verify = new VerifyModel();
    }

    function Show()
    {
        $this->view("Views/Auth/resend", []);
    }
    function Code()
    {
        $this->view("Views/Auth/verify", []);
    }
    public function ResendVerify()
    {
        $taikhoan = $_POST['taikhoan'];
        // $matkhau  = $_POST['matkhau'];

        $response = $this->verify->ResendVerify($taikhoan);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function VerifyToken()
    {
        $token = $_GET['token'];
        // $matkhau  = $_POST['matkhau'];

        $response = $this->verify->VerifyToken($token);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
