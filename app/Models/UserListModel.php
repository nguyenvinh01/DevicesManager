<?php

require_once "Model.php";
class UserListModel extends Model
{
    public function getUserList()
    {
        $query = "SELECT *
            FROM nguoidung 
            WHERE quyen_id = 2
            ORDER BY id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // public function addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi)
    // {
    //     $query = "INSERT INTO nguoidung ( hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) 
    //     VALUES ( '{$hoten}', '{$email}', '{$matkhau}', '{$sdt}', '{$taikhoan}', '{$diachi}', 2) ";
    //     $result = $this->conn->query($query);
    //     if ($result) {
    //         // header("Location: ../userlist?msg=1");
    //         return [
    //             'status' => 'success',
    //             'message' => 'Thông tin người dùng đã được cập nhật.'
    //         ];
    //     } else {
    //         // header("Location: ../userlist?msg=2");
    //         return [
    //             'status' => 'error',
    //             'message' => 'Thông tin người dùng đã được cập nhật loi.'
    //         ];
    //     }
    // }
    public function addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi)
    {
        // Kiểm tra trùng email
        $emailExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE email = '{$email}'";
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
        $taikhoanExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE taikhoan = '{$taikhoan}'";
        $taikhoanExistsResult = $this->conn->query($taikhoanExistsQuery);
        $taikhoanExists = $taikhoanExistsResult->fetch_assoc();
        $taikhoanCount = $taikhoanExists['count'];

        if ($taikhoanCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản đã tồn tại trong hệ thống.'
            ];
        }

        // Thực hiện câu lệnh INSERT
        $insertQuery = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) 
                    VALUES ('{$hoten}', '{$email}', '{$matkhau}', '{$sdt}', '{$taikhoan}', '{$diachi}', 2)";
        $result = $this->conn->query($insertQuery);

        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được cập nhật.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình thêm người dùng.'
            ];
        }
    }
    public function editUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $id)
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
                SET `hoten`='{$hoten}',`email`='{$email}',`sodienthoai`='{$sdt}',`taikhoan`='{$taikhoan}',`diachi`='{$diachi}', `matkhau`='{$matkhau}', `quyen_id`=2
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

    public function deleteUser($id)
    {
        $check = "SELECT nguoidung_id FROM muon WHERE nguoidung_id = '{$id}'
        UNION ALL
        SELECT nguoidung_id FROM suco WHERE nguoidung_id = '{$id}'
        UNION ALL
        SELECT nguoidung_id FROM suachua WHERE nguoidung_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: taikhoan.php?msg=2");
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình xóa.'
            ];
        } else {
            $query = "DELETE FROM nguoidung WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../userlist?msg=1");
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được xóa.'
            ];
        }
    }
}
