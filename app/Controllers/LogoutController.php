<?php

require_once('./app/core/Controller.php');

class LogoutController extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION['taikhoanadmin'])) {
            unset($_SESSION['taikhoanadmin']); // xóa session login
            session_destroy();
            header("Location: login");
        }
    }
}
