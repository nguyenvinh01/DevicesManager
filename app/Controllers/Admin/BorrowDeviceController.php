<?php

require_once('./app/Models/Admin/BorrowDeviceModel.php');
require_once('./app/core/Controller.php');

class BorrowdeviceController extends Controller
{
    var $device;
    public function __construct()
    {
        $this->device = new BorrowDeviceModel();
    }

    public function Show()
    {

        $this->view('index', ["page" => "Admin/borrow"]);
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
        $noidung = $_POST['noidung'];
        // $idtb  = $_POST['thietbiid'];

        $response = $this->device->updateBorrowStatus($tinhtrang, $id, $noidung);
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
    public function exportExcel()
    {
        $keyword = $_POST['keyword'];
        $status = $_POST['status'];
        $eDate = $_POST['eDate'];
        $sDate = $_POST['sDate'];
        $filter = $_POST['filter'];
        $response = $this->device->exportExcel($filter, $keyword, $status, $eDate, $sDate);

        // header('Content-Type: application/json');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="exported_data.xls"');
        echo $response;
    }
    public function sendMailOvcerdue()
    {
        $keyword = $_POST['keyword'];
        $status = $_POST['status'];
        $eDate = $_POST['eDate'];
        $sDate = $_POST['sDate'];
        $filter = $_POST['filter'];
        $response = $this->device->sendMailOvcerdue($filter, $keyword, $status, $eDate, $sDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
