<?php

require_once('./app/Models/Admin/DeviceTypeModel.php');
require_once('./app/core/Controller.php');

class DeviceTypeController extends Controller
{
    var $deviceType;
    public function __construct()
    {
        $this->deviceType = new DeviceTypeModel();
    }

    public function Show()
    {

        $dataDeviceType = $this->deviceType->getDeviceType();
        $this->view('index', ["page" => "admin/devicetype", "dataDeviceType" => $dataDeviceType]);
    }
    public function addDeviceType()
    {
        // if (isset($_POST['adddm'])) {
        $ten = $_POST['ten'];

        $response = $this->deviceType->addDeviceType($ten);
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
}
