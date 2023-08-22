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

        $dataDeviceList = $this->device->getDeviceList();
        $dataDeviceType = $this->device->getDeviceType();
        $this->view('index', ["page" => "admin/devicelist", "dataDeviceList" => $dataDeviceList, "dataDeviceType" => $dataDeviceType]);
    }
    public function addDevice()
    {
        // if (isset($_POST['addma'])) {
        $ten = $_POST['ten'];
        $tinhtrang = $_POST['tinhtrang'];
        $soluong = $_POST['soluong'];
        $giatri = $_POST['giatri'];
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

        $response = $this->device->addDevice($ten, $tinhtrang, $soluong, $giatri, $ltb, $dtkt, $image);
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
        $giatri = $_POST['giatri'];
        $ltb  = $_POST['ltb'];
        $dtkt  = $_POST['dtkt'];
        $id  = $_POST['id'];
        //Upload ảnh
        $file_name = $_FILES['image']['name'];
        if (empty($file_name)) {

            $response = $this->device->editDevice($id, $ten, $tinhtrang, $soluong, $giatri, $ltb, $dtkt, null);
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
            $response =  $this->device->editDevice($id, $ten, $tinhtrang, $soluong, $giatri, $ltb, $dtkt, $image);
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        // }
    }
    public function deleteDevice()
    {
        // if (isset($_POST['deletema'])) {
        $id  = $_POST['id'];
        $response = $this->device->deleteDevice($id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
