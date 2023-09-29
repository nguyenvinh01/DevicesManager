<?php

require_once "./app/Models/Model.php";
class DepartmentModel extends Model
{
    // function getDeviceType()
    // {
    //     $query = "SELECT * FROM loaithietbi Order by id desc";
    //     $rs = $this->conn->query($query);
    //     $data = array();
    //     while ($row = $rs->fetch_assoc()) {
    //         $data[] = $row;
    //     }
    //     return [
    //         'status' => 'success',
    //         'data' => $data,
    //         // 'count' => count($rsCount->fetch_all())
    //     ];
    // }
    // public function getDataModal($id)
    // {
    //     $query = "SELECT * FROM loaithietbi WHERE id = $id;";
    //     $rs = $this->conn->query($query);

    //     return $rs->fetch_assoc();
    // }
    // public function getDataCateModal($id)
    // {
    //     $query = "SELECT * FROM danhmuc WHERE id = $id;";
    //     $rs = $this->conn->query($query);

    //     return $rs->fetch_assoc();
    // }
    // function getDeviceCategories()
    // {
    //     // $query = "SELECT * FROM loaithietbi Order by id desc";
    //     $query = "SELECT dm.*, COUNT(tb.madanhmuc) AS so_luong
    //     FROM danhmuc dm
    //     LEFT JOIN thietbi tb ON dm.madanhmuc = tb.madanhmuc
    //     GROUP BY dm.madanhmuc;";
    //     $rs = $this->conn->query($query);
    //     $data = array();
    //     while ($row = $rs->fetch_assoc()) {
    //         $data[] = $row;
    //     }
    //     return [
    //         'status' => 'success',
    //         'data' => $data,
    //     ];
    // }
    // function addDeviceType($ten, $cate)
    // {
    //     $queryLastId = "SELECT COUNT(tb.madanhmuc) AS count
    //     FROM danhmuc AS dm
    //     JOIN loaithietbi AS ltb ON dm.madanhmuc = ltb.madanhmuc
    //     JOIN thietbi AS tb ON ltb.madanhmuc = tb.madanhmuc
    //     WHERE dm.madanhmuc = '$cate';";
    //     $rsLastId = $this->conn->query($queryLastId);
    //     $lastId = $rsLastId->fetch_assoc();
    //     $ma_loai_thiet_bi = $cate . str_pad($lastId['count'] + 1, 2, "0", STR_PAD_LEFT);
    //     $query = "INSERT INTO loaithietbi (ten, maloai, madanhmuc) 
    //     VALUES ( '{$ten}', '{$ma_loai_thiet_bi}', '{$cate}') ";
    //     $result = $this->conn->query($query);
    //     if ($result) {
    //         // header("Location: ../devicetype?msg=1");
    //         return [
    //             "status" => "success",
    //             "message" => "Tạo thành công"
    //         ];
    //     } else {
    //         // header("Location: ../devicetype?msg=2");
    //         return [
    //             "status" => "error",
    //             "message" => "Tạo thất bại có lỗi xảy ra"
    //         ];
    //     }
    // }
    // function addDeviceCate($ten, $cate)
    // {
    //     // $queryLastId = "SELECT COUNT(tb.madanhmuc) AS count
    //     // FROM danhmuc AS dm
    //     // JOIN loaithietbi AS ltb ON dm.madanhmuc = ltb.madanhmuc
    //     // JOIN thietbi AS tb ON ltb.madanhmuc = tb.madanhmuc
    //     // WHERE dm.madanhmuc = '$cate';";
    //     // $rsLastId = $this->conn->query($queryLastId);
    //     // $lastId = $rsLastId->fetch_assoc();
    //     // $ma_loai_thiet_bi = $cate . str_pad($lastId['count'] + 1, 2, "0", STR_PAD_LEFT);
    //     $queryCheckName = "SELECT * FROM danhmuc WHERE tendanhmuc = '$ten'";
    //     $rsCheckName = $this->conn->query($queryCheckName);
    //     if ($rsCheckName->fetch_assoc()) {
    //         return [
    //             "status" => "error",
    //             "message" => "Tên danh mục đã tồn tại"
    //         ];
    //     }
    //     $queryCheckCode = "SELECT * FROM danhmuc WHERE madanhmuc = '$cate'";
    //     $rsCheckCode = $this->conn->query($queryCheckCode);
    //     if ($rsCheckCode->fetch_assoc()) {
    //         return [
    //             "status" => "error",
    //             "message" => "Mã danh mục đã tồn tại"
    //         ];
    //     }
    //     $query = "INSERT INTO danhmuc (tendanhmuc, madanhmuc) 
    //     VALUES ( '{$ten}', '{$cate}') ";
    //     $result = $this->conn->query($query);
    //     if ($result) {
    //         // header("Location: ../devicetype?msg=1");
    //         return [
    //             "status" => "success",
    //             "message" => "Tạo thành công"
    //         ];
    //     } else {
    //         // header("Location: ../devicetype?msg=2");
    //         return [
    //             "status" => "error",
    //             "message" => "Tạo thất bại có lỗi xảy ra"
    //         ];
    //     }
    // }
    // function editDeviceType($ten, $id)
    // {

