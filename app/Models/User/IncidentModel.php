<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once "./app/config/library.php";
// require_once "./vendor/autoload.php";
require_once "./app/Models/Model.php";
class IncidentModel extends Model
{
    function getIncidentList()
    {
        if ($_SESSION['quyen'] == 1) {
            $query = "SELECT a.*, b.hoten
            FROM suco as a, nguoidung as b
            WHERE a.nguoidung_id = b.id
            ORDER BY a.id DESC";
        } else {
            $query = "SELECT *
            FROM suco
            WHERE nguoidung_id = '{$_SESSION['id']}'
            ORDER BY id DESC";
        }
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
        $query = "SELECT a.*,b.ten as 'tenloai'
        FROM thietbi as a,loaithietbi as b
        WHERE a.loaithietbi_id = b.id 
        ORDER BY a.id DESC";
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
    function getDeviceType()
    {
        $query = "SELECT * FROM loaithietbi Order by id desc";
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
    function sendIncident($tieude, $noidung, $date)
    {
        $query = "INSERT INTO suco ( tieude, noidung, nguoidung_id) 
        VALUES ( '{$tieude}', '{$noidung}', '{$_SESSION["id"]}') ";
        $result = $this->conn->query($query);
        if ($result) {
            $querytb = "SELECT * FROM nguoidung WHERE quyen_id = 1";
            $resultb = $this->conn->query($querytb);
            $num_rows = mysqli_num_rows($resultb);
            if ($num_rows > 0) {
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
                    while ($arUser = mysqli_fetch_array($resultb, MYSQLI_ASSOC)) {
                        $mail->addAddress($arUser['email'], $arUser['hoten']);
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
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
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
}
