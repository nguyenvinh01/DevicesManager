<?php

require_once "./app/Models/Model.php";
class LoginModel extends Model
{
    function CheckLogin($taikhoan, $matkhau)
    {
        // if (isset($_POST['login'])) {
        // $taikhoan = $_POST['taikhoan'];
        // $upass  = $_POST['matkhau'];
        $query = "SELECT * FROM nguoidung WHERE taikhoan='$taikhoan'";
        // $result = mysqli_query($connect, $query);
        $result = $this->conn->query($query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 0) {
            header("Location: login");
            // header("Location: login.php?fail=1");
        } else {

            $row = mysqli_fetch_array($result);
            if ($matkhau != $row['matkhau']) {
                // header("Location: login.php?fail=1");
                header("Location: login");
            } else {
                header("Location: ../dashboard");
                // header("Location: ./index.php");
                $_SESSION['taikhoanadmin'] = $taikhoan;
                $_SESSION['id'] = $row['id'];
                $_SESSION['tenhienthi'] = $row['hoten'];
                $_SESSION['quyen'] = $row['quyen_id'];
            }
        }
    }
}
