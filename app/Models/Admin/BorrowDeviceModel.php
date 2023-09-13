<?php

require_once "./app/Models/Model.php";
class BorrowDeviceModel extends Model
{
    function getBorrowDeviceList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;
        $curentDate = date("Y-m-d");
        $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id ";

        if ($status != '' && $status != 'Quá hạn') {
            $query .= " AND trangthai = '$status'";
        } else if ($status == 'Quá hạn') {
            $query .= " AND ngaytra < '$curentDate' AND trangthai = 'Quá hạn'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND ngaytra <= '$eDate' AND ngaymuon >= '$sDate'";
        }
        if ($filter == 'hoten') {
            $query .= " AND c.hoten LIKE '%$keyword%'";
        } elseif ($filter == 'thietbi') {
            $query .= " AND b.ten LIKE '%$keyword%'";
        }
        $queryCount = $query;
        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'count' => count($rsCount->fetch_all()),
            'query' => $query
        ];
    }
    function getDataModal($id)
    {
        $query = "SELECT *
        FROM muon
        WHERE id = $id
        ORDER BY id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function autoUpdateStatus()
    {
        $curentDate = date("Y-m-d");
        $check = "SELECT COUNT(*) as count FROM muon WHERE trangthai = 'Đang mượn' AND ngaytra < '$curentDate'";
        $rsCheck = $this->conn->query($check);
        $checkResult = $rsCheck->fetch_assoc();
        $count = $checkResult['count'];
        if ($count > 0) {
            $query = "UPDATE muon SET trangthai = 'Quá hạn' 
            WHERE trangthai = 'Đang mượn' AND ngaytra < '$curentDate'";

            $rs = $this->conn->query($query);
            return [
                'status' => 'success',
                'data' => $rs,
                // 'count' => count($rsCount->fetch_all())
            ];
        }
    }
    function getDeviceDetail($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return $data;
    }
    function updateBorrowStatus($tinhtrang, $idtb, $id)
    {
        $query = "UPDATE `muon` 
        SET `trangthai`='{$tinhtrang}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            if ($tinhtrang == "Đã trả" || $tinhtrang == "Từ chối yêu cầu") {
                $update = "UPDATE `thietbi` 
                SET `trangthai`= 'Sẵn Sàng'
                WHERE `id`='{$idtb}'";
                $this->conn->query($update);
            }
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Cập nhật thất bại"
            ];
        }
    }
}
