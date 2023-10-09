<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once "./app/config/library.php";
class RepairModel extends Model
{
    function getRepairList($filter, $keyword, $page, $status, $eDate, $sDate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*, b.hoten, c.ten as tentb
            FROM suachua as a, nguoidung as b, thietbi as c
            WHERE a.thietbi_id = c.id";
        if ($filter == '') {
            $query .= " AND a.nguoidung_id = b.id";
        }
        if ($status != '') {
            $query .= " AND a.tinhtrang = '$status'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND a.ngaygui <= '$eDate' AND a.ngaygui >= '$sDate'";
        }
        if ($filter == 'nguoigui') {
            $query .= " AND b.hoten LIKE '%$keyword%' AND b.quyen_id = 2";
        } elseif ($filter == 'nguoisuachua') {
            $query .= " AND b.hoten LIKE '%$keyword%' AND b.id = a.phancong AND b.quyen_id = 3";
        } elseif ($filter == 'thietbi') {
            $query .= " AND c.ten LIKE '%$keyword%'";
        }
        // $query .= " AND b.id = 361";
        $queryCount = $query;
        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";

        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryStaff = "SELECT * FROM nguoidung WHERE quyen_id = 3";
        $rsStaff = $this->conn->query($queryStaff);
        $dataStaff = array();
        while ($row = $rsStaff->fetch_assoc()) {
            $dataStaff[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'staff' => $dataStaff,
            'count' => count($rsCount->fetch_all()),
        ];
    }
    public function getDataModal($id)
    {
        $queryStaff = "SELECT * FROM nguoidung WHERE quyen_id = 3";
        $rsStaff = $this->conn->query($queryStaff);
        $dataStaff = array();
        while ($row = $rsStaff->fetch_assoc()) {
            $dataStaff[] = $row;
        }
        $queryStaffAssign = "SELECT * FROM suachua WHERE id = $id";
        $rsStaffAssign = $this->conn->query($queryStaffAssign);
        $dataStaffAssign = array();
        while ($row = $rsStaffAssign->fetch_assoc()) {
            $dataStaffAssign[] = $row;
        }
        return [
            'staff' => $dataStaff,
            'staffAssign' => $dataStaffAssign
        ];
    }
    function getDeviceType()
    {
        $query = "SELECT * FROM thietbi WHERE id IN (Select thietbi_id From muon WHere nguoidung_id = '{$_SESSION['id']}' AND trangthai = 'Đang mượn')";
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
    function sendRepair($idtb, $noidung)
    {
        $query = "INSERT INTO suachua (thietbi_id, noidung, nguoidung_id, tinhtrang) 
            VALUES ( '{$idtb}', '{$noidung}','{$_SESSION['id']}', 'Chờ xử lý') ";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Gửi thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi gửi"
            ];
        }
    }
    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
    function getUserById($id)
    {
        $query = "SELECT hoten, email, sodienthoai FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();

        return [
            "status" => "success",
            "data" => $data
        ];
    }

