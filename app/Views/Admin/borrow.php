<?php
if ($_SESSION['quyen'] == 2) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử mượn trả</h1>
    <div class="card mb-4">
        <div class="card-header">
            <?php if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 1) { ?>
                    <div class="alert alert-success">
                        <strong>Thành công</strong>
                    </div>
                <?php }  ?>
            <?php }  ?>

        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Người dùng</th>
                        <th>Tên thiết bị</th>
                        <th>Ảnh</th>
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Địa điểm</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["dataBorrowDeviceList"] as $arUser) {
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["hoten"] ?></td>
                            <td><?php echo $arUser["ten"] ?></td>
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/<?php echo $arUser['hinhanh'] ?>"></td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaymuon"])) ?></td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaytra"])) ?></td>
                            <td><?php echo $arUser["diadiem"] ?> </td>
                            <td><?php echo $arUser["trangthai"] ?> </td>
                            <td>
                                <?php if ($arUser["trangthai"] != "Đã trả" && $arUser["trangthai"] != "Bị từ chối") { ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                        Cập nhật
                                    </button>
                                <?php } ?>
                            </td>
                            <div class="modal fade" id="<?php echo $idModelEdit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cập nhật tình trạng yêu cầu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" enctype="multipart/form-data" class="updateStatus">
                                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                                <input type="hidden" class="form-control" id="id" name="thietbiid" value="<?php echo $arUser["thietbi_id"] ?>">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="category-film" class="col-form-label">Tình trạng:</label>
                                                            <select class="form-select" aria-label="Default select example" id="theloai" tabindex="8" name="tinhtrang" required>
                                                                <option value="" selected>Chọn tình trạng</option>
                                                                <?php if ($arUser["trangthai"] == "Chờ phê duyệt") { ?>
                                                                    <option value="Đã phê duyệt">Phê duyệt yêu cầu</option>
                                                                    <option value="Bị từ chối">Từ chối yêu cầu</option>
                                                                <?php } ?>
                                                                <?php if ($arUser["trangthai"] == "Đã phê duyệt") { ?>
                                                                    <option value="Đang mượn">Đang mượn</option>
                                                                <?php } ?>
                                                                <?php if ($arUser["trangthai"] == "Đang mượn") { ?>
                                                                    <option value="Đã trả">Đã trả</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="capnhat">Cập nhật</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php $stt++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        $('.updateStatus').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            // var formData = $(this).serializeJSON();
            // var formData = new FormData(this);

            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/updateBorrowStatus", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        });
    })
</script>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }