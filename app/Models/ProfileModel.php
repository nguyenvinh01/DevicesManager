<?php
require_once './app/config/constant.php';
require_once "./app/Models/Model.php";

class ProfileModel extends Model
{
    function getProfile($id)
    {
        $query = "SELECT *
        FROM nguoidung 
        WHERE id = $id";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        // $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function changePass($id, $currentPass, $newPass, $confirmPass)
    {
        if ($newPass != $confirmPass) {
            return [
                'status' => 'error',
                'message' => 'Mật khẩu nhập lại không khớp.'
            ];
        }
        $query = "SELECT matkhau FROM nguoidung WHERE `id` = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        $checkPassword = password_verify($currentPass, $data['matkhau']);
        $hashPassword = $this->hashPassword($newPass);

        if ($checkPassword) {
            $sql = "UPDATE nguoidung set matkhau = '$hashPassword' WHERE `id` = $id;";
            $this->conn->query($sql);
            unset($_SESSION['taikhoanadmin']);
            session_destroy();
            return [
                'status' => 'success',
                'redirect' => BASE_URL . '/login'
            ];
        } else {
            //     // header("Location: " . BASE_URL . "\dashboard");
            return [
                'status' => 'error',
                'message' => 'Mật khẩu ban đầu không đúng.'
            ];
        }
    }
    public function updateUser($hoten, $email,  $sdt, $taikhoan, $diachi, $id)
    {
        // Kiểm tra trùng email
        $emailExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE email = '{$email}' AND id != '{$id}'";
        $emailExistsResult = $this->conn->query($emailExistsQuery);
        $emailExists = $emailExistsResult->fetch_assoc();
        $emailCount = $emailExists['count'];
        if ($emailCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Email đã tồn tại trong hệ thống.'
            ];
        }

        // Kiểm tra trùng tài khoản
        $taikhoanExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE taikhoan = '{$taikhoan}' AND id != '{$id}'";
        $taikhoanExistsResult = $this->conn->query($taikhoanExistsQuery);
        $taikhoanExists = $taikhoanExistsResult->fetch_assoc();
        $taikhoanCount = $taikhoanExists['count'];
        if ($taikhoanCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản đã tồn tại trong hệ thống.'
            ];
        }

        // Thực hiện câu lệnh UPDATE
        $query = "UPDATE `nguoidung` 
                SET `hoten`='{$hoten}',`email`='{$email}',`sodienthoai`='{$sdt}',`taikhoan`='{$taikhoan}',`diachi`='{$diachi}'
                WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được cập nhật.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật người dùng.'
            ];
        }
    }
}
