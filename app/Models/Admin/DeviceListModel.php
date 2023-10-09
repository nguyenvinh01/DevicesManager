<?php

require_once "./app/Models/Model.php";
// require_once "./public/PHPExcel.php";
// require_once "./public/PHPExcel/IOFactory.php";

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Zend\Barcode\Barcode;

class DeviceListModel extends Model
{
    function getDeviceList($keyword, $page, $type, $cate)
    {
        $offset = $page * 5;

        $query = "SELECT a.*, b.ten as tenloai
        FROM thietbi as a,loaithietbi as b, danhmuc as c
        WHERE a.loaithietbi_code = b.maloai AND b.madanhmuc = c.madanhmuc";

        if ($keyword != '') {
            $query .= " AND a.ten LIKE '%$keyword%'";
        }
        if ($type != '') {
            $query .= " AND a.loaithietbi_code = '$type'";
        }
        if ($cate != '') {
            $query .= " AND a.madanhmuc = '$cate' AND c.madanhmuc = '$cate'";
        }
        $queryCount = $query;

        $query .= " ORDER BY a.id DESC LIMIT 5 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryDevicetype = "SELECT lt.*, COUNT(tb.id) AS so_luong
        FROM loaithietbi lt
        LEFT JOIN thietbi tb ON lt.maloai = tb.loaithietbi_code
        WHERE lt.madanhmuc = '$cate'
        GROUP BY lt.maloai;";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        // $lastId = $this->getLastId('thietbi');
        // return $data;
        return [
            'status' => 'success',
            'data' => $data,
            'devicetype' => $dataType,
            'count' => count($rsCount->fetch_all()),
            'categories' => $this->getDeviceCategories()
            // 'count' => count($rsCount->fetch_all())
        ];
    }
    function getDeviceType($cate)
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT lt.*, COUNT(tb.id) AS so_luong
        FROM loaithietbi lt
        LEFT JOIN thietbi tb ON lt.maloai = tb.loaithietbi_code
        WHERE lt.madanhmuc = '$cate'
        GROUP BY lt.ten;";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
    function getDeviceCategories()
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT dm.*, COUNT(tb.madanhmuc) AS so_luong
        FROM danhmuc dm
        LEFT JOIN thietbi tb ON dm.madanhmuc = tb.madanhmuc
        GROUP BY dm.madanhmuc;";
        $queryAll = "SELECT COUNT(*) AS soluong_all
        FROM thietbi as tb";
        $rs = $this->conn->query($query);
        $rsAll = $this->conn->query($queryAll);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'all' => $rsAll->fetch_assoc()
        ];
    }
    public function getDataModal($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        $queryDevicetype = "SELECT * FROM loaithietbi WHERE madanhmuc = '{$data['madanhmuc']}'";
        $rsType = $this->conn->query($queryDevicetype);
        $dataType = array();
        while ($row = $rsType->fetch_assoc()) {
            $dataType[] = $row;
        }
        $queryDevicecate = "SELECT * FROM danhmuc";
        $rsCate = $this->conn->query($queryDevicecate);
        $dataCate = array();
        while ($row = $rsCate->fetch_assoc()) {
            $dataCate[] = $row;
        }
        return [
            'data' => $data,
            'devicetype' => $dataType,
            'cate' => $dataCate
        ];
    }

    function addDevice($ten,  $ltb, $dtkt, $image, $cate)
    {
        $queryLastId = "SELECT MAX(mathietbi) AS count
        FROM thietbi
        WHERE madanhmuc = '$cate' AND loaithietbi_code = '$ltb';";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $ma_thiet_bi = $ltb . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);

        $barcodeImage = $this->generateBarcode($ma_thiet_bi);
        $tenbarcode = $this->generateMixedRandomString($ma_thiet_bi);
        $barcodeImagePath = "./uploads/barcode/{$tenbarcode}.png";
        file_put_contents($barcodeImagePath, $barcodeImage);
        $query = "INSERT INTO thietbi ( ten, hinhanh, loaithietbi_code, dactinhkithuat, mathietbi, madanhmuc, trangthai, barcode) 
        VALUES ( '{$ten}', '{$image}', '{$ltb}', '{$dtkt}', '{$ma_thiet_bi}', '{$cate}', 'Sẵn Sàng', '{$barcodeImagePath}') ";


        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công",
                "query" => $query,
                "last" => $queryLastId

            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại",
                "query" => $query,
                "last" => $queryLastId
            ];
        }
    }
    function duplicateDevice($id, $ten, $ltb, $dtkt, $image, $cate)
    {
        $imageTb = $image;
        $queryLastId = "SELECT MAX(mathietbi) AS count
        FROM thietbi
        WHERE madanhmuc = '$cate' AND loaithietbi_code = '$ltb';";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $ma_thiet_bi = $ltb . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);
        if ($image == null) {
            $queryImage = "SELECT hinhanh FROM thietbi WHERE id = $id";
            $rsImage = $this->conn->query($queryImage)->fetch_assoc();

            $imageTb = $rsImage['hinhanh'];
        }
        $barcodeImage = $this->generateBarcode($ma_thiet_bi);
        $tenbarcode = $this->generateMixedRandomString($ma_thiet_bi);
        $barcodeImagePath = "./uploads/barcode/{$tenbarcode}.png";
        file_put_contents($barcodeImagePath, $barcodeImage);
        $query = "INSERT INTO thietbi ( ten, hinhanh, loaithietbi_code, dactinhkithuat, mathietbi, madanhmuc, trangthai, barcode) 
        VALUES ( '{$ten}', '{$imageTb}', '{$ltb}', '{$dtkt}', '{$ma_thiet_bi}', '{$cate}', 'Sẵn Sàng', '{$barcodeImagePath}') ";

        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Tạo thành công",
                "query" => $query,
                "last" => $queryLastId

            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Tạo thất bại",
                "query" => $query,
                "last" => $queryLastId
            ];
        }
    }
    // function generateBarcode($text, $outputFileName = './uploads/barcode/')
    // {
    //     $barcodeOptions = [
    //         'text' => $text,
    //         'drawText' => true,
    //     ];

    //     $rendererOptions = ['imageType' => 'png'];

    //     Barcode::factory(
    //         'code128',
    //         'image',
    //         $barcodeOptions,
    //         $rendererOptions
    //     )->render();
    // }
    function generateMixedRandomString($deviceCode)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $length = 10;
        // Loại bỏ các ký tự đặc biệt và khoảng trắng khỏi mã thiết bị
        $deviceCode = preg_replace("/[^A-Za-z0-9]/", "", $deviceCode);

        // Kết hợp mã thiết bị và chuỗi ngẫu nhiên
        $combinedString = $deviceCode;

        for ($i = 0; $i < $length; $i++) {
            $combinedString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Sắp xếp lại chuỗi ngẫu nhiên
        $combinedArray = str_split($combinedString);
        shuffle($combinedArray);
        $randomString = implode('', $combinedArray);

        return $randomString;
    }

    function generateBarcode($code)
    {
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeImage = $barcodeGenerator->getBarcode($code, $barcodeGenerator::TYPE_CODE_128, 2, 70);

        return $barcodeImage;
    }
    // function generateBarcode($code)
    // {
    //     // Create an instance of the BarcodeGeneratorPNG class
    //     $generator = new BarcodeGeneratorPNG();

    //     // Define the barcode data (e.g., product code, number, etc.)
    //     $barcodeData = '123456789';

    //     // Generate the barcode image
    //     $barcodeImage = $generator->getBarcode($code, $generator::TYPE_CODE_128);

    //     // Define the folder where you want to save the barcode images
    //     $imageFolder = './uploads/barcode/';

    //     // Make sure the folder exists, create it if not
    //     if (!file_exists($imageFolder)) {
    //         mkdir($imageFolder, 0777, true);
    //     }

    //     // Generate a unique filename for the barcode image (e.g., using a timestamp)
    //     $timestamp = time();
    //     $barcodeFilename =  "$code.png";
    //     $barcodeImagePath = $imageFolder . $barcodeFilename;
    //     file_put_contents($barcodeImagePath, $barcodeImage);
    //     // Save the barcode image to the folder
    //     // imagepng($barcodeImage, $barcodeImagePath);
    // }
    function editDevice($id, $ten, $tinhtrang, $ltb, $dtkt, $image, $cate)
    {
        // $query = "UPDATE `thietbi` 
        // SET `ten`='{$ten}',`soluong`='{$soluong}',`dactinhkithuat`='{$dtkt}',`giatri`='{$giatri}', `tinhtrang`='{$tinhtrang}', `loaithietbi_id`='{$ltb}' , `hinhanh`='{$image}' 
        // WHERE `id`='{$id}'";
        if ($tinhtrang == "Sửa chữa") {

            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        }
        if ($image != null) {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}',`dactinhkithuat`='{$dtkt}', `trangthai`='{$tinhtrang}', `loaithietbi_code`='{$ltb}' , `hinhanh`='{$image}', `madanhmuc` = '{$cate}' 
            WHERE `id`='{$id}'";
        } else {
            $query = "UPDATE `thietbi` 
            SET `ten`='{$ten}', `dactinhkithuat`='{$dtkt}', `trangthai`='{$tinhtrang}', `loaithietbi_code`='{$ltb}', `madanhmuc` = '{$cate}' 
            WHERE `id`='{$id}'";
        }

        // $query . "WHERE `id`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Cập nhật thất bại",
                "query" => $query
            ];
        }
    }
    function deleteDevice($id)
    {
        $check = "SELECT thietbi_id FROM muon WHERE thietbi_id = '{$id}'
        UNION ALL
        SELECT thietbi_id FROM suachua WHERE thietbi_id = '{$id}'";
        $result = $this->conn->query($check);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            // header("Location: ../devicelist?msg=2");
            return [
                "status" => "error",
                "message" => "Xóa thất bại",
                "query" => $check
            ];
        } else {
            $query = "DELETE FROM thietbi WHERE `id`='{$id}'";
            $this->conn->query($query);
            // header("Location: ../devicelist?msg=1");
            return [
                "status" => "success",
                "message" => "Xóa thành công",
                "query" => $check

            ];
        }
    }
    function getDeviceTypeCode($id)
    {
        $query = "SELECT maloai FROM loaithietbi WHERE id = $id";
        $result = $this->conn->query($query);
        $maloai = $result->fetch_assoc();
        return $maloai['maloai'];
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
    public function exportExcel($keyword, $type, $cate)
    {
        // $query = "SELECT *
        // FROM nguoidung 
        // WHERE quyen_id = 2";
        $query = "SELECT a.*, b.ten as tenloai, c.tendanhmuc
        FROM thietbi as a,loaithietbi as b, danhmuc as c
        WHERE a.loaithietbi_code = b.maloai AND b.madanhmuc = c.madanhmuc";

        if ($keyword != '') {
            $query .= " AND a.ten LIKE '%$keyword%'";
        }
        if ($type != '') {
            $query .= " AND a.loaithietbi_code = '$type'";
        }
        if ($cate != '') {
            $query .= " AND a.madanhmuc = '$cate' AND c.madanhmuc = '$cate'";
        }

        // $query .= " ORDER BY a.id DESC";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_all(MYSQLI_ASSOC);


        // Tạo một đối tượng PHPExcel và cấu hình tệp Excel
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getProperties()->setTitle("Exported Devices");

        //Thêm dữ liệu từ cơ sở dữ liệu vào tệp Excel
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Mã thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Tên thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Loại thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Trạng thái');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Danh mục thiết bị');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Mã danh mục');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Mã loại');

        $row = 2;
        foreach ($data as $device) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, (int)$device['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $device['mathietbi']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $device['ten']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $device['tenloai']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $device['trangthai']);

            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $device['tendanhmuc']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $device['loaithietbi_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $device['madanhmuc']);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
            $row++;
        }

        // // Lưu tệp Excel vào thư mục "uploads"
        $writer = new Xlsx($objPHPExcel);

        $filename = 'Danh sách thiết bị.xlsx';
        // $filename = 'C:/Downloads/Danh sách người dùng.xlsx';
        $uniqueFileName = $this->getUniqueFileName($filename);
        $writer->save($uniqueFileName);

        // Trả về URL của tệp Excel trong phản hồi Ajax
        // return [
        //     'status' => 'success',
        //     'fileUrl' => $uniqueFileName
        // ];
        return $uniqueFileName;
        // return $objPHPExcel;
    }
}
