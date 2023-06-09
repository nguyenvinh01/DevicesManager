<?php

require_once('./app/Models/DashboardModel.php');
require_once('./app/core/Controller.php');

class DashboardController extends Controller
{
    var $data;
    public function __construct()
    {
        $this->data = new DashboardModel();
    }

    public function Show()
    {

        // $data = $this->data->getInfo();
        // $page = "dashboard";
        // require_once('./app/index.php');
        // $listUser = $this->userList->getUserList();
        // $id = $_SESSION['id'];
        $dataDashboard = $this->data->getInfoDashboard();
        $this->view('index', ["page" => "dashboard", "dataDashboard" => $dataDashboard]);
    }
}
