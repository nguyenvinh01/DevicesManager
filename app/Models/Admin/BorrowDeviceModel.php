<?php

require_once "./app/Models/Model.php";
// require_once "./public/PHPExcel.php";
// require_once "./public/PHPExcel/IOFactory.php";
require 'vendor/autoload.php';
require_once "./app/config/library.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class BorrowDeviceModel extends Model
{
    function getBorrowDeviceList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;
        $curentDate = date("Y-m-d");
        $oneMonthAgo = date("Y-m-d", strtotime("-1 month", strtotime($curentDate))); // Trừ đi 1 tháng từ ngày hiện tại

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
        } else {
            $query .= " AND a.ngaytra >= '$oneMonthAgo' AND a.ngaymuon >= '$oneMonthAgo'";
        }
        if ($filter == 'hoten') {
            $query .= " AND c.hoten LIKE '%$keyword%'";
        } elseif ($filter == 'thietbi') {
            $query .= " AND b.ten LIKE '%$keyword%'";
        } elseif ($filter == 'madonmuon') {
            $query .= " AND a.madonmuon LIKE '%$keyword%'";
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
            'count' => count($rsCount->fetch_all()),
            'query' => $queryCount
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
    function sendMailOvcerdue($filter, $keyword, $status, $eDate, $sDate)
    {
        $curentDate = date("Y-m-d");
        $oneMonthAgo = date("Y-m-d", strtotime("-1 month", strtotime($curentDate))); // Trừ đi 1 tháng từ ngày hiện tại
        $query = "SELECT a.*,b.ten, b.hinhanh, c.*
        FROM muon as a,thietbi as b, nguoidung as c
        WHERE a.thietbi_id = b.id 
        AND a.nguoidung_id = c.id AND a.madonmuon != '' AND a.trangthai = 'Quá hạn'";

        if ($sDate != '' && $eDate != '') {
            $query .= " AND a.ngaytra <= '$eDate' AND a.ngaymuon >= '$sDate'";
        } else {
            $query .= " AND a.ngaytra >= '$oneMonthAgo' AND a.ngaymuon >= '$oneMonthAgo'";
        }
        $queryCount = $query;
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $this->sendEmail($query);
        return [
            'status' => 'success',
            'data' => $data,
            'count' => count($rsCount->fetch_all()),
            'query' => $queryCount
        ];
    }
    function getBorrowDetail($idDonmuon)
    {
        // $query = "SELECT m.*, tb.ten
        // FROM muon as m, thietbi as tb
        // WHERE m.madonmuon = '$idDonmuon' AND m.thietbi_id = tb.id";
        $query = "SELECT m.*, tb.ten
        FROM muon as m, thietbi as tb
        WHERE m.id = '$idDonmuon' AND m.thietbi_id = tb.id";
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
    function updateBorrowStatus($tinhtrang, $id, $noidung)
    {

        foreach ($tinhtrang as $keyValue) {
            $query = "UPDATE muon SET trangthai = '{$keyValue['value']}' WHERE madonmuon = '$id' AND mathietbi = '{$keyValue['key']}'";
            $this->conn->query($query);
            if ($keyValue['value'] == 'Đã trả') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE mathietbi = '{$keyValue['key']}';";
                $this->conn->query($queryUpdate);
            } else if ($keyValue['value'] == 'Sửa chữa') {
                $queryUpdate = "UPDATE thietbi SET trangthai = 'Sửa chữa' WHERE mathietbi = '{$keyValue['key']}';";
                $queryGetDetail = "SELECT thietbi_id, nguoidung_id FROM muon WHERE madonmuon = '$id' AND mathietbi = '{$keyValue['key']}'";
                $thietbiid = $this->conn->query($queryGetDetail)->fetch_assoc();
                $queryUpdateRepair = "INSERT INTO suachua (thietbi_id, noidung, nguoidung_id, tinhtrang, madonmuon) 
                VALUES ( '{$thietbiid['thietbi_id']}', '{$noidung}','{$thietbiid['nguoidung_id']}', 'Chờ xử lý', '{$id}') ";
                $this->conn->query($queryUpdate);
                $this->conn->query($queryUpdateRepair);
                // return [
                //     "status" => "success",
                //     "message" => "Cập nhật thành công",
                //     "query" => $queryUpdate,
                //     "noidung" => $queryUpdateRepair
                // ];
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
            "noidung" => $noidung
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

        $uniqueFileName = $baseName . '_' . $timestamp . '.' . $extension;

        return  $uniqueFileName;
    }
    function sendEmail($query)
    {
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $noidung = '<html>
                    <head>
                        <title>Thông báo trả muộn thiết bị</title>
                    </head>
                    <body>
                        <p>Xin chào</p>
                        <p>Chúng tôi thông báo rằng bạn đã trả muộn một số thiết bị. Chi tiết về việc mượn và trả thiết bị như sau:</p>
                        
                        <table>
                            <tr>
                                <th>Mã Đơn mượn</th>
                                <th>Mã Thiết bị</th>
                                <th>Tên Thiết bị</th>
                                <th>Ngày Mượn</th>
                                <th>Ngày Trả</th>
                            </tr>';
        foreach ($data as $row) {
            $noidung .= "<tr>
                <td>{$row['madonmuon']}</td>
                <td>{$row['mathietbi']}</td>
                <td>{$row['ten']}</td>
                <td>{$row['ngaymuon']}</td>
                <td>{$row['ngaytra']}</td>
            </tr>";
        }
        $noidung .= '</table>
                        
                        <p>Xin lưu ý rằng việc trả muộn thiết bị có thể chịu phí hoặc các biện pháp khác tùy theo quy định của chúng tôi.</p>
                        <p>Trân trọng,</p>
                        <p>[Tên tổ chức]</p>
                    </body>
                    </html>';
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_UNAME;
            $mail->Password = SMTP_PWORD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_UNAME, "WEBSITE NHÀ TRƯỜNG");
            // while ($data) {
            //     $mail->addAddress($data['email']);
            // }

            // Duyệt qua mảng dữ liệu và thêm địa chỉ email vào danh sách người nhận
            foreach ($data as $row) {
                $email = $row['email']; // Lấy địa chỉ email từ dữ liệu
                $ten = $row['hoten'];     // Lấy tên người nhận từ dữ liệu

                // Thêm địa chỉ email và tên vào danh sách người nhận
                $mail->addAddress($email, $ten);
            }
            $mail->addReplyTo(SMTP_UNAME, 'WEBSITE NHÀ TRƯỜNG');
            $mail->isHTML(true);
            $mail->Subject = 'Thông báo từ hệ thống quản lý tài sản, thiết bị tại trường đại học.';
            $mail->Body = $noidung;
            $mail->AltBody = $noidung;
            $result = $mail->send();
            if (!$result) {
                $error = "Có lỗi xảy ra trong quá trình gửi mail";
            }
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi gửi email: " . $e->getMessage()
            ];
        }
        // }
        // header("Location: ../notification?msg=1");
        // return [
        //     "status" => "success",
        //     "message" => "Gửi thông báo thành công"
        // ];
        // } else {
        //     // header("Location: ../notification?msg=2");
        //     return [
        //         "status" => "error",
        //         "message" => "Có lỗi trong quá trình gửi"
        //     ];
        // }
    }
}
