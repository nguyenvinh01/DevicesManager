<?php
require_once './app/config/constant.php';

require_once "./app/config/library.php";

require_once "./app/Models/Model.php";

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserListModel extends Model
{
    public function getUserList($option, $keyword, $page, $role)
    {
        $offset = $page * 10;
        $query = "SELECT *
            FROM nguoidung 
            WHERE quyen_id <> 1";
        if ($role != 0) {
            $query .= " AND quyen_id = $role";
        }

        if ($option != '' && $keyword != '') {
            $query .= " AND $option LIKE '%$keyword%'";
        }
        $queryCount = $query;
        $query .= " LIMIT 10 OFFSET $offset;";

        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        // return $data;
        return [
            'data' => $data,
            'count' => count($rsCount->fetch_all())
        ];
    }


    public function getModalEdit($id)
    {
        $query = "SELECT * FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);
        $queryLocation = "SELECT * FROM phongban";
        $rsLocation = $this->conn->query($queryLocation);
        $dataLocation = array();
        while ($row = $rsLocation->fetch_assoc()) {
            $dataLocation[] = $row;
        }
        return [
            "data" => $rs->fetch_assoc(),
            'location' => $dataLocation
        ];
    }

    public function getModalDel($id)
    {
        $query = "SELECT id, hoten FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);

        return $rs->fetch_assoc();
    }

    public function addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $phongban)
    {
        // Kiểm tra trùng email
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

        // Thực hiện câu lệnh INSERT
        // $insertQuery = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, phongban, quyen_id) 
        //             VALUES ('{$hoten}', '{$email}', '{$matkhau}', '{$sdt}', '{$taikhoan}' ,'{$diachi}', '{$phongban}', 2)";
        $randomBytes = random_bytes(32); // Tạo 32 byte ngẫu nhiên
        $hashPassword = $this->hashPassword($matkhau);

        $token = hash('sha256', $randomBytes);
        $this->SendVerify($token, $email);
        $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi,phongban, verify_code, verified, quyen_id) VALUE ('$hoten', '$email', '$hashPassword', '$sdt', '$taikhoan', '$diachi','$phongban' , '$token', 0 , '2')";
        $result = $this->conn->query($sql);

        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được cập nhật.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình thêm người dùng.'
            ];
        }
    }
    public function editUser($hoten, $email, $sdt, $taikhoan, $diachi, $id, $phongban, $role)
    {
        // Kiểm tra trùng email
        $emailExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE email = '{$email}' AND id != '{$id}'";
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
        $taikhoanExistsQuery = "SELECT COUNT(*) as count FROM nguoidung WHERE taikhoan = '{$taikhoan}' AND id != '{$id}'";
        $taikhoanExistsResult = $this->conn->query($taikhoanExistsQuery);
        $taikhoanExists = $taikhoanExistsResult->fetch_assoc();
        $taikhoanCount = $taikhoanExists['count'];
        if ($taikhoanCount > 0) {
            return [
                'status' => 'error',
                'message' => 'Tài khoản đã tồn tại trong hệ thống.'
            ];
        }

        // Thực hiện câu lệnh UPDATE
        $query = "UPDATE `nguoidung` 
                SET `hoten`='{$hoten}',`email`='{$email}',`sodienthoai`='{$sdt}',`taikhoan`='{$taikhoan}',`diachi`='{$diachi}', `phongban` = '{$phongban}', `quyen_id` = '$role'
                WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được cập nhật.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật người dùng.'
            ];
        }
    }

    public function deleteUser($id)
    {
        $check = "SELECT nguoidung_id FROM muon WHERE nguoidung_id = '{$id}'
        UNION ALL
        SELECT nguoidung_id FROM suco WHERE nguoidung_id = '{$id}'
        UNION ALL
        SELECT nguoidung_id FROM suachua WHERE nguoidung_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: taikhoan.php?msg=2");
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình xóa.'
            ];
        } else {
            $query = "DELETE FROM nguoidung WHERE `id`='{$id}'";
            $this->conn->query($query);
            return [
                'status' => 'success',
                'message' => 'Thông tin người dùng đã được xóa.'
            ];
        }
    }
    public function getDepartment()
    {
        $query = "SELECT * FROM phongban";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'data' => $data,
        ];
    }
    function getUniqueFileName($fileName)
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $timestamp = date('Ymd_His'); // Thêm timestamp vào tên tệp

        $counter = 1;
        $uniqueFileName = $baseName . '_' . $timestamp . '.' . $extension;

        return  $uniqueFileName;
    }

    public function exportExcel($option, $keyword, $role)
    {
        // $query = "SELECT *
        // FROM nguoidung 
        // WHERE quyen_id = 2";
        $query = "SELECT nd.*, q.ten as ten_quyen, pb.tenpb as tenphongban
    FROM nguoidung as nd, quyen as q, phongban as pb
    WHERE nd.quyen_id <> 1 AND q.id = nd.quyen_id AND pb.id = nd.phongban";
        if ($role != 0) {
            $query .= " AND nd.quyen_id = $role";
        }

        if ($option != '' && $keyword != '') {
            $query .= " AND nd.$option LIKE '%$keyword%'";
        }
        $rs = $this->conn->query($query);
        $data = $rs->fetch_all(MYSQLI_ASSOC);

        // Tạo một đối tượng Spreadsheet
        $spreadsheet = new Spreadsheet();

        // Lấy trang tính mặc định của Spreadsheet
        $sheet = $spreadsheet->getActiveSheet();

        // Thiết lập dữ liệu cột và hàng
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Họ tên');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Tài khoản');
        $sheet->setCellValue('E1', 'Địa chỉ');
        $sheet->setCellValue('F1', 'Số điện thoại');
        $sheet->setCellValue('G1', 'Phòng ban');
        $sheet->setCellValue('H1', 'Loại tài khoản');

        $row = 2;
        foreach ($data as $user) {
            $sheet->setCellValue('A' . $row, (int)$user['id']);
            $sheet->setCellValue('B' . $row, $user['hoten']);
            $sheet->setCellValue('C' . $row, $user['email']);
            $sheet->setCellValue('D' . $row, $user['taikhoan']);
            $sheet->setCellValue('E' . $row, $user['diachi']);
            $sheet->setCellValue('F' . $row, $user['sodienthoai']);
            $sheet->setCellValue('G' . $row, $user['tenphongban']);
            $sheet->setCellValue('H' . $row, $user['ten_quyen']);
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(15);
            $row++;
        }

        // Lưu tệp Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Danh_sach_nguoi_dung.xlsx';
        $uniqueFileName = $this->getUniqueFileName($filename);
        $writer->save($uniqueFileName);

        return $uniqueFileName;
        // return $objPHPExcel;
    }
    public function importExcel($excelFile)
    {
        $errors = [];
        try {
            $objPHPExcel = IOFactory::load($excelFile);
            $sheet = $objPHPExcel->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            // $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) VALUE";
            // $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) VALUES ('hoten', 'email', '123', 'id', 'ádds', 'diachi', '2')";

            for ($row = 2; $row <= $highestRow; $row++) {
                $hoten = $sheet->getCell('A' . $row)->getValue();
                $email = $sheet->getCell('B' . $row)->getValue();
                $taikhoan = $sheet->getCell('C' . $row)->getValue();
                $diachi = $sheet->getCell('D' . $row)->getValue();
                $sdt = $sheet->getCell('E' . $row)->getValue();
                // Kiểm tra nếu bất kỳ trường nào bị bỏ trống, thêm vào mảng lỗi
                if (empty($hoten) || empty($email) || empty($taikhoan) || empty($diachi) || empty($sdt)) {
                    array_push($errors, "Dòng $row: Một hoặc nhiều trường bị bỏ trống");
                    continue; // Bỏ qua dòng này và xử lý dòng tiếp theo
                }
                $hashPassword = $this->hashPassword($email);

                // Kiểm tra xem tài khoản, email hoặc số điện thoại đã tồn tại trong cơ sở dữ liệu chưa
                $checkQuery = "SELECT * FROM nguoidung WHERE taikhoan = '$taikhoan' OR email = '$email' OR sodienthoai = '$sdt'";
                $checkResult = $this->conn->query($checkQuery);
                if ($checkResult->num_rows > 0) {
                    array_push($errors, "Dòng $row: Tài khoản, email hoặc số điện thoại đã tồn tại trong cơ sở dữ liệu");
                    continue; // Bỏ qua dòng này và xử lý dòng tiếp theo
                }
                $randomBytes = random_bytes(32); // Tạo 32 byte ngẫu nhiên

                $token = hash('sha256', $randomBytes);
                $this->SendVerify($token, $email);
                $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, verify_code, verified, quyen_id) VALUE ('$hoten', '$email', '$hashPassword', '$sdt', '$taikhoan', '$diachi', '$token', 0 , '2')";
                $result = $this->conn->query($sql);
                if (!$result) {
                    array_push($errors, $token);
                    // Nếu không thành công, ghi lại lỗi
                }
            }
            $response = [
                'status' => 'success',
                'message' => 'Import thành công',
            ];
            if (count($errors) > 0) {
                $response = [
                    'status' => 'success',
                    'message' => 'Import thành công',
                    "error" => $errors
                ];
            }
            // Thực hiện truy vấn INSERT
            // $result = $this->conn->query($sql);

            // if ($result) {

            // }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Import that bai',
                "" => $errors

            ];
        }
        return $response;
    }
    public function SendVerify($verify, $email)
    {
        $verifyLink = BASE_URL . "/verify/code?token=$verify";

        $noidung = "
            <p>Xác nhận địa chỉ email của bạn:</p>
            <p>Nhấp vào nút dưới đây để xác nhận địa chỉ email của bạn:</p>
            <a href='$verifyLink' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none;'>Xác nhận Email</a>
            <p>Nếu bạn không thực hiện thao tác này, vui lòng bỏ qua email này.</p>
        ";
        // $noidung = "<a href = " . BASE_URL . "/verify/code?token=$verify>Click</a>";
        $mail = new PHPMailer(true);
        // try {
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
        // } catch (Exception $e) {
        //     echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        //     // }
        // }
        // return [
        //     "status" => "success",
        //     "message" => "Gửi thông báo thành công"
        // ];
    }
}
