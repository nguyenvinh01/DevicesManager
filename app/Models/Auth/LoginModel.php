<?php

require_once "./app/Models/Model.php";
require_once './app/config/constant.php';

class LoginModel extends Model
{
    function CheckLogin($taikhoan, $matkhau)
    {
        $query = "SELECT * FROM nguoidung WHERE BINARY taikhoan = '$taikhoan'";
        $result = $this->conn->query($query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 0) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại',
            ];
        } else {

            $row = mysqli_fetch_array($result);
            if ($row['verified'] == 0) {
                return [
                    'status' => 'error',
                    'message' => 'Bạn chưa xác thực email',
                ];
            }
            $checkPassword = password_verify($matkhau, $row['matkhau']);
            if (!$checkPassword) {
                return [
                    'status' => 'error',
                    'message' => 'Mật khẩu không đúng',
                ];
            } else {
                $_SESSION['taikhoanadmin'] = $taikhoan;
                $_SESSION['id'] = $row['id'];
                $_SESSION['tenhienthi'] = $row['hoten'];
                $_SESSION['quyen'] = $row['quyen_id'];
                return [
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công',
                ];
            }
        }
    }
}
