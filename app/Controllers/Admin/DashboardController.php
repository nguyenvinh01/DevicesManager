<?php

require_once('./app/Models/Admin/DashboardModel.php');
require_once('./app/core/Controller.php');

class DashboardController extends Controller
{
    var $data;
    // var $startDate = '2023-06-01';
    // var $endDate = '2023-06-30';
    public function __construct()
    {
        $this->data = new DashboardModel();
    }

    public function Show()
    {
        // var $startDate = '2023-06-01';
        // var $endDate = '2023-06-30';
        $dataDashboard = $this->data->getInfoDashboard();
        // $data = $this->data->getDeviceBorrowCountByDate('2023-06-01', '2023-06-30');
        $this->view('index', ["page" => "Admin/dashboard", "dataDashboard" => $dataDashboard]);
    }
    public function getDeviceBorrowCountByDate()
    {
        $startDate = $_GET['startDate'];
        $endDate =  $_GET['endDate'];
        $response = $this->data->getDeviceBorrowCountByDate($endDate, $startDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
