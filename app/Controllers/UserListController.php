<?php

require_once('./app/Models/UserListModel.php');
require_once('./app/core/Controller.php');
class UserListController extends Controller
{
    var $userList;
    public function __construct()
    {
        $this->userList = new UserListModel();
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
        $response =  $this->userList->addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi);
        header('Content-Type: application/json');
        echo json_encode($response);
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

        $response =  $this->userList->editUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deleteUser()
    {
        $id  = $_POST['id'];

        $response = $this->userList->deleteUser($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
