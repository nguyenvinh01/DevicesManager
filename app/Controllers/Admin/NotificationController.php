<?php

require_once('./app/Models/Admin/NotificationModel.php');
require_once('./app/core/Controller.php');

class NotificationController extends Controller
{
    var $notification;
    public function __construct()
    {
        $this->notification = new NotificationModel();
    }

    public function Show()
    {

        $this->view('index', ["page" => "admin/notification"]);
    }
    public function getDataModal()
    {
        $id = $_GET["id"];
        $response = $this->notification->getDataModal($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function getNotification()
    {
        $keyword = $_GET['keyword'];
        $page = $_GET['page'];
        $status = $_GET['status'];
        $eDate = $_GET['eDate'];
        $sDate = $_GET['sDate'];
        $filter = $_GET['filter'];
        $response = $this->notification->getNotification($keyword, $page, $eDate, $sDate);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function sendNotification()
    {
        //Thông báo
        // if (isset($_POST['addtb'])) {
        $tieude = $_POST['tieude'];
        $noidung = $_POST['noidung'];
        $date = date('d-m-Y');
        $response = $this->notification->sendNotification($tieude, $noidung, $date);
        header('Content-Type: application/json');
        echo json_encode($response);
        // }
    }
}
