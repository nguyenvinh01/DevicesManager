<?php

require_once('./app/Models/User/IncidentModel.php');
require_once('./app/core/Controller.php');

class IncidentController extends Controller
{
    var $incident;
    public function __construct()
    {
        $this->incident = new IncidentModel();
    }

    public function Show()
    {

        $incidentContent = $this->incident->getIncidentList();
        $this->view('index', ["page" => "user/incident", "incidentContent" => $incidentContent]);
    }
    public function sendIncident()
    {
        //Thông báo
        $tieude = $_POST['tieude'];
        $noidung = $_POST['noidung'];
        $date = date('d-m-Y');
        $response = $this->incident->sendIncident($tieude, $noidung, $date);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
