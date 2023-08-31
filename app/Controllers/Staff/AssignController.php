<?php

require_once('./app/Models/Staff/AssignModel.php');
require_once('./app/core/Controller.php');

class AssignController extends Controller
{
    var $assign;
    public function __construct()
    {
        $this->assign = new AssignModel();
    }

    public function Show()
    {

        $this->view('index', ["page" => "staff/assign"]);
    }
    public function getAssignList()
    {
        $response = $this->assign->getAssignList($_SESSION['id']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addAssign()
    {
        $phongban = $_POST['phongban'];
        $tentb = $_POST['thietbi'];
        $soluong = $_POST['soluong'];
        $response = $this->assign->assignDevice($phongban, $tentb, $soluong);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getDataAddModal()
    {
        $response = $this->assign->getDataAddModal(['id']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataModal()
    {
        $id = $_GET["id"];
        $response = $this->assign->getDataModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceByType()
    {
        $id = $_GET['id'];
        $response = $this->assign->getDeviceByType($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getDeviceById()
    {
        $id = $_GET['id'];
        $response = $this->assign->getDeviceById($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getStaff()
    {
        $response = $this->assign->getStaff();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function updateStatusRepair()
    {
        // if (isset($_POST['xnsc'])) {
        // $thoigian = $_POST['thoigian'];
        $id  = $_POST['id'];
        $status  = $_POST['status-repair'];
        $response = $this->assign->updateStatusRepair($id, $status);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
