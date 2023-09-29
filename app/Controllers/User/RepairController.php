<?php

require_once('./app/Models/User/RepairModel.php');
require_once('./app/core/Controller.php');

class RepairController extends Controller
{
    var $repair;
    public function __construct()
    {
        $this->repair = new RepairModel();
    }

    public function Show()
    {
        $this->view('index', ["page" => "User/repair"]);
    }
    public function getRepairList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $status = $_GET['status'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $filter = $_GET['filter'];
        $response = $this->repair->getRepairList($filter, $keyword, $page, $status, $eDate, $sDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceById()
    {
        $id = $_GET['id'];
        $response = $this->repair->getDeviceById($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getUserById()
    {
        $id = $_GET['id'];

        $response = $this->repair->getUserById($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataModal()
    {
        $response = $this->repair->getDataModal($_SESSION['id']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function sendRepair()
    {
        $idtb = $_POST['thietbi'];
        $noidung = $_POST['noidung'];

        $response = $this->repair->sendRepair($idtb, $noidung);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function confirmRepair()
    {
        $thoigian = $_POST['thoigian'];
        $chiphi = $_POST['chiphi'];
        $id  = $_POST['id'];
        $response = $this->repair->confirmRepair($thoigian, $chiphi, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
