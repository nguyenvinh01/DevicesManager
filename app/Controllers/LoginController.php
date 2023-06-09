<?php

require_once('./app/Models/LoginModel.php');
require_once('./app/core/Controller.php');

class LoginController extends Controller
{
    var $login;
    public function __construct()
    {
        $this->login = new LoginModel();
        // $this->login = $this->model("Login");
    }

    function Show()
    {
        $this->view("Views/login", []);
    }
    public function validLogin()
    {
        if (isset($_POST['login'])) {
            $taikhoan = $_POST['taikhoan'];
            $matkhau  = $_POST['matkhau'];
            $this->login->CheckLogin($taikhoan, $matkhau);
        }
    }
}
