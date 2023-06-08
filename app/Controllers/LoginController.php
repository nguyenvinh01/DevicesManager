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
        // require_once('./app/Views/login.php');
        $this->view("Views/login", []);
    }
    public function validLogin()
    {
        if (isset($_POST['login'])) {
            $taikhoan = $_POST['taikhoan'];
            $matkhau  = $_POST['matkhau'];
            // $query = "SELECT * FROM nguoidung WHERE taikhoan='$taikhoan'";
            // // $result = mysqli_query($connect, $query);
            // $num_rows = mysqli_num_rows($result);
            // if ($num_rows == 0) {
            //     header("Location: login.php?fail=1");
            // } else {

            //     $row = mysqli_fetch_array($result);
            //     if ($upass != $row['matkhau']) {
            //         header("Location: login.php?fail=1");
            //     } else {
            //         header("Location: index.php?msg=1");
            //         $_SESSION['taikhoanadmin'] = $taikhoan;
            //         $_SESSION['id'] = $row['id'];
            //         $_SESSION['tenhienthi'] = $row['hoten'];
            //         $_SESSION['quyen'] = $row['quyen_id'];
            //     }
            // }
            $this->login->CheckLogin($taikhoan, $matkhau);
        }
        // require_once('./app/Views/register.php');
        // header("Location: ./dashboard");
    }
}
