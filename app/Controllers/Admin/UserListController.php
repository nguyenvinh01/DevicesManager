<?php

require_once('./app/Models/Admin/UserListModel.php');
require_once('./app/core/Controller.php');
require_once('./app/Models/Model.php');
class UserlistController extends Controller
{
    var $userList;
    // var $conn = new Model();
    public function __construct()
    {
        $this->userList = new UserListModel();
    }

    public function Show()
    {
        $this->view('index', ["page" => "Admin/userlist"]);
    }

    public function getModalEdit()
    {
        $id = $_POST["id"];

        $response = $this->userList->getModalEdit($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getModalDel()
    {
        $id = $_POST["id"];

        $response = $this->userList->getModalDel($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getUserList()
    {
        $option = $_GET["option"];
        $keyword = $_GET["keyword"];
        $page = $_GET["page"];
        $role = $_GET["role"];
        $response = $this->userList->getUserList($option, $keyword, $page, $role);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $matkhau  = $_POST['matkhau'];
        $sdt = $_POST['sdt'];
        $taikhoan = $_POST['taikhoan'];
        $diachi = $_POST['diachi'];
        $phongban = $_POST['phongban'];
        $response =  $this->userList->addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $phongban);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function editUser()
    {
        $hoten = $_POST['hoten'];
        $email  = $_POST['email'];
        $role  = $_POST['role'];
        $sdt = $_POST['sdt'];
        $taikhoan = $_POST['taikhoan'];
        $diachi = $_POST['diachi'];
        $id  = $_POST['id'];
        $phongban = $_POST['phongban'];

        $response =  $this->userList->editUser($hoten, $email, $sdt, $taikhoan, $diachi, $id, $phongban, $role);
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
    public function getDepartment()
    {
        $response = $this->userList->getDepartment();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function exportExcel()
    {
        $option = $_POST["option"];
        $keyword = $_POST["keyword"];
        $role = $_POST["role"];
        $response = $this->userList->exportExcel($option, $keyword, $role);

        // header('Content-Type: application/json');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="exported_data.xls"');
        echo $response;
    }

    public function importExcel()
    {
        if (!empty($_FILES['excelFile']['tmp_name'])) {
            $excelFile = $_FILES['excelFile']['tmp_name'];

            // Khởi tạo đối tượng model và gọi phương thức để xử lý tệp Excel
            $response = $this->userList->importExcel($excelFile);

            // $response = [
            //     'status' => 'success',
            //     'message' => 'Import thành công',
            // ];
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {

            $response = [
                'status' => 'error',
                'message' => 'Không có tệp Excel được gửi lên',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
