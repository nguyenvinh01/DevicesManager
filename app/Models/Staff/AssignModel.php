<?php

require_once "./app/Models/Model.php";
class AssignModel extends Model
{
    function getAssignList($id)
    {
        $query = "SELECT
        ql.id,
        ql.ngaykiemtra,
        ql.tinhtrang,
        ql.soluong,
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
    WHERE ql.nhanvien_id = $id;";

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

    function getDeviceById($id)
    {
        $query = "SELECT * FROM thietbi WHERE id = $id;";
        $rs = $this->conn->query($query);
        $data = $rs->fetch_assoc();
        // while ($row = $rs->fetch_assoc()) {
        //     $data[] = $row;
        // }
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
        return $data;
    }

    function getDataAddModal()
    {
        $dataDeviceType = $this->getDeviceType();
        $dataDepartment = $this->getDepartment();
        return [
            'status' => 'success',
            'dataDeviceType' => $dataDeviceType,
            'dataDepartment' => $dataDepartment,
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
    public function getDataModal($id)
    {
        $query = "SELECT * FROM quanly WHERE id = $id";
        $rs = $this->conn->query($query);
        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        $queryStaffAssign = "SELECT * FROM suachua WHERE id = $id";
        $rsStaffAssign = $this->conn->query($queryStaffAssign);
        $dataStaffAssign = array();
        while ($row = $rsStaffAssign->fetch_assoc()) {
            $dataStaffAssign[] = $row;
        }
        return [
            'data' => $data,
            'staffAssign' => $dataStaffAssign
        ];
    }
    function updateStatusRepair($id, $status)
    {
        $query = "UPDATE `quanly` 
        SET `tinhtrang`= '$status'
        WHERE `id`=$id";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Cập nhật thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Có lỗi xảy ra khi cập nhật"
            ];
        }
    }
}
