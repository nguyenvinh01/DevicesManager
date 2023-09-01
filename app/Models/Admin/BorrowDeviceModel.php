<?php

require_once "./app/Models/Model.php";
class BorrowDeviceModel extends Model
{
    function getBorrowDeviceList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id ";

        if ($status != '') {
            $query .= " AND trangthai = '$status'";
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
            'count' => count($rsCount->fetch_all())
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
    function updateBorrowStatus($tinhtrang, $idtb, $id)
    {
        $query = "UPDATE `muon` 
        SET `trangthai`='{$tinhtrang}'
        WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            if ($tinhtrang == "Đã trả" || $tinhtrang == "Bị từ chối") {
                $update = "UPDATE `thietbi` 
                SET `soluong`= soluong + 1
                WHERE `id`='{$idtb}'";
                $this->conn->query($update);
            }
            // header("Location: ../borrowdevice?msg=1");
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            // header("Location: ../borrowdevice?msg=2");
            return [
                "status" => "error",
                "message" => "Cập nhật thất bại"
            ];
        }
    }
}
