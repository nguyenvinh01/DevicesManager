<?php

require_once "./app/Models/Model.php";
class AssignModel extends Model
{
    function getAssignList($filter, $keyword, $page, $department, $eDate, $sDate)
    {
        $offset = $page * 10;

        $query = "SELECT
        ql.id,
        ql.ngaykiemtra,
        ql.tinhtrang,
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
    WHERE 1 ";

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
    function assignDevice($phongban, $tentb, $soluong)
    {
        // Kiểm tra trùng email
        $queryBuilding = "SELECT dd.toanha as toanha_id, dd.id as phong_id , pb.id as phongban_id FROM diadiem as dd, phongban as pb 
        WHERE pb.id = $phongban 
        AND pb.diadiem = dd.id;";
        $rsBuilding = $this->conn->query($queryBuilding);
        $dataBuilding = $rsBuilding->fetch_assoc();
        $tenpb = $dataBuilding["phongban_id"];
        $toanha = $dataBuilding["toanha_id"];
        $phong = $dataBuilding["phong_id"];
        $time = date('Y-m-d');
        // Thực hiện câu lệnh INSERT
        $insertQuery = "INSERT INTO quanly (tentb, soluong, nhanvien_id, phongban, toanha, tinhtrang, diadiem, ngaykiemtra, ngaycapnhat) 
                    VALUES ('{$tentb}', '{$soluong}', null, '{$tenpb}', '{$toanha}', null,'{$phong}',null, '$time')";
        $result = $this->conn->query($insertQuery);

        if ($result) {
            $queryMinusDevice = "UPDATE `thietbi`
            SET `soluong` = soluong-$soluong 
            WHERE `id`=$tentb";
            $this->conn->query($queryMinusDevice);

            return [
                'status' => 'success',
                'message' => 'Phân quyền sử dụng thành công.',
                'query' => $insertQuery,
                'bb' => $queryMinusDevice
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình thực hiện.',
                'query' => $insertQuery

            ];
        }
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
        $dataDeviceType = $this->getDeviceType();
        $dataDepartment = $this->getDepartment();
        return [
            'status' => 'success',
            'dataDeviceType' => $dataDeviceType,
            'dataDepartment' => $dataDepartment['data'],
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
    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        return [
            'status' => 'success',
            'data' => $data,
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

    function getDeviceType()
    {
        $query = "SELECT * FROM loaithietbi";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
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
        WHERE `id`={$id}";
        $result = $this->conn->query($query);
        if ($result) {
            // header("Location: ../repair?msg=1");
            return [
                "status" => "success",
                "message" => $query
            ];
        } else {
            // header("Location: ../repair?msg=2");
            return [
                "status" => "error",
                "message" => $query
            ];
        }
    }
}
