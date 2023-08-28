<?php

require_once "./app/Models/User/FindDeviceModel.php";
require_once "./app/core/Controller.php";

class FindDeviceController extends Controller
{

    var $findDevice;
    public function __construct()
    {
        $this->findDevice = new FindDeviceModel();
    }
    function Show()
    {
        $deviceList = $this->findDevice->getDeviceList();
        $locationList = $this->findDevice->getLocation();
        $this->view("index", ["page" => "user/finddevice", "deviceList" => $deviceList, "locationList" => $locationList]);
    }
    public function getDeviceList()
    {
        $response = $this->findDevice->getDeviceList();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getLocation()
    {
        $response = $this->findDevice->getLocation();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function borrowDevice()
    {
        //Mượn thiết bị
        // if (isset($_POST['muontb'])) {
        $idtb = $_POST['id'];
        $ngaymuon = $_POST['ngaymuon'];
        $ngaytra = $_POST['ngaytra'];
        $toanha = $_POST['toanha'];
        $phong = $_POST['phong'];
        $response = $this->findDevice->borrowDevice($idtb, $ngaymuon, $ngaytra, $toanha, $phong);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    function getRoom()
    {
        $id = $_GET['id'];
        $response = $this->findDevice->getRoom($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