    public function sendEmailAssign($tieude, $noidung, $date, $email)
    {
        // $query = "INSERT INTO suco ( tieude, noidung, nguoidung_id) 
        // VALUES ( '{$tieude}', '{$noidung}', '{$_SESSION["id"]}') ";
        // $result = $this->conn->query($query);
        // if ($result) {
        // $querytb = "SELECT * FROM nguoidung WHERE quyen_id = 1";
        // $resultb = $this->conn->query($querytb);
        // $num_rows = mysqli_num_rows($resultb);
        // if ($num_rows > 0) {
        // $noidung = '<strong>Tiêu đề :</strong> ' . $tieude . '<br> <strong>Ngày tạo :</strong>' . $date . '<br> <strong>Nội dung :</strong><br><p>' . $noidung . '</p>';
        $noidung = "
            <html>
            <head>
                <title>Thông báo phân công kiểm tra sửa chữa</title>
            </head>
            <body>
                <p>Xin chào [Tên Nhân Viên],</p>
                <p>Bạn đã được phân công kiểm tra sửa chữa thiết bị [Tên Thiết Bị]. Hãy thực hiện công việc sau:</p>
                <ol>
                    <li>Kiểm tra tình trạng của thiết bị.</li>
                    <li>Thực hiện sửa chữa nếu cần.</li>
                    <li>Báo cáo kết quả và tình trạng sửa chữa cho quản lý.</li>
                </ol>
                <p>Thời gian phân công: [Thời Gian Phân Công]</p>
                <p>Thiết bị cần kiểm tra sửa chữa:</p>
                <ul>
                    <li>Mã Thiết Bị: [Mã Thiết Bị]</li>
                    <li>Tên Thiết Bị: [Tên Thiết Bị]</li>
                    <li>Danh Mục: [Danh Mục Thiết Bị]</li>
                </ul>
                <p>Xin cảm ơn sự đóng góp của bạn trong việc duy trì và bảo dưỡng thiết bị.</p>
                <p>Trân trọng,</p>
                <p>[Tên Người Gửi]</p>
            </body>
            </html>
        ";
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
            // while ($arUser = mysqli_fetch_array($resultb, MYSQLI_ASSOC)) {
            $mail->addAddress($email);
            // }
            $mail->addReplyTo(SMTP_UNAME, 'WEBSITE NHÀ TRƯỜNG');
            $mail->isHTML(true);
            $mail->Subject = 'Thông báo từ hệ thống quản lý tài sản, thiết bị tại trường đại học.';
            $mail->Body = $noidung;
            $mail->AltBody = $noidung;
            $result = $mail->send();
            if (!$result) {
                $error = "Có lỗi xảy ra trong quá trình gửi mail";
            }
            return [
                "status" => "success",
                "message" => "Gửi thành công"
            ];
        } catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi gửi email: " . $e->getMessage()
            ];
        }
    }
    function assignRepair($idStaff, $id)
    {
        $query = "UPDATE `suachua` 
        SET `phancong`= $idStaff
        WHERE `id`='$id'";
        $result = $this->conn->query($query);
        $queryStaff = "SELECT * FROM nguoidung WHERE id = $idStaff LIMIT 1";
        $rsDataStaff = $this->conn->query($queryStaff);
        $emailStaff = $rsDataStaff->fetch_assoc();
        // $this->sendEmailAssign("Assign", "Assign", 'ádasdsad', $emailStaff['email']);
        $queryGetDevice = "SELECT m.*, tb.ten as tenthietbi FROM muon as m, suachua as sc, thietbi as tb 
        WHERE sc.madonmuon = m.madonmuon 
        AND m.thietbi_id = tb.id 
        AND sc.thietbi_id = m.thietbi_id
        AND sc.id = $id";
        $rs = $this->conn->query($queryGetDevice);
        $data = [];
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        // $noidung = '<strong>Tiêu đề :</strong> <br> <strong>Ngày tạo :</strong><br> <strong>Nội dung :</strong><br><p></p>';
        $noidung = "
            <html>
            <head>
                <title>Thông báo phân công kiểm tra sửa chữa</title>
            </head>
            <body>
                <p>Xin chào {$emailStaff['hoten']},</p>
                <p>Bạn đã được phân công kiểm tra sửa chữa thiết bị. Hãy thực hiện công việc sau:</p>
                <ol>
                    <li>Kiểm tra tình trạng của thiết bị.</li>
                    <li>Thực hiện sửa chữa nếu cần.</li>
                    <li>Báo cáo kết quả và tình trạng sửa chữa cho quản lý.</li>
                </ol>
                <p>Thời gian phân công: {$emailStaff['ngaygui']}</p>
                <p>Thiết bị cần kiểm tra sửa chữa:</p>
                ";
        foreach ($data as $row) {
            $noidung .= "<ul> 
                        <li>Mã Thiết Bị: {$row['mathietbi']}</li>
                        <li>Tên Thiết Bị: {$row['tenthietbi']}</li>
                        </ul>";
        }


        $noidung .= "
                <p>Xin cảm ơn sự đóng góp của bạn trong việc duy trì và bảo dưỡng thiết bị.</p>
                <p>Trân trọng,</p>
            </body>
            </html>
";
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
            // while ($arUser = mysqli_fetch_array($resultb, MYSQLI_ASSOC)) {
            $mail->addAddress($emailStaff['email']);
            // }
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
        if ($result) {
            return [
                "status" => "success",
                "message" => "Cập nhật thành công $error"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi cập nhật $error"
            ];
        }
    }
}
