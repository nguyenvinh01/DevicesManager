<?php

require_once('./app/Models/User/ProfileModel.php');
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
        $id = $_SESSION['id'];
        $dataProfile = $this->profile->getProfile($id);
        $this->view('index', ["page" => "user/profile", "dataProfile" => $dataProfile]);
        // $this->view('index', ["page" => "password"]);
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
        $this->view('index', ["page" => "user/password"]);
    }
    public function changePass()
    {
        // if (isset($_POST["changePass"])) {
        $id = $_SESSION['id'];
        $currentPass = $_POST['currentPassword'];
        $newPass = $_POST['newPassword'];
        $confirmPass = $_POST['confirmPassword'];

        $response = $this->profile->changePass($id, $currentPass, $newPass, $confirmPass);
        // }
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
