<?php

require_once('./app/Models/UserListModel.php');
require_once('./app/core/Controller.php');
require_once('./app/Models/Model.php');
class UserListController extends Controller
{
    var $userList;
    // var $conn = new Model();
    public function __construct()
    {
        $this->userList = new UserListModel();
    }

    public function Show()
    {
        $listUser = $this->userList->getUserList();
        $this->view('index', ["listuser" => $listUser, "page" => "userlist"]);
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


    public function search()
    {
        $option = $_GET["option"];
        $keyword = $_GET["keyword"];
        $response = $this->userList->search($option, $keyword);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getData()
    {
        $response = $this->userList->getData();
        // $this->view(["listuser" => $listUser]);
        // $this->view('index', ["listuser" => $listUser, "page" => "userlist"]);
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
    public function exportExcel()
    {
        $response = $this->userList->exportExcel();

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

            $response = [
                'status' => 'success',
                'message' => 'Import thành công',
            ];
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

        // Trả về kết quả dưới dạng JSON
        // header('Content-Type: application/json');
        // echo json_encode($response);
    }
}
