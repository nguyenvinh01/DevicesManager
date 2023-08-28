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

        $notificationContent = $this->notification->getNotification();
        $this->view('index', ["page" => "admin/notification", "notificationContent" => $notificationContent]);
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
        $response = $this->notification->getNotification();
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
