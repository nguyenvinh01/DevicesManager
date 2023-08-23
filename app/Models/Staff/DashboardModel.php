<?php

require_once "./app/Models/Model.php";
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
    }
    public function getDeviceBorrowCountByDate($startDate, $endDate)
    {
        $sql = "SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS total FROM muon WHERE ngaymuon BETWEEN '$startDate' AND '$endDate' GROUP BY ngaymuon";
        $stmt = $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        return $stmt;
    }
}
