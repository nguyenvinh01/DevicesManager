<?php

require_once('./app/Models/Staff/RepairModel.php');
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
        $this->view('index', ["page" => "staff/repair"]);
    }
    public function getRepairList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $status = $_GET['status'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $filter = $_GET['filter'];
        $response = $this->repair->getRepairList($_SESSION['id'], $filter, $keyword, $page, $status, $eDate, $sDate);
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
    function updateStatusRepair()
    {
        // if (isset($_POST['xnsc'])) {
        // $thoigian = $_POST['thoigian'];
        $id  = $_POST['id'];
        $status  = $_POST['status-repair'];
        $response = $this->repair->updateStatusRepair($id, $status);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}