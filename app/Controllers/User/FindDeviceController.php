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
    function borrowDevice()
    {
        //Mượn thiết bị
        // if (isset($_POST['muontb'])) {
        $idtb = $_POST['id'];
        $ngaymuon = $_POST['ngaymuon'];
        $ngaytra = $_POST['ngaytra'];

        $response = $this->findDevice->borrowDevice($idtb, $ngaymuon, $ngaytra);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    // function getLocation() {
    //     $response = $this->findDevice->getLocation();
    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    // }
}
