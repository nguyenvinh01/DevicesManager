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
        // SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS totalSuachua, 'Sửa chữa' AS trangthai
        // FROM muon
        // WHERE ngaymuon BETWEEN '$startDate' AND '$endDate'
        //   AND trangthai = 'Sửa chữa'
        // UNION ALL
        $sql = "SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS total FROM muon WHERE ngaymuon BETWEEN '$startDate' AND '$endDate' GROUP BY ngaymuon";
        $query = "SELECT
        DATE(ngaymuon) AS ngaymuon,
        SUM(CASE WHEN trangthai = 'Đang mượn' THEN 1 ELSE 0 END) AS totalDangMuon,
        SUM(CASE WHEN trangthai = 'Chờ phê duyệt' THEN 1 ELSE 0 END) AS totalChoPheDuyet,
        SUM(CASE WHEN trangthai = 'Quá hạn' THEN 1 ELSE 0 END) AS totalQuaHan
    FROM
        muon
    WHERE
        ngaymuon BETWEEN '$startDate' AND '$endDate'
    GROUP BY
        ngaymuon;";


        // $sql = "SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS totalDangmuon, 'Đang mượn' AS trangthai
        // FROM muon
        // WHERE ngaymuon BETWEEN '$startDate' AND '$endDate'
        //   AND trangthai = 'Đang mượn'
        // UNION ALL

        // SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS totalChoPheDuyet, 'Đang chờ duyệt' AS trangthai
        // FROM muon
        // WHERE ngaymuon BETWEEN '$startDate' AND '$endDate'
        //   AND trangthai = 'Chờ phê duyệt'
        // UNION ALL
        // SELECT DATE(ngaymuon) AS ngaymuon, COUNT(*) AS totalQuaHan, 'Quá hạn' AS trangthai
        // FROM muon
        // WHERE ngaymuon BETWEEN '$startDate' AND '$endDate'
        //   AND trangthai = 'Quá hạn'
        // ";
        $stmt = $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        return [
            "data" => $stmt,
            "query" => $sql
        ];
    }
}
