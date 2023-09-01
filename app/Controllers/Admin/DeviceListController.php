<?php

require_once('./app/Models/Admin/DeviceListModel.php');
require_once('./app/core/Controller.php');

class DeviceListController extends Controller
{
    var $device;
    public function __construct()
    {
        $this->device = new DeviceListModel();
    }

    public function Show()
    {
        $this->view('index', ["page" => "admin/devicelist"]);
    }
    public function getDeviceList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $type = $_GET['type'];
        $response = $this->device->getDeviceList($keyword, $page, $type);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataModal()
    {
        $id = $_GET["id"];
        $response = $this->device->getDataModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getDeviceType()
    {
        $response = $this->device->getDeviceType();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addDevice()
    {
        // if (isset($_POST['addma'])) {
        $ten = $_POST['ten'];
        $tinhtrang = $_POST['tinhtrang'];
        $soluong = $_POST['soluong'];
        // $giatri = $_POST['giatri'];
        $ltb  = $_POST['ltb'];
        $dtkt  = $_POST['dtkt'];
        //Upload ảnh
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_parts = explode('.', $_FILES['image']['name']);
        $file_ext = strtolower(end($file_parts));
        $expensions = array("jpeg", "jpg", "png");
        $image = $_FILES['image']['name'];
        $target = "./uploads/image/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $response = $this->device->addDevice($ten, $tinhtrang, $soluong, $ltb, $dtkt, $image);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function editDevice()
    {
        // if (isset($_POST['editma'])) {
        $ten = $_POST['ten'];
        $tinhtrang = $_POST['tinhtrang'];
        $soluong = $_POST['soluong'];
        // $giatri = $_POST['giatri'];
        $ltb  = $_POST['ltb'];
        $dtkt  = $_POST['dtkt'];
        $id  = $_POST['id'];
        //Upload ảnh
        $file_name = $_FILES['image']['name'];
        if (empty($file_name)) {

            $response = $this->device->editDevice($id, $ten, $tinhtrang, $soluong, $ltb, $dtkt, null);
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_parts = explode('.', $_FILES['image']['name']);
            $file_ext = strtolower(end($file_parts));
            $expensions = array("jpeg", "jpg", "png");
            $image = $_FILES['image']['name'];
            $target = "./uploads/image/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $response =  $this->device->editDevice($id, $ten, $tinhtrang, $soluong, $ltb, $dtkt, $image);
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        // }
    }
    public function deleteDevice()
    {
        $id  = $_POST['id'];
        $response = $this->device->deleteDevice($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
