<?php

require_once('./app/Models/Admin/BorrowDeviceModel.php');
require_once('./app/core/Controller.php');

class BorrowDeviceController extends Controller
{
    var $device;
    public function __construct()
    {
        $this->device = new BorrowDeviceModel();
    }

    public function Show()
    {

        $dataBorrowDeviceList = $this->device->getBorrowDeviceList();
        $this->view('index', ["page" => "admin/borrow", "dataBorrowDeviceList" => $dataBorrowDeviceList]);
    }
    public function updateBorrowStatus()
    {
        // if (isset($_POST['capnhat'])) {
        $tinhtrang = $_POST['tinhtrang'];
        $id  = $_POST['id'];
        $idtb  = $_POST['thietbiid'];

        $response = $this->device->updateBorrowStatus($tinhtrang, $idtb, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
