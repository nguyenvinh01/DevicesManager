<?php

require_once('./app/Models/Admin/DepartmentModel.php');
require_once('./app/core/Controller.php');

class DepartmentController extends Controller
{
    var $department;
    public function __construct()
    {
        $this->department = new DepartmentModel();
    }

    public function Show()
    {
        $this->view('index', ["page" => "Admin/department"]);
    }
    public function getDepartmentList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];

        $response = $this->department->getDepartmentList($keyword, $page);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getBuildingList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $response = $this->department->getBuildingList($keyword, $page);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getRoom()
    {
        $id = $_GET['idToaNha'];
        $idTang = $_GET['idTang'];
        $response = $this->department->getRoom($id, $idTang);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getFloor()
    {
        $id = $_GET['idToaNha'];
        $response = $this->department->getFloor($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getBuilding()
    {
        $response = $this->department->getBuilding();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataEditDepartment()
    {
        $id = $_GET["id"];
        $response = $this->department->getDataEditDepartment($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDataDelDepartment()
    {
        $id = $_GET["id"];
        $response = $this->department->getDataDelDepartment($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addDepartment()
    {
        $tenphongban = $_POST['tenphongban'];
        $idToaNha = $_POST['toanha'];
        $idTang = $_POST['tang'];
        $idPhong = $_POST['phong'];
        $response = $this->department->addDepartment($tenphongban, $idToaNha, $idTang, $idPhong);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addLocation()
    {
        $tendiadiem = $_POST['tendiadiem'];
        $idToaNha = $_POST['toanha'];
        $idTang = $_POST['tang'];
        $response = $this->department->addLocation($tendiadiem, $idTang, $idToaNha);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function editDepartment()
    {
        $tenphongban = $_POST['tenphongban'];
        $id = $_POST['id'];
        $idToaNha = $_POST['toanha'];
        $idTang = $_POST['tang'];
        $idPhong = $_POST['phong'];
        $response = $this->department->editDepartment($tenphongban, $id, $idToaNha, $idTang, $idPhong);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function deleteDepartment()
    {
        // if (isset($_POST['deletedm'])) {
        $id  = $_POST['id'];
        $response = $this->department->deleteDepartment($id);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
