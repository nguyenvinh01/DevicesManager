<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";
require_once "./app/config/library.php";
// use PHPMailer\PHPMailer\PHPMailer;
require_once "./app/Models/Model.php";
class NotificationModel extends Model
{
    function getNotification($keyword, $page, $eDate, $sDate)
    {
        $offset = $page * 15;

        $query = "SELECT *
        FROM thongbao WHERE 1";
        if ($sDate != '' && $eDate != '') {
            $query .= " AND ngaytao <= '$eDate' AND ngaytao >= '$sDate'";
        }
        if ($keyword != '') {
            $query .= " AND tieude LIKE '%$keyword%'";
        }
        $queryCount = $query;

        $query .= " ORDER BY id DESC LIMIT 15 OFFSET $offset";
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
    public function getDataModal($id)
    {
        $query = "SELECT *
        FROM thongbao WHERE id = $id
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
                // $noidung = '<strong>Tiêu đề :</strong> ' . $tieude . '<br> <strong>Ngày tạo :</strong>' . $date . '<br> <strong>Nội dung :</strong><br><p>' . $noidung . '</p>';
                $noidung = '
                <!DOCTYPE html>
                <html lang="vi">
                <head>
                    <meta charset="UTF-8">
                    <title>Thông báo từ Hệ thống</title>
                </head>
                <body>
                    <div style="text-align: center; background-color: #f2f2f2; padding: 20px;">
                        <h1>' . $tieude . '</h1>
                        <p>Ngày tạo: ' . $date . '</p>
                        <p>Nội dung:</p>
                        <p>' . $noidung . '</p>
                        <p>Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, vui lòng liên hệ với chúng tôi tại địa chỉ email sau: nguyenthanhvinh7511@gmail.com.</p>
                        <p>Trân trọng</p>
                    </div>
                </body>
                </html>
                ';
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
