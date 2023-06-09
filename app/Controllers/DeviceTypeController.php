<?php

require_once('./app/Models/DeviceTypeModel.php');
require_once('./app/core/Controller.php');

class DeviceTypeController extends Controller
{
    var $deviceType;
    public function __construct()
    {
        $this->deviceType = new DeviceTypeModel();
    }

    public function Show()
    {

        $dataDeviceType = $this->deviceType->getDeviceType();
        $this->view('index', ["page" => "devicetype", "dataDeviceType" => $dataDeviceType]);
    }
    public function addDeviceType()
    {
        if (isset($_POST['adddm'])) {
            $ten = $_POST['ten'];
            // $query = "INSERT INTO loaithietbi (ten) 
            // VALUES ( '{$ten}') ";
            // $result = mysqli_query($connect, $query);
            // if ($result) {
            //   header("Location: loaithietbi.php?msg=1");
            // } 
            // else {
            //     header("Location: loaithietbi.php?msg=2");
            // }
            $this->deviceType->addDeviceType($ten);
        }
    }
    public function editDeviceType()
    {
        if (isset($_POST['editdm'])) {
            $ten = $_POST['ten'];
            $id  = $_POST['id'];
            // $query = "UPDATE `loaithietbi` 
            //     SET `ten`='{$ten}'
            //     WHERE `id`='{$id}'";
            // $result = mysqli_query($connect, $query);
            // if ($result) {
            //     header("Location: loaithietbi.php?msg=1");
            // } else {
            //     header("Location: loaithietbi.php?msg=2");
            // }
            $this->deviceType->editDeviceType($ten, $id);
        }
    }
    public function deleteDeviceType()
    {
        if (isset($_POST['deletedm'])) {
            $id  = $_POST['id'];
            // $check = "SELECT * FROM thietbi WHERE loaithietbi_id = '{$id}'";
            // $excute = mysqli_query($connect, $check);
            // $row = mysqli_num_rows($excute);
            // if ($row > 0) {
            //     header("Location: loaithietbi.php?msg=2");
            // } else {
            //     $query = "DELETE FROM loaithietbi WHERE `id`='{$id}'";
            //     $result = mysqli_query($connect, $query);
            //     header("Location: loaithietbi.php?msg=1");
            // }
            $this->deviceType->deleteDeviceType($id);
        }
    }
}
