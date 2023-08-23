<?php

require_once('./app/Models/Staff/DashboardModel.php');
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
        $this->view('index', ["page" => "staff/dashboard"]);
    }
}
