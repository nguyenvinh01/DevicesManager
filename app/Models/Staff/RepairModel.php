<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once "./app/config/library.php";
class RepairModel extends Model
{
    function getRepairList($id)
    {
        // if ($_SESSION['quyen'] == 1) {
        $query = "SELECT a.*, b.hoten, c.ten as tentb
            FROM suachua as a, nguoidung as b, thietbi as c
            WHERE a.nguoidung_id = b.id
            AND a.thietbi_id = c.id 
            AND a.phancong = $id
            ORDER BY a.id DESC";
        // } else {
        // $query = "SELECT a.*, c.ten as tentb
        //     FROM suachua as a, thietbi as c
        //     WHERE a.nguoidung_id = '{$id}'
        //     AND a.thietbi_id = c.id
        //     ORDER BY a.id DESC";
        // }
        $rs = $this->conn->query($query);
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
            'staff' => $dataStaff
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM suachua WHERE id = $id";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryStaffAssign = "SELECT * FROM suachua WHERE id = $id";
        $rsStaffAssign = $this->conn->query($queryStaffAssign);
        $dataStaffAssign = array();
        while ($row = $rsStaffAssign->fetch_assoc()) {
            $dataStaffAssign[] = $row;
        }
        return [
            'data' => $data,
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
        $noidung = '<strong>Tiêu đề :</strong> ' . $tieude . '<br> <strong>Ngày tạo :</strong>' . $date . '<br> <strong>Nội dung :</strong><br><p>' . $noidung . '</p>';
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
    function updateStatusRepair($id, $status)
    {
        $query = "UPDATE `suachua` 
        SET `tinhtrang`= '$status'
        WHERE `id`=$id";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi cập nhật"
            ];
        }
    }
    function assignRepair($idStaff, $id)
    {
        $query = "UPDATE `suachua` 
        SET `phancong`= $idStaff
        WHERE `id`='$id'";
        $result = $this->conn->query($query);
        $queryStaff = "SELECT email FROM nguoidung WHERE id = $idStaff LIMIT 1";
        $rsDataStaff = $this->conn->query($queryStaff);
        $emailStaff = $rsDataStaff->fetch_assoc();
        // $this->sendEmailAssign("Assign", "Assign", 'ádasdsad', $emailStaff['email']);
        $noidung = '<strong>Tiêu đề :</strong> <br> <strong>Ngày tạo :</strong><br> <strong>Nội dung :</strong><br><p></p>';
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
