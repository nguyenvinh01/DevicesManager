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

        $this->view('index', ["page" => "admin/borrow"]);
    }
    public function getBorrowDeviceList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $status = $_GET['status'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $filter = $_GET['filter'];
        $response = $this->device->getBorrowDeviceList($filter, $keyword, $page, $status, $eDate, $sDate);
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
    public function getDeviceDetail()
    {
        $id = $_GET["id"];
        $response = $this->device->getDeviceDetail($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // public function updateBorrowStatus()
    // {
    //     // if (isset($_POST['capnhat'])) {
    //     $tinhtrang = $_POST['tinhtrang'];
    //     $id  = $_POST['id'];
    //     $idtb  = $_POST['thietbiid'];

    //     $response = $this->device->updateBorrowStatus($tinhtrang, $idtb, $id);
    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    //     // }
    // }
    public function updateBorrowStatus()
    {
        // if (isset($_POST['capnhat'])) {
        $tinhtrang = $_POST['status'];
        $id  = $_POST['id'];
        // $idtb  = $_POST['thietbiid'];

        $response = $this->device->updateBorrowStatus($tinhtrang, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    public function autoUpdateStatus()
    {
        $response = $this->device->autoUpdateStatus();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getBorrowDetail()
    {
        $id = $_GET['id'];
        $response = $this->device->getBorrowDetail($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
