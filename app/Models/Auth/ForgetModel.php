<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./app/config/library.php";
require_once "./app/config/constant.php";

require_once "vendor/autoload.php";
class ForgetModel extends Model
{
    function ForgetPassword($email)
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
        // if ($emailExists['verified'] == 1) {
        //     return [
        //         'status' => 'error',
        //         'message' => 'Tài khoản đã được xác minh'
        //     ];
        // }
        $newPass = $this->generateRandomPassword(); // Tạo 32 byte ngẫu nhiên
        // $token = hash('sha256', $randomBytes);
        $hashPassword = $this->hashPassword($newPass);

        $this->SendVerify($newPass, $email);

        $query = "UPDATE nguoidung SET matkhau = '{$hashPassword}' WHERE email = '$email';";

        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Đặt lại mật khẩu thành công',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi trong quá trình xử lý',
            ];
        }
    }

    // public function VerifyToken($token)
    // {
    //     $query = "SELECT * FROM nguoidung WHERE `nguoidung`.`verify_code` = '$token'";
    //     $account = $this->conn->query($query);
    //     $rs = $account->fetch_assoc();
    //     if (count($rs) > 0) {
    //         if ($rs['verified'] == 0) {
    //             $id = $rs['id'];
    //             $updatedVerify = "UPDATE `nguoidung` SET `verified` = '1' WHERE `nguoidung`.`id` = $id";
    //             $this->conn->query($updatedVerify);
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'Xác minh tài khoản thành công'
    //             ];
    //         } else {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Tài khoản đã được xác minh'
    //             ];
    //         }
    //     } else {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Xác minh không tồn tại'
    //         ];
    //     }
    // }
    function generateRandomPassword($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}[]|';
        $password = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $max)];
        }

        return $password;
    }
    public function SendVerify($newPass, $email)
    {

        //     $noidung = "
        //     <a href = " . BASE_URL . "/verify/code?token=$verify>Click</a>
        //     <div style='text-align: center; background-color: #f2f2f2; padding: 20px;'>
        //     <h1>Email Verification</h1>
        //     <p></p>
        //     <p>Thank you for signing up with our service. To complete your registration, please click the following link:</p>
        //     <p><a href = \" . BASE_URL . \"/verify/code?token=$verify\" style=\"background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none;\">Verify Your Email</a></p>
        //     <p>If you didnt request this, you can safely ignore this email.</p>
        //     <p>Best regards,<br>Your Company Name</p>
        // </div>
        //     ";
        $noidung = '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Chào mừng đến với Hệ thống Quản lý Thiết bị và tài sản</title>
            <title>Thông báo mật khẩu mới</title>
        </head>
        <body>
            <div style="text-align: center; background-color: #f2f2f2; padding: 20px;">
                <h1>Xin chào, bạn đã yêu cầu mật khẩu mới</h1>
                <p>Chúng tôi đã tạo một mật khẩu mới cho bạn. Đây là mật khẩu mới của bạn:</p>
                <p style="font-size: 24px; font-weight: bold;">' . $newPass . '</p>
                <p>Hãy đảm bảo lưu trữ mật khẩu này một cách an toàn. Bạn có thể đăng nhập bằng mật khẩu mới này để truy cập vào hệ thống của chúng tôi.</p>
                <p>Nếu bạn không yêu cầu mật khẩu mới, vui lòng liên hệ với chúng tôi ngay lập tức.</p>
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
