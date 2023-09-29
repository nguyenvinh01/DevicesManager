<?php

require_once('./app/Models/Auth/ForgetModel.php');
require_once('./app/core/Controller.php');

class ForgetController extends Controller
{
    var $forget;
    public function __construct()
    {
        $this->forget = new ForgetModel();
    }

    function Show()
    {
        $this->view("Views/Auth/forget", []);
    }
    public function ForgetPassword()
    {
        $taikhoan = $_POST['taikhoan'];
        // $matkhau  = $_POST['matkhau'];

        $response = $this->forget->ForgetPassword($taikhoan);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
