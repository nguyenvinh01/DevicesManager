<?php

require_once('./app/Models/User/DashboardModel.php');
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
        $data = $this->data->getDeviceBorrowCountByDate('2023-06-01', '2023-06-30');
        $this->view('index', ["page" => "user/dashboard", "dataDashboard" => $dataDashboard, 'data' => $data]);
    }
}
