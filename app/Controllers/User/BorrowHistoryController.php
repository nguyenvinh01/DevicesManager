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
        $borrowHistoryList = $this->borrowHistory->getBorrowHistoryList();
        $this->view("index", ["page" => "user/history", "borrowHistoryList" => $borrowHistoryList]);
    }
    public function getBorrowHistoryList()
    {
        $response = $this->borrowHistory->getBorrowHistoryList();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
