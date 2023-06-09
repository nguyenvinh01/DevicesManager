<?php

require_once('./app/Models/UserListModel.php');
require_once('./app/core/Controller.php');
class UserListController extends Controller
{
    var $userList;
    public function __construct()
    {
        $this->userList = new UserListModel();
        // $userList = $this->model("UserList");
    }

    public function Show()
    {
        $listUser = $this->userList->getUserList();
        $this->view('index', ["listuser" => $listUser, "page" => "userlist"]);
    }

    public function addUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $matkhau  = $_POST['matkhau'];
        $sdt = $_POST['sdt'];
        $taikhoan = $_POST['taikhoan'];
        $diachi = $_POST['diachi'];
        $this->userList->addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi);
    }

    public function editUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $matkhau  = $_POST['matkhau'];
        $sdt = $_POST['sdt'];
        $taikhoan = $_POST['taikhoan'];
        $diachi = $_POST['diachi'];
        $id  = $_POST['id'];

        $this->userList->editUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $id);
    }

    public function deleteUser()
    {
        $id  = $_POST['id'];
        $this->userList->deleteUser($id);
    }
}
