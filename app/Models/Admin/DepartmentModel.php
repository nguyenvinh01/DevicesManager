<?php

require_once "./app/Models/Model.php";
class DepartmentModel extends Model
{
    function deleteDepartment($id)
    {

        $query = "DELETE FROM phongban WHERE `id`='{$id}'";
        $this->conn->query($query);
        // header("Location: ../devicetype?msg=1");
        return [
            "status" => "success",
            "message" => "Xóa thành công"
        ];
        // }
    }

    function getDepartmentList($keyword, $page)
    {
        $offset = $page * 10;

        $query = "SELECT pb.*, dd.*, tn.tentoanha, pb.id as id_phongban
        FROM phongban as pb, diadiem as dd, toanha as tn
        WHERE pb.diadiem = dd.id 
        AND tn.id = dd.toanha";
        if ($keyword != '') {
            $query .= " AND tenpb LIKE '%$keyword%'";
        }
        $queryCount = $query;

        $query .= " ORDER BY pb.id DESC LIMIT 10 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            "status" => "success",
            "data" => $data,
            'count' => count($rsCount->fetch_all()),
        ];
    }
    function getBuildingList($keyword, $page)
    {
        $offset = $page * 10;

        $query = "SELECT dd.*, tn.tentoanha
        FROM  diadiem as dd, toanha as tn
        WHERE tn.id = dd.toanha";
        if ($keyword != '') {
            $query .= " AND tn.tentoanha LIKE '%$keyword%'";
        }
        $queryCount = $query;

        $query .= " ORDER BY dd.id DESC LIMIT 10 OFFSET $offset;";
        $rs = $this->conn->query($query);
        $rsCount = $this->conn->query($queryCount);

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }
        return [
            "status" => "success",
            "data" => $data,
            'count' => count($rsCount->fetch_all()),
        ];
    }
    function getBuilding()
    {
        $query = "SELECT dd.*, tn.id as toanhaid, tn.tentoanha
        FROM  diadiem as dd, toanha as tn
        GROUP BY tn.id";
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
    function getRoom($idToa, $idTang)
    {
        $query = "SELECT dd.*, tn.tentoanha
        FROM  diadiem as dd, toanha as tn
        WHERE dd.tang = '$idTang' AND dd.toanha = '$idToa' AND tn.id = '$idToa'
        ";
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
    function getFloor($idToanha)
    {
        $query = "SELECT dd.*, tn.tentoanha
        FROM  diadiem as dd, toanha as tn
        WHERE dd.toanha = '$idToanha'
        GROUP BY dd.tang";
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
    function addDepartment($tenphongban, $idToanha, $idTang, $idPhong)
    {
        $queryGetLocation = "SELECT * 
        FROM diadiem 
        WHERE toanha = '$idToanha' AND tang = '$idTang' AND phong = '$idPhong'";
        $rsLocation = $this->conn->query($queryGetLocation);
        $location = $rsLocation->fetch_assoc();
        $query = "INSERT INTO phongban (tenpb, diadiem) VALUE ('$tenphongban', '{$location['id']}')";
        $this->conn->query($query);
        return [
            "status" => "success",
            "message" => "Tạo thành công",
        ];
    }
    function getDataDelDepartment($idDepartment)
    {
        $query = "SELECT * FROM phongban WHERE id = '$idDepartment'";
        $rs = $this->conn->query($query);
        $rowDepartment = $rs->fetch_assoc();
        return [
            "status" => "success",
            "data" => $rowDepartment,
        ];
    }
    function getDataEditDepartment($idDepartment)
    {
        $query = "SELECT * FROM phongban WHERE id = '$idDepartment'";
        $rs = $this->conn->query($query);
        $rowDepartment = $rs->fetch_assoc();
        $queryGetLocation = "SELECT dd.*,  pb.tenpb, pb.id as id_pb
        FROM diadiem as dd, phongban as pb
        WHERE dd.id = '{$rowDepartment['diadiem']}' 
        AND dd.id = pb.diadiem";
        $rsLocation = $this->conn->query($queryGetLocation);
        $rowLocation = $rsLocation->fetch_assoc();
        $getBuilding = "SELECT * FROM toanha";
        $getFloor = "SELECT * FROM diadiem WHERE toanha = '{$rowLocation['toanha']}'";
        $getRoom = "SELECT * FROM diadiem WHERE toanha = '{$rowLocation['toanha']}' AND tang = '{$rowLocation['tang']}'";
        $rsBuilding = $this->conn->query($getBuilding);
        $rsFloor = $this->conn->query($getFloor);
        $rsRoom = $this->conn->query($getRoom);
        // $data = array();
        // while ($row = $rsLocation->fetch_assoc()) {
        //     $data[] = $row;
        // }
        $dataBuilding = array();
        while ($row = $rsBuilding->fetch_assoc()) {
            $dataBuilding[] = $row;
        }
        $dataFloor = array();
        while ($row = $rsFloor->fetch_assoc()) {
            $dataFloor[] = $row;
        }
        $dataRoom = array();
        while ($row = $rsRoom->fetch_assoc()) {
            $dataRoom[] = $row;
        }
        return [
            "status" => "success",
            "data" => $rowLocation,
            "building" => $dataBuilding,
            "floor" => $dataFloor,
            "room" => $dataRoom
        ];
    }
    function editDepartment($tenpb, $idPb, $idToanha, $idTang, $idPhong)
    {
        $queryCheckName = "SELECT * FROM phongban WHERE tenpb = '$tenpb' AND `id` != '$idPb'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if (mysqli_num_rows($rsCheckName) >= 1) {
            return [
                "status" => "error",
                "message" => "Tên phòng ban đã tồn tại"
            ];
        }
        $queryGetLocation = "SELECT * FROM diadiem WHERE toanha = '$idToanha' AND tang = '$idTang' AND phong = '$idPhong'";
        $rsLocation = $this->conn->query($queryGetLocation)->fetch_assoc();

        $query = "UPDATE `phongban` 
        SET `tenpb`='{$tenpb}', `diadiem` = '{$rsLocation['id']}'
        WHERE `id`='{$idPb}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Sửa thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => $query
            ];
        }
    }
    function addLocation($tendiadiem, $idTang, $idToaNha)
    {
        // $queryGetLocation = "SELECT * 
        // FROM diadiem 
        // WHERE phong = '$idPhong'";
        // $rsLocation = $this->conn->query($queryGetLocation);
        // $location = $rsLocation->fetch_assoc();
        $queryCheckName = "SELECT * FROM diadiem WHERE phong = '$tendiadiem' AND toanha = '$idToaNha' AND tang = '$idTang'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if (mysqli_num_rows($rsCheckName) >= 1) {
            return [
                "status" => "error",
                "message" => "Địa điểm đã tồn tại"
            ];
        }
        $query = "INSERT INTO diadiem (toanha, tang, phong) VALUE ('$idToaNha', '$idTang', '{$tendiadiem}')";
        $this->conn->query($query);
        return [
            "status" => "success",
            "message" => "Tạo thành công",
        ];
    }
    function editLocation($tenpb, $idPb, $idToanha, $idTang, $idPhong)
    {
        $queryCheckName = "SELECT * FROM phongban WHERE tenpb = '$tenpb' AND `id` != '$idPb'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if (mysqli_num_rows($rsCheckName) >= 1) {
            return [
                "status" => "error",
                "message" => "Tên phòng ban đã tồn tại"
            ];
        }
        $queryGetLocation = "SELECT * FROM diadiem WHERE toanha = '$idToanha' AND tang = '$idTang' AND phong = '$idPhong'";
        $rsLocation = $this->conn->query($queryGetLocation)->fetch_assoc();

        $query = "UPDATE `phongban` 
        SET `tenpb`='{$tenpb}', `diadiem` = '{$rsLocation['id']}'
        WHERE `id`='{$idPb}'";
        $result = $this->conn->query($query);
        if ($result) {
            return [
                "status" => "success",
                "message" => "Sửa thành công"
            ];
        } else {
            return [
                "status" => "error",
                "message" => $query
            ];
        }
    }
    function getDataDelLocation($idDepartment)
    {
        $query = "SELECT * FROM phongban WHERE id = '$idDepartment'";
        $rs = $this->conn->query($query);
        $rowDepartment = $rs->fetch_assoc();
        return [
            "status" => "success",
            "data" => $rowDepartment,
        ];
    }
    function getDataEditLocation($idDepartment)
    {
        $query = "SELECT * FROM phongban WHERE id = '$idDepartment'";
        $rs = $this->conn->query($query);
        $rowDepartment = $rs->fetch_assoc();
        $queryGetLocation = "SELECT dd.*,  pb.tenpb, pb.id as id_pb
        FROM diadiem as dd, phongban as pb
        WHERE dd.id = '{$rowDepartment['diadiem']}' 
        AND dd.id = pb.diadiem";
        $rsLocation = $this->conn->query($queryGetLocation);
        $rowLocation = $rsLocation->fetch_assoc();
        $getBuilding = "SELECT * FROM toanha";
        $getFloor = "SELECT * FROM diadiem WHERE toanha = '{$rowLocation['toanha']}'";
        $getRoom = "SELECT * FROM diadiem WHERE toanha = '{$rowLocation['toanha']}' AND tang = '{$rowLocation['tang']}'";
        $rsBuilding = $this->conn->query($getBuilding);
        $rsFloor = $this->conn->query($getFloor);
        $rsRoom = $this->conn->query($getRoom);
        // $data = array();
        // while ($row = $rsLocation->fetch_assoc()) {
        //     $data[] = $row;
        // }
        $dataBuilding = array();
        while ($row = $rsBuilding->fetch_assoc()) {
            $dataBuilding[] = $row;
        }
        $dataFloor = array();
        while ($row = $rsFloor->fetch_assoc()) {
            $dataFloor[] = $row;
        }
        $dataRoom = array();
        while ($row = $rsRoom->fetch_assoc()) {
            $dataRoom[] = $row;
        }
        return [
            "status" => "success",
            "data" => $rowLocation,
            "building" => $dataBuilding,
            "floor" => $dataFloor,
            "room" => $dataRoom
        ];
    }
}
