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
        $this->view('index', ["page" => "dashboard"]);
        // $this->view("index", ["page" => "dashboard"]);
    }
}
