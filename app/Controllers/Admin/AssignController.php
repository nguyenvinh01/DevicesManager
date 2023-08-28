<?php

require_once('./app/Models/Admin/AssignModel.php');
require_once('./app/core/Controller.php');

class AssignController extends Controller
{
    var $repair;
    public function __construct()
    {
        $this->repair = new AssignModel();
    }

    public function Show()
    {
        $repairContent = $this->repair->getRepairList($_SESSION['id']);
        $dataDeviceType = $this->repair->getDeviceType($_SESSION['id']);

        $this->view('index', ["page" => "admin/assign", "repairContent" => $repairContent, "dataDeviceType" => $dataDeviceType]);
    }
    function sendRepair()
    {
        // if (isset($_POST['ycsc'])) {
        $idtb = $_POST['thietbi'];
        $noidung = $_POST['noidung'];

        $response = $this->repair->sendRepair($idtb, $noidung);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
    function confirmRepair()
    {
        // if (isset($_POST['xnsc'])) {
        $thoigian = $_POST['thoigian'];
        $chiphi = $_POST['chiphi'];
        $id  = $_POST['id'];
        $response = $this->repair->confirmRepair($thoigian, $chiphi, $id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
