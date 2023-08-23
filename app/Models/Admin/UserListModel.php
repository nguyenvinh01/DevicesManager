<?php
require_once './app/config/constant.php';

require_once "./app/Models/Model.php";
require_once "public\PHPExcel.php";
require_once "public\PHPExcel\IOFactory.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

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

        return $rs->fetch_assoc();
    }

    public function getModalDel($id)
    {
        $query = "SELECT id, hoten FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);

        return $rs->fetch_assoc();
    }

    public function addUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi)
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
        $insertQuery = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) 
                    VALUES ('{$hoten}', '{$email}', '{$matkhau}', '{$sdt}', '{$taikhoan}', '{$diachi}', 2)";
        $result = $this->conn->query($insertQuery);

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
    public function editUser($hoten, $email, $matkhau, $sdt, $taikhoan, $diachi, $id)
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
                SET `hoten`='{$hoten}',`email`='{$email}',`sodienthoai`='{$sdt}',`taikhoan`='{$taikhoan}',`diachi`='{$diachi}', `matkhau`='{$matkhau}', `quyen_id`=2
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

    function getUniqueFileName($fileName)
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $timestamp = date('Ymd_His'); // Thêm timestamp vào tên tệp

        $counter = 1;
        $uniqueFileName = $baseName . '_' . $timestamp . '.' . $extension;

        return  $uniqueFileName;
    }

    public function exportExcel()
    {
        $query = "SELECT *
        FROM nguoidung 
        WHERE quyen_id = 2";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_all(MYSQLI_ASSOC);


        // Tạo một đối tượng PHPExcel và cấu hình tệp Excel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Exported Users");

        //Thêm dữ liệu từ cơ sở dữ liệu vào tệp Excel
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Họ tên');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Số điện thoại');

        $row = 2;
        foreach ($data as $user) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $user['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $user['hoten']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $user['email']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $user['diachi']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $user['sodienthoai']);
            $row++;
        }

        // // Lưu tệp Excel vào thư mục "uploads"
        $filename = 'Danh sách người dùng.xlsx';
        // $filename = 'C:/Downloads/Danh sách người dùng.xlsx';
        $uniqueFileName = $this->getUniqueFileName($filename);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($uniqueFileName);

        // Trả về URL của tệp Excel trong phản hồi Ajax
        // return [
        //     'status' => 'success',
        //     'fileUrl' => $uniqueFileName
        // ];
        return $uniqueFileName;
        // return $objPHPExcel;
    }
    public function importExcel($excelFile)
    {

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($excelFile);
            $sheet = $objPHPExcel->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) VALUES ";
            // $sql = "INSERT INTO nguoidung (hoten, email, matkhau, sodienthoai, taikhoan, diachi, quyen_id) VALUES ('hoten', 'email', '123', 'id', 'ádds', 'diachi', '2')";

            for ($row = 2; $row <= $highestRow; $row++) {
                $id = $sheet->getCell('A' . $row)->getValue();
                $hoten = $sheet->getCell('B' . $row)->getValue();
                $email = $sheet->getCell('C' . $row)->getValue();
                $diachi = $sheet->getCell('D' . $row)->getValue();

                // Thực hiện truy vấn để lưu dữ liệu vào cơ sở dữ liệu
                $sql .= "('$hoten', '$email', '123', '$id', 'ádds', '$diachi', '2'), ";
            }

            $sql = rtrim($sql, ', ');

            // Thực hiện truy vấn INSERT
            $result = $this->conn->query($sql);

            if ($result) {
                $response = [
                    'status' => 'success',
                    'message' => 'Import thành công',
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Import that bai1 ',
            ];
        }
        return $response;
    }
}
