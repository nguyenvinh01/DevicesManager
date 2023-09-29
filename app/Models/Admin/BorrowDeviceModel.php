<?php

require_once "./app/Models/Model.php";
// require_once "./public/PHPExcel.php";
// require_once "./public/PHPExcel/IOFactory.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BorrowDeviceModel extends Model
{
    function getBorrowDeviceList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;
        $curentDate = date("Y-m-d");
        // $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten
        // FROM muon as a,thietbi as b, nguoidung as c
        // WHERE a.thietbi_id = b.id 
        // AND a.nguoidung_id = c.id ";

        // if ($status != '' && $status != 'Quá hạn') {
        //     $query .= " AND trangthai = '$status'";
        // } else if ($status == 'Quá hạn') {
        //     $query .= " AND ngaytra < '$curentDate' AND trangthai = 'Quá hạn'";
        // }
        // if ($sDate != '' && $eDate != '') {
        //     $query .= " AND ngaytra <= '$eDate' AND ngaymuon >= '$sDate'";
        // }
        // if ($filter == 'hoten') {
        //     $query .= " AND c.hoten LIKE '%$keyword%'";
        // } elseif ($filter == 'thietbi') {
        //     $query .= " AND b.ten LIKE '%$keyword%'";
        // }
        $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten,  (SELECT COUNT(*) FROM muon WHERE madonmuon = a.madonmuon) AS count_donmuon
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id AND a.madonmuon != ''";

        if ($status != '' && $status != 'Quá hạn') {
            $query .= " AND a.trangthai = '$status'";
        } else if ($status == 'Quá hạn') {
            $query .= " AND a.ngaytra < '$curentDate' AND a.trangthai = 'Quá hạn'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND a.ngaytra <= '$eDate' AND a.ngaymuon >= '$sDate'";
        }
        if ($filter == 'hoten') {
            $query .= " AND c.hoten LIKE '%$keyword%'";
        } elseif ($filter == 'thietbi') {
            $query .= " AND b.ten LIKE '%$keyword%'";
        }
        // $query .= " GROUP BY a.madonmuon";
        $queryCount = $query;
        $query .= " ORDER BY a.madonmuon DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            // 'count' => count($rsCount->fetch_all()),
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

    function getBorrowDetail($idDonmuon)
    {
        $query = "SELECT m.*, tb.ten
        FROM muon as m, thietbi as tb
        WHERE m.madonmuon = '$idDonmuon' AND m.thietbi_id = tb.id";
        $rs = $this->conn->query($query);
        // $data = $rs->fetch_assoc();
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
    function updateBorrowStatus($tinhtrang, $id)
    {

        foreach ($tinhtrang as $keyValue) {
            $query = "UPDATE muon SET trangthai = '{$keyValue['value']}' WHERE madonmuon = '$id' AND mathietbi = '{$keyValue['key']}'";
            $this->conn->query($query);
            if ($keyValue['value'] == 'Đã trả') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Sửa chữa') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Chờ sửa chữa' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Từ chối yêu cầu') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Thất lạc') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Thất lạc' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            }
        }
        // $result = $this->conn->query($query);
        // if ($result) {
        // if ($tinhtrang == "Đã trả" || $tinhtrang == "Từ chối yêu cầu") {
        //     $update = "UPDATE `thietbi` 
        //     SET `trangthai`= 'Sẵn Sàng'
        //     WHERE `id`='{$idtb}'";
        //     $this->conn->query($update);
        // }
        return [
            "status" => "success",
            "message" => "Cập nhật thành công",
            "query" => $query,
        ];
    }

    public function exportExcel($filter, $keyword, $status, $eDate, $sDate)
    {
        // $query = "SELECT *
        // FROM nguoidung 
        // WHERE quyen_id = 2";
        $curentDate = date("Y-m-d");

        $query = "SELECT a.*,b.ten, b.hinhanh, c.hoten,  (SELECT COUNT(*) FROM muon WHERE madonmuon = a.madonmuon) AS count_donmuon
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id AND a.madonmuon != ''";

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
        // $query .= " GROUP BY a.madonmuon";
        $query .= " ORDER BY a.id DESC";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_all(MYSQLI_ASSOC);


        // Tạo một đối tượng PHPExcel và cấu hình tệp Excel
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getProperties()->setTitle("Exported Borrow");

        //Thêm dữ liệu từ cơ sở dữ liệu vào tệp Excel
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Tên thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Mã thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Mã đơn mượn');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tên người mượn');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Địa điểm mượn');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Trạng thái');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Ngày mượn');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Ngày trả');

        $row = 2;
        foreach ($data as $user) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, (int)$user['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $user['ten']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $user['mathietbi']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $user['madonmuon']);

            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $user['hoten']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $user['diadiem']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $user['trangthai']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $user['ngaymuon']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $user['ngaytra']);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $row++;
        }

        // // Lưu tệp Excel vào thư mục "uploads"
        $writer = new Xlsx($objPHPExcel);

        $filename = 'Danh sách mượn trả.xlsx';
        // $filename = 'C:/Downloads/Danh sách người dùng.xlsx';
        $uniqueFileName = $this->getUniqueFileName($filename);
        $writer->save($uniqueFileName);


        return $uniqueFileName;
        // return $objPHPExcel;
    }
    function getUniqueFileName($fileName)
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $timestamp = date('Ymd_His'); // Thêm timestamp vào tên tệp

        $counter = 1;
        $uniqueFileName = $baseName . '_' . $timestamp . '.' . $extension;

        return  $uniqueFileName;
    }
}
