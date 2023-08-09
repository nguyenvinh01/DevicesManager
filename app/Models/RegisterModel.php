<?php

require_once "./app/Models/Model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        $verify_token = md5(rand());
        $hashPassword = $this->hashPassword($matkhau);

        $query = "INSERT INTO nguoidung ( hoten, email, sodienthoai, diachi, taikhoan, matkhau, quyen_id) VALUES ( '{$hoten}', '{$email}', '{$sodienthoai}', '{$diachi}', '{$taikhoan}', '{$hashPassword}', 2) ";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Đăng ký thành công',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Đăng ký không thành công',
            ];
        }
    }
    function SendVerify($verify, $email)
    {
        $query = "INSERT INTO thongbao ( tieude, noidung) 
            VALUES";
        $result = $this->conn->query($query);
        if ($result) {
            $querytb = "SELECT * FROM nguoidung WHERE quyen_id = 2";
            $resultb = $this->conn->query($querytb);
            $num_rows = mysqli_num_rows($resultb);

            if ($num_rows > 0) {
                $noidung = '<strong>Mã xác nhận :</strong> ' . $verify . '<br> <strong>Ngày tạo :</strong>' . 'rerdf' . '<br> <strong>Nội dung :</strong><br><p>' . 'asdfas' . '</p>';
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
                    // $mail->addReplyTo(SMTP_UNAME, 'WEBSITE NHÀ TRƯỜNG');
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
                }
            }
            return [
                "status" => "success",
                "message" => "Gửi thông báo thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi trong quá trình gửi"
            ];
        }
    }
}
