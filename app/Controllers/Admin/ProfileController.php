<?php

require_once('./app/Models/Admin/ProfileModel.php');
require_once('./app/core/Controller.php');

class ProfileController extends Controller
{
    var $profile;
    public function __construct()
    {
        $this->profile = new ProfileModel();
    }

    public function Show()
    {

        $this->view('index', ["page" => "admin/profile"]);
    }
    public function getProfile()
    {
        $id = $_SESSION['id'];
        $response = $this->profile->getProfile($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function password()
    {
        $this->view('index', ["page" => "admin/password"]);
    }
    public function changePass()
    {
        // if (isset($_POST["changePass"])) {
        $id = $_SESSION['id'];
        $currentPass = $_POST['currentPassword'];
        $newPass = $_POST['newPassword'];
        $confirmPass = $_POST['confirmPassword'];

        $response = $this->profile->changePass($id, $currentPass, $newPass, $confirmPass);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function updateUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        // $matkhau  = $_POST['matkhau'];
        $sdt = $_POST['sodienthoai'];
        $taikhoan = $_POST['taikhoan'];
        $diachi = $_POST['diachi'];
        $id  = $_SESSION['id'];

        $response = $this->profile->updateUser($hoten, $email, $sdt, $taikhoan, $diachi, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
