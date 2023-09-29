<?php

require_once('./app/Models/Admin/AssignModel.php');
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

        $this->view('index', ["page" => "Admin/assign"]);
    }
    public function getAssignList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $department = $_GET['department'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $filter = $_GET['filter'];
        $response = $this->assign->getAssignList($filter, $keyword, $page, $department, $eDate, $sDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getAssignDetail()
    {
        $idCapPhat = $_GET['idCapPhat'];

        $response = $this->assign->getAssignDetail($idCapPhat);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addAssign()
    {
        $phongban = $_POST['phongban'];
        // $tentb = $_POST['thietbi'];
        $soluong = $_POST['soluong'];
        $type = $_POST['ltb'];
        $response = $this->assign->assignDevice($phongban, $soluong, $type);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getDataAddModal()
    {
        $response = $this->assign->getDataAddModal(['id']);
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
    public function getDepartment()
    {
        $response = $this->assign->getDepartment();
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getStaff()
    {
        $response = $this->assign->getStaff();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceType()
    {
        $cate = $_GET['cate'];
        $response = $this->assign->getDeviceType($cate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceCategories()
    {
        $response = $this->assign->getDeviceCategories();
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
    public function getUserById()
    {
        $id = $_GET['id'];

        $response = $this->assign->getUserById($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function assignStaff()
    {
        $id = $_POST['id'];
        $idStaff = $_POST['id-staff'];
        $ngayktra = $_POST['ngaykiemtra'];
        $response = $this->assign->assignStaff($id, $idStaff, $ngayktra);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function sendRepair()
    {
        $idtb = $_POST['thietbi'];
        $noidung = $_POST['noidung'];

        $response = $this->assign->sendRepair($idtb, $noidung);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function revokeDevice()
    {
        $id = $_POST['id'];
        // $tentb = $_POST['thietbi'];

        $response = $this->assign->revokeDevice($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
