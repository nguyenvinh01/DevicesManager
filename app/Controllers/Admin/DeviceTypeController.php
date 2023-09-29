<?php

require_once('./app/Models/Admin/DeviceTypeModel.php');
require_once('./app/core/Controller.php');

class DevicetypeController extends Controller
{
    var $deviceType;
    public function __construct()
    {
        $this->deviceType = new DeviceTypeModel();
    }

    public function Show()
    {

        $dataDeviceType = $this->deviceType->getDeviceType();
        $this->view('index', ["page" => "Admin/devicetype", "dataDeviceType" => $dataDeviceType]);
    }
    public function getDataModal()
    {
        $id = $_GET["id"];
        $response = $this->deviceType->getDataModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataCateModal()
    {
        $id = $_GET["id"];
        $response = $this->deviceType->getDataCateModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceType()
    {
        $response = $this->deviceType->getDeviceType();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceCategories()
    {
        $response = $this->deviceType->getDeviceCategories();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addDeviceType()
    {
        // if (isset($_POST['adddm'])) {
        $ten = $_POST['ten'];
        $cate = $_POST['categories'];

        $response = $this->deviceType->addDeviceType($ten, $cate);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function addDeviceCate()
    {
        // if (isset($_POST['adddm'])) {
        $ten = $_POST['tendanhmuc'];
        $code = $_POST['madanhmuc'];

        $response = $this->deviceType->addDeviceCate($ten, $code);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function editDeviceType()
    {
        // if (isset($_POST['editdm'])) {
        $ten = $_POST['ten'];
        $id  = $_POST['id'];

        $response = $this->deviceType->editDeviceType($ten, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function deleteDeviceType()
    {
        // if (isset($_POST['deletedm'])) {
        $id  = $_POST['id'];
        $response = $this->deviceType->deleteDeviceType($id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function editDeviceCate()
    {
        // if (isset($_POST['editdm'])) {
        $ten = $_POST['tendanhmuc'];
        $ma = $_POST['madanhmuc'];
        $id  = $_POST['id'];

        $response = $this->deviceType->editDeviceCate($ten, $ma, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function deleteDeviceCate()
    {
        // if (isset($_POST['deletedm'])) {
        $id  = $_POST['id'];
        $response = $this->deviceType->deleteDeviceCate($id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
