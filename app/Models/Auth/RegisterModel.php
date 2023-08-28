<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "./app/config/library.php";
require_once "./app/config/constant.php";

require_once "vendor/autoload.php";
class RegisterModel extends Model
{
    function Register($hoten, $email, $sodienthoai, $diachi, $taikhoan, $matkhau)
    {

        $emailExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE email = '{$email}'";
        $emailExistsResult = $this->conn->query($emailExistsQuery);
        $emailExists = $emailExistsResult->fetch_assoc();
        $emailCount = $emailExists['count'];
        if ($emailCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Email đã tồn tại trong hệ thống.'
            ];
        }

        // Kiểm tra trùng tài khoản
        $taikhoanExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE taikhoan = '{$taikhoan}'";
        $taikhoanExistsResult = $this->conn->query($taikhoanExistsQuery);
        $taikhoanExists = $taikhoanExistsResult->fetch_assoc();
        $taikhoanCount = $taikhoanExists['count'];

        if ($taikhoanCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản đã tồn tại trong hệ thống.'
            ];
        }

        $hashPassword = $this->hashPassword($matkhau);
        $token = md5(rand());
        $response = $this->SendVerify($token, $email);
        $query = "INSERT INTO nguoidung ( hoten, email, sodienthoai, diachi, taikhoan, matkhau, verify_code, verified, quyen_id) VALUES ( '{$hoten}', '{$email}', '{$sodienthoai}', '{$diachi}', '{$taikhoan}', '{$hashPassword}', '{$token}', 0, 2) ";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Đăng ký thành công' + $response,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Đăng ký không thành công',
            ];
        }
    }
    public function VerifyToken($token)
    {
        $query = "SELECT * FROM nguoidung WHERE `nguoidung`.`verify_code` = '$token'";
        $account = $this->conn->query($query);
        $rs = $account->fetch_assoc();
        if (count($rs) > 0) {
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
                    'status' => 'false',
                    'message' => 'Tài khoản đã được xác minh'
                ];
            }
        } else {
            return [
                'status' => 'false',
                'message' => 'Xác minh không tồn tại'
            ];
        }
    }
    public function SendVerify($verify, $email)
    {

        $noidung = "<a href = " . BASE_URL . "/verify?token=$verify>Click</a>";
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
