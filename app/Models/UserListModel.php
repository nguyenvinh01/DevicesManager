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

    public function addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi)
    {
        $query = "INSERT INTO nguoidung ( hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) 
        VALUES ( '{$hoten}', '{$email}', '{$matkhau}', '{$sdt}', '{$taikhoan}', '{$diachi}', 2) ";
        $result = $this->conn->query($query);
        if ($result) {
            header("Location: ../userlist?msg=1");
        } else {
            header("Location: ../userlist?msg=2");
        }
    }
    public function editUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $id)
    {
        $query = "UPDATE `nguoidung` 
        SET `hoten`='{$hoten}',`email`='{$email}',`sodienthoai`='{$sdt}',`taikhoan`='{$taikhoan}',`diachi`='{$diachi}', `matkhau`='{$matkhau}', `quyen_id`=2
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            header("Location: ../userlist?msg=1");
        } else {
            header("Location: ../userlist?msg=2");
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
            header("Location: taikhoan.php?msg=2");
        } else {
            $query = "DELETE FROM nguoidung WHERE `id`='{$id}'";
            $this->conn->query($query);
            header("Location: ../userlist?msg=1");
        }
    }
}
