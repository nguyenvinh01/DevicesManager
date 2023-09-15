<?php

require_once "./app/Models/User/BorrowHistoryModel.php";
require_once "./app/core/Controller.php";

class BorrowHistoryController extends Controller
{

    var $borrowHistory;
    public function __construct()
    {
        $this->borrowHistory = new BorrowHistoryModel();
    }
    function Show()
    {
        $this->view("index", ["page" => "user/history"]);
    }
    public function getBorrowHistoryList()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $status = $_GET['status'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $response = $this->borrowHistory->getBorrowHistoryList($keyword, $page, $status, $eDate, $sDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getDeviceById()
    {
        $id = $_GET['id'];
        $response = $this->borrowHistory->getDeviceById($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getBorrowDetail()
    {
        $id = $_GET['id'];
        $response = $this->borrowHistory->getBorrowDetail($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
