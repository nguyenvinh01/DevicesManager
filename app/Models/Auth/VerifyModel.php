<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./app/config/library.php";
require_once "./app/config/constant.php";

require_once "vendor/autoload.php";
class VerifyModel extends Model
{
    function ResendVerify($email)
    {

        $emailExistsQuery = "SELECT *, COUNT(*) as count FROM nguoidung WHERE email = '{$email}'";
        $emailExistsResult = $this->conn->query($emailExistsQuery);
        $emailExists = $emailExistsResult->fetch_assoc();
        $emailCount = $emailExists['count'];
        if ($emailCount == 0) {
            return [
                'status' => 'error',
                'message' => 'Email chưa đăng ký trong hệ thống'
            ];
        }
        if ($emailExists['verified'] == 1) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản đã được xác minh'
            ];
        }
        $randomBytes = random_bytes(32); // Tạo 32 byte ngẫu nhiên
        $token = hash('sha256', $randomBytes);
        $this->SendVerify($token, $email);
        $query = "UPDATE nguoidung SET verify_code = '{$token}' WHERE email = '$email';";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Gửi xác nhận thành công',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Gửi xác nhận không thành công',
            ];
        }
    }

    public function VerifyToken($token)
    {
        $query = "SELECT *, COUNT(*) as count FROM nguoidung WHERE verify_code = '$token'";
        $account = $this->conn->query($query);
        $rs = $account->fetch_assoc();
        if ($rs['count'] > 0) {
            if ($rs['verified'] == 0) {
                $id = $rs['id'];
                $updatedVerify = "UPDATE `nguoidung` SET `verified` = '1' WHERE `nguoidung`.`id` = $id";
                $this->conn->query($updatedVerify);
                return [
                    'status' => 'success',
                    'message' => 'Xác minh tài khoản thành công'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Tài khoản đã được xác minh'
                ];
            }
        } else
            return [
                'status' => 'error',
                'message' => 'Xác minh không tồn tại'
            ];
    }
    public function SendVerify($verify, $email)
    {

        // $noidung = "<a href = " . BASE_URL . "/verify/code?token=$verify>Click</a>";
        $noidung = '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Chào mừng đến với Hệ thống Quản lý Thiết bị và tài sản</title>
        </head>
        <body>
            <div style="text-align: center; background-color: #f2f2f2; padding: 20px;">
                <h1>Chào mừng đến với Hệ thống Quản lý Tài sản</h1>
                <p>Xin chào </p>
                <p>Cảm ơn bạn đã đăng ký sử dụng dịch vụ của chúng tôi. Để hoàn tất quá trình đăng ký, vui lòng nhấn vào liên kết sau đây:</p>
                <p><a href="' . BASE_URL . '/verify/code?token=' . $verify . '" style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none;">Xác minh Email</a></p>
                <p>Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua email này.</p>
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
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Mã xác nhận Email';
            $mail->Body = $noidung;
            $mail->AltBody = $noidung;
            $result = $mail->send();
            if (!$result) {
                $error = "Có lỗi xảy ra trong quá trình gửi mail";
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            // }
        }
        return [
            "status" => "success",
            "message" => "Gửi thông báo thành công"
        ];
    }
}
