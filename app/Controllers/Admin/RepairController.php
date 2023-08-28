<?php

require_once('./app/Models/Admin/RepairModel.php');
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

        $this->view('index', ["page" => "admin/repair", "repairContent" => $repairContent, "dataDeviceType" => $dataDeviceType]);
    }
    public function getRepairList()
    {
        $response = $this->repair->getRepairList($_SESSION['id']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceType()
    {
        $response = $this->repair->getDeviceType($_SESSION['id']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataModal()
    {
        $id = $_GET["id"];
        $response = $this->repair->getDataModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
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
    function assignRepair()
    {
        // if (isset($_POST['xnsc'])) {
        // $thoigian = $_POST['thoigian'];
        $idStaff = $_POST['id-staff'];
        $idUpdate  = $_POST['id'];
        $response = $this->repair->assignRepair($idStaff, $idUpdate);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
