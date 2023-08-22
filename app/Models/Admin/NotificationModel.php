<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";
require_once "./app/config/library.php";
// use PHPMailer\PHPMailer\PHPMailer;
require_once "./app/Models/Model.php";
class NotificationModel extends Model
{
    function getNotification()
    {
        $query = "SELECT *
        FROM thongbao
         ORDER BY id DESC";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    function sendNotification($tieude, $noidung, $date)
    {
        $query = "INSERT INTO thongbao ( tieude, noidung) 
        VALUES ( '{$tieude}', '{$noidung}') ";
        $result = $this->conn->query($query);
        if ($result) {
            $querytb = "SELECT * FROM nguoidung WHERE quyen_id = 2";
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
            // header("Location: ../notification?msg=1");
            return [
                "status" => "success",
                "message" => "Gửi thông báo thành công"
            ];
        } else {
            // header("Location: ../notification?msg=2");
            return [
                "status" => "error",
                "message" => "Có lỗi trong quá trình gửi"
            ];
        }
    }
}
