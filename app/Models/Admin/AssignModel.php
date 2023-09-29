<?php

require_once "./app/Models/Model.php";
class AssignModel extends Model
{
    function getAssignList($filter, $keyword, $page, $department, $eDate, $sDate)
    {
        $offset = $page * 10;

        $query = "SELECT
        ql.id,
        ql.madoncapphat,
        ql.ngaykiemtra,
        ql.tinhtrang,
        ql.trangthai,
        ql.soluong,
        ql.tentb,
        ql.nhanvien_id,
        T.ten AS ten_thietbi,
        PB.tenpb AS ten_phongban,
        TN.tentoanha AS ten_toanha,
        DD.phong AS ten_diadiem,
        nv.hoten AS ten_nv
    FROM
        quanly AS ql
    LEFT JOIN
        thietbi AS T ON ql.tentb = T.id
    LEFT JOIN
        phongban AS PB ON ql.phongban = PB.id
    LEFT JOIN
        toanha AS TN ON ql.toanha = TN.id
    LEFT JOIN
        diadiem AS DD ON ql.diadiem = DD.id
    LEFT JOIN
        nguoidung AS nv ON ql.nhanvien_id = nv.id
    WHERE 1";

        if ($filter == 'hoten') {
            $query .= " AND nv.hoten LIKE '%$keyword%'";
        } elseif ($filter == 'thietbi') {
            $query .= " AND T.ten LIKE '%$keyword%'";
        }
        if ($department != '') {
            $query .= " AND PB.id = '$department'";
        }
        if ($sDate != '' && $eDate != '') {
            $query .= " AND ql.ngaykiemtra <= '$eDate' AND ql.ngaykiemtra >= '$sDate'";
        }
        $query .= " GROUP BY ql.madoncapphat";

        $queryCount = $query;
        $query .= " ORDER BY ql.id DESC LIMIT 10 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'count' => count($rsCount->fetch_all()),
            'query' => $query
        ];
    }
    function getAssignDetail($idCapPhat)
    {

        $query = "SELECT
        ql.id,
        ql.madoncapphat,
        ql.ngaykiemtra,
        ql.tinhtrang,
        ql.soluong,
        T.ten AS ten_thietbi,
        T.mathietbi AS mathietbi,
        PB.tenpb AS ten_phongban,
        TN.tentoanha AS ten_toanha,
        DD.phong AS ten_diadiem,
        nv.hoten AS ten_nv
    FROM
        quanly AS ql
    LEFT JOIN
        thietbi AS T ON ql.id_thietbi = T.id
    LEFT JOIN
        phongban AS PB ON ql.phongban = PB.id
    LEFT JOIN
        toanha AS TN ON ql.toanha = TN.id
    LEFT JOIN
        diadiem AS DD ON ql.diadiem = DD.id
    LEFT JOIN
        nguoidung AS nv ON ql.nhanvien_id = nv.id
    WHERE
        ql.madoncapphat = '${idCapPhat}'";
        $rs = $this->conn->query($query);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            'status' => 'success',
            'data' => $data,
            'query' => $query
        ];
    }
    function assignDevice($phongban, $soluong, $ltb)
    {

        // $queryBuilding = "SELECT dd.toanha as toanha_id, dd.id as phong_id , pb.id as phongban_id FROM diadiem as dd, phongban as pb 
        // WHERE pb.id = $phongban 
        // AND pb.diadiem = dd.id;";
        // $rsBuilding = $this->conn->query($queryBuilding);
        // $dataBuilding = $rsBuilding->fetch_assoc();
        // $tenpb = $dataBuilding["phongban_id"];
        // $toanha = $dataBuilding["toanha_id"];
        // $phong = $dataBuilding["phong_id"];
        // $time = date('Y-m-d');
        // // Thực hiện câu lệnh INSERT
        // $insertQuery = "INSERT INTO quanly (tentb, soluong, nhanvien_id, phongban, toanha, tinhtrang, diadiem, ngaykiemtra, ngaycapnhat) 
        //             VALUES ('{$tentb}', '{$soluong}', null, '{$tenpb}', '{$toanha}', null,'{$phong}',null, '$time')";
        // $result = $this->conn->query($insertQuery);

        // if ($result) {
        //     $queryMinusDevice = "UPDATE `thietbi`
        //     SET `soluong` = soluong-$soluong 
        //     WHERE `id`=$tentb";
        //     $this->conn->query($queryMinusDevice);

        //     return [
        //         'status' => 'success',
        //         'message' => 'Phân quyền sử dụng thành công.',
        //         'query' => $insertQuery,
        //         'bb' => $queryMinusDevice
        //     ];
        // } else {
        //     return [
        //         'status' => 'error',
        //         'message' => 'Có lỗi xảy ra trong quá trình thực hiện.',
        //         'query' => $insertQuery

        //     ];
        // }
        $queryLastId = "SELECT MAX(madoncapphat) AS count
        FROM quanly
        WHERE phongban = '{$phongban}'
        GROUP BY phongban;";
        $rsLastId = $this->conn->query($queryLastId);

        $lastId = $rsLastId->fetch_assoc();

        // Tách phần số ra khỏi mã cũ
        $id = (int)substr($lastId['count'], -5); // Lấy 5 ký tự cuối cùng
        // $maloai = $this->getDeviceTypeCode($ltb);
        $madoncapphat = "CP" . $phongban . "-" . str_pad($id + 1, 5, "0", STR_PAD_LEFT);
        $queryBuilding = "SELECT dd.toanha as toanha_id, dd.id as phong_id , pb.id as phongban_id FROM diadiem as dd, phongban as pb 
        WHERE pb.id = $phongban 
        AND pb.diadiem = dd.id;";
        $rsBuilding = $this->conn->query($queryBuilding);
        $dataBuilding = $rsBuilding->fetch_assoc();
        $tenpb = $dataBuilding["phongban_id"];
        $toanha = $dataBuilding["toanha_id"];
        $phong = $dataBuilding["phong_id"];
        $time = date('Y-m-d');

        // Kiểm tra số lượng thiết bị có sẵn
        $queryKiemTraSoLuong = "SELECT COUNT(*) AS soLuongCoSan FROM thietbi WHERE trangthai = 'Sẵn Sàng' AND loaithietbi_code = '${ltb}'";
        $resultKiemTraSoLuong = $this->conn->query($queryKiemTraSoLuong);
        $rowKiemTraSoLuong = $resultKiemTraSoLuong->fetch_assoc();
        $soLuongCoSan = $rowKiemTraSoLuong['soLuongCoSan'];

        // So sánh số lượng có sẵn và số lượng bạn muốn cấp phát
        if ($soLuongCoSan < $soluong) {
            // Không đủ thiết bị để cấp phát
            return [
                "status" => "error",
                "message" => "Không đủ thiết bị để cấp phát."
            ];
        } else {
            // Lấy danh sách thiết bị có trạng thái "Sẵn Sàng" và giới hạn theo số lượng cần cấp phát
            $queryLayDanhSachThietBi = "SELECT * FROM thietbi WHERE trangthai = 'Sẵn Sàng' AND loaithietbi_code = '${ltb}' LIMIT $soluong";
            $resultLayDanhSachThietBi = $this->conn->query($queryLayDanhSachThietBi);

            if ($resultLayDanhSachThietBi->num_rows > 0) {
                try {
                    while ($rowThietBi = $resultLayDanhSachThietBi->fetch_assoc()) {
                        $idThietBi = $rowThietBi['id'];
                        $mathietbi = $rowThietBi['mathietbi'];

                        // Insert vào bảng quản lý
                        $queryInsertQuanLy = "INSERT INTO quanly (id_thietbi,madoncapphat, nhanvien_id, phongban, toanha, tinhtrang, diadiem, ngaykiemtra, ngaycapnhat) 
                                    VALUES ( '{$idThietBi}','{$madoncapphat}', null, '{$tenpb}', '{$toanha}', null,'{$phong}',null, '$time')";
                        $this->conn->query($queryInsertQuanLy);

                        // Cập nhật trạng thái của thiết bị thành 'Đang Cấp Phát'
                        $queryCapNhatTrangThai = "UPDATE thietbi SET trangthai = 'Đang Cấp Phát' WHERE id = '$idThietBi'";
                        $this->conn->query($queryCapNhatTrangThai);
                    }

                    // Hoàn tất giao dịch
                    $this->conn->commit();

                    return [
                        "status" => "success",
                        "message" => "Cấp phát thiết bị thành công."
                    ];
                } catch (Exception $e) {
                    // Nếu có lỗi, hủy bỏ giao dịch

                    return [
                        "status" => "error",
                        "message" => "Có lỗi xảy ra trong quá trình cấp phát thiết bị."
                    ];
                }
            }
        }
        // $result = $this->conn->query($insertQuery);

        // if ($result) {
        //     $queryMinusDevice = "UPDATE `thietbi`
        //     SET `soluong` = soluong-$soluong 
        //     WHERE `id`=$tentb";
        //     $this->conn->query($queryMinusDevice);

        //     return [
        //         'status' => 'success',
        //         'message' => 'Phân quyền sử dụng thành công.',
        //         'query' => $insertQuery,
        //         'bb' => $queryMinusDevice
        //     ];
        // } else {
        //     return [
        //         'status' => 'error',
        //         'message' => 'Có lỗi xảy ra trong quá trình thực hiện.',
        //         'query' => $insertQuery

        //     ];
        // }
    }
    function getDeviceByType($idType)
    {
        $query = "SELECT * FROM thietbi WHERE loaithietbi_id = $idType;";
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


    function getDepartment()
    {
        $query = "SELECT * FROM phongban;";
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

    function getDataAddModal()
    {
        // $dataDeviceType = $this->getDeviceType();
        // $dataCategories = $this->getDeviceCategories();
        $dataDepartment = $this->getDepartment();
        return [
            'status' => 'success',
            // 'dataDeviceType' => $dataDeviceType,
            'dataDepartment' => $dataDepartment['data'],
            // 'dataCategories' => $dataCategories
        ];
    }
    function getStaff()
    {
        $query = "SELECT * FROM nguoidung WHERE quyen_id = 3;";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            "status" => "success",
            "data" => $data
        ];
    }
    // function getDeviceById($id)
    // {
    //     $query = "SELECT * FROM thietbi WHERE id = $id;";
    //     $rs = $this->conn->query($query);
    //     $data = $rs->fetch_assoc();
    //     return [
    //         'status' => 'success',
    //         'data' => $data,
    //     ];
    // }
    function getDeviceById($cate)
    {
        $query = "SELECT *, COUNT(id) as count FROM thietbi WHERE loaithietbi_code = '$cate' AND trangthai = 'Sẵn Sàng';";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
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
    function getUserById($id)
    {
        $query = "SELECT hoten, email, sodienthoai FROM nguoidung WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();

        return [
            "status" => "success",
            "data" => $data
        ];
    }

    function getDeviceType($cate)
    {
        // $query = "SELECT * FROM loaithietbi Order by id desc";
        $query = "SELECT lt.*, COUNT(tb.id) AS so_luong
        FROM loaithietbi lt, thietbi as tb
        WHERE lt.maloai = tb.loaithietbi_code
        AND lt.madanhmuc = '$cate' AND tb.trangthai = 'Sẵn Sàng'
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
    function sendRepair($idtb, $noidung)
    {
        $query = "INSERT INTO suachua (thietbi_id, noidung, nguoidung_id, tinhtrang) 
            VALUES ( '{$idtb}', '{$noidung}','{$_SESSION['id']}', 'Chờ xử lý') ";
        $result = $this->conn->query($query);
        if ($result) {
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
    function assignStaff($id, $idStaff, $ngayktra)
    {
        $query = "UPDATE `quanly` 
        SET `nhanvien_id`={$idStaff}, `ngaykiemtra`='{$ngayktra}', `tinhtrang`='Chờ xử lý'
        WHERE `madoncapphat`='{$id}'";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../repair?msg=1");
            return [
                "status" => "success",
                "message" => "Phân công kiểm tra thành công"
            ];
        } else {
            // header("Location: ../repair?msg=2");
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra trong hệ thống"
            ];
        }
    }
    function revokeDevice($idCapPhat)
    {
        $query = "SELECT * FROM quanly WHERE madoncapphat = '{$idCapPhat}'";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row['id_thietbi'];
        }
        // $queryRevoke = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE";
        $queryRevoke = "UPDATE thietbi SET trangthai = 'Sẵn Sàng' WHERE id IN (" . implode(",", $data) . ")";
        $queryRevokeAllocate = "UPDATE quanly SET trangthai = 'Đã Thu Hồi' WHERE madoncapphat = '{$idCapPhat}'";
        $this->conn->query($queryRevokeAllocate);
        $this->conn->query($queryRevoke);
        // foreach ($data as $d) {
        //     $queryRevoke .= "";
        // }
        return [
            "status" => "success",
            "message" => "Thu hồi thành công",
        ];
    }
}
