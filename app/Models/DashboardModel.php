<?php

require_once "Model.php";
class DashboardModel extends Model
{
    function getInfoDashboard()
    {
        $querySumDevice = "SELECT COUNT(id) as 'tongso' FROM thietbi";
        $queryFixDevice = "SELECT COUNT(id) as 'tongso' FROM suachua";
        $queryApproveDevice = "SELECT COUNT(id) as 'tongso' FROM muon WHERE trangthai = 'Chờ phê duyệt'";
        $queryBorrowedDevice = "SELECT COUNT(id) as 'tongso' FROM muon WHERE trangthai = 'Đang mượn'";
        $query = "SELECT
        (SELECT COUNT(id) FROM thietbi) AS sum_device,
        (SELECT COUNT(id) FROM suachua) AS sum_fix_device,
        (SELECT COUNT(id) FROM muon WHERE trangthai = 'Chờ phê duyệt') AS sum_approve_device,
        (SELECT COUNT(id) FROM muon WHERE trangthai = 'Đang mượn') AS sum_borrowed_device;
    ";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row;
        // $sumbd = mysqli_query($connect, "SELECT COUNT(id) as 'tongso' 
        // FROM thietbi 
        // ");
        // $artinhnk = mysqli_fetch_array($sumbd);
        // $sumkh = mysqli_query($connect, "SELECT COUNT(id) as 'tongso' 
        // FROM suachua
        // ");
        // $artinhkh = mysqli_fetch_array($sumkh);
        // $sumpheduyet = mysqli_query($connect, "SELECT COUNT(id) as 'tongso' 
        // FROM muon WHERE trangthai = 'Chờ phê duyệt'
        // ");
        // $pheduyet = mysqli_fetch_array($sumpheduyet);
        // $sumchomuon = mysqli_query($connect, "SELECT COUNT(id) as 'tongso' 
        // FROM muon WHERE trangthai = 'Đang mượn'
        // ");
        // $chomuon = mysqli_fetch_array($sumchomuon);
    }
}
