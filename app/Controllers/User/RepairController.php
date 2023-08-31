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
        $repairContent = $this->repair->getRepairList($_SESSION['id']);
        $dataDeviceType = $this->repair->getDeviceType($_SESSION['id']);

        $this->view('index', ["page" => "user/repair", "repairContent" => $repairContent, "dataDeviceType" => $dataDeviceType]);
    }
    public function getRepairList()
    {
        $response = $this->repair->getRepairList($_SESSION['id']);
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