    //     $query = "UPDATE `loaithietbi` 
    //     SET `ten`='{$ten}'
    //     WHERE `id`='{$id}'";
    //     $result = $this->conn->query($query);
    //     if ($result) {
    //         return [
    //             "status" => "success",
    //             "message" => "Sửa thành công"
    //         ];
    //     } else {
    //         return [
    //             "status" => "error",
    //             "message" => "Sửa thất bại có lỗi xảy ra"
    //         ];
    //     }
    // }
    // function deleteDeviceType($id)
    // {
    //     $check = "SELECT * FROM thietbi WHERE loaithietbi_id = '{$id}'";
    //     $result = $this->conn->query($check);
    //     $row = mysqli_num_rows($result);
    //     if ($row > 0) {
    //         // header("Location: ../devicetype?msg=2");
    //         return [
    //             "status" => "error",
    //             "message" => "Xóa thất bại có lỗi xảy ra"
    //         ];
    //     } else {
    //         $query = "DELETE FROM loaithietbi WHERE `id`='{$id}'";
    //         $this->conn->query($query);
    //         // header("Location: ../devicetype?msg=1");
    //         return [
    //             "status" => "success",
    //             "message" => "Xóa thành công"
    //         ];
    //     }
    // }
    function editDeviceCate($ten, $madanhmuc, $id)
    {
        $queryCheckName = "SELECT * FROM danhmuc WHERE tendanhmuc = '$ten' AND `id` != '$id'";
        $rsCheckName = $this->conn->query($queryCheckName);
        if (mysqli_num_rows($rsCheckName) >= 1) {
            return [
                "status" => "error",
                "message" => "Tên danh mục đã tồn tại"
            ];
        }
        $queryCheckCode = "SELECT * FROM danhmuc WHERE madanhmuc = '$madanhmuc' AND `id` != '$id'";
        $rsCheckCode = $this->conn->query($queryCheckCode);
        if (mysqli_num_rows($rsCheckCode) >= 1) {
            return [
                "status" => "error",
                "message" => "Mã danh mục đã tồn tại"
            ];
        }
        $query = "UPDATE `danhmuc` 
        SET `tendanhmuc`='{$ten}', `madanhmuc` = '{$madanhmuc}'
        WHERE `id`='{$id}'";
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
    function deleteDepartment($id)
    {
        // $check = "SELECT * FROM thietbi WHERE madanhmuc = '{$id}'";
        // $result = $this->conn->query($check);
        // $row = mysqli_num_rows($result);
        // if ($row > 0) {
        //     // header("Location: ../devicetype?msg=2");
        //     return [
        //         "status" => "error",
        //         "message" => "Xóa thất bại có lỗi xảy ra"
        //     ];
        // } else {
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
            "data" => "Tạo thành công",
            "" => $queryGetLocation
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
}
