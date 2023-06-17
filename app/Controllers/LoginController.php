<?php

require_once('./app/Models/LoginModel.php');
require_once('./app/core/Controller.php');

class LoginController extends Controller
{
    var $login;
    public function __construct()
    {
        $this->login = new LoginModel();
    }

    function Show()
    {
        $this->view("Views/login", []);
    }
    public function validLogin()
    {
        $taikhoan = $_POST['taikhoan'];
        $matkhau  = $_POST['matkhau'];

        $response = $this->login->CheckLogin($taikhoan, $matkhau);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
