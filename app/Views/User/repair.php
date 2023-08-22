<div class="container-fluid px-4">
    <?php if ($_SESSION['quyen'] == 1) { ?>
        <h1 class="mt-4">Danh sách yêu cầu sửa chữa đã nhận</h1>
    <?php } else { ?>
        <h1 class="mt-4">Danh sách yêu cầu sửa chữa đã gửi của bạn</h1>
    <?php } ?>
    <div class="card mb-4">

        <div class="card-header">
            <?php if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 1) { ?>
                    <div class="alert alert-success">
                        <strong>Thành công</strong>
                    </div>
                <?php }  ?>
            <?php }  ?>
            <?php if ($_SESSION['quyen'] == 2) { ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                    Thêm mới
                </button>
            <?php } ?>
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Ngày gửi</th>
                        <th>Thiết bị</th>
                        <th>Nội dung</th>
                        <?php if ($_SESSION['quyen'] == 1) { ?>
                            <th>Chi phí</th>
                            <th>Thời gian</th>
                            <th>Người gửi</th>
                        <?php } ?>
                        <th>Tình trạng</th>
                        <?php if ($_SESSION['quyen'] == 1) { ?>
                            <th>Thao tác</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["repairContent"] as $arUser) {
                        $idModelDes = "exampleModalDes" . $arUser["id"];
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaygui"])) ?></td>
                            <td><?php echo $arUser["tentb"] ?></td>
                            <td>
                                <a href="" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDes ?>">
                                    Xem</a>
                            </td>
                            <?php if ($_SESSION['quyen'] == 1) { ?>
                                <td><?php echo $arUser["chiphi"] ?></td>
                                <td><?php echo $arUser["thoigian"] ?></td>
                                <td><?php echo $arUser["hoten"] ?></td>
                            <?php } ?>
                            <td><?php echo $arUser["tinhtrang"] ?></td>
                            <!--Des-->
                            <div class="modal fade" id="<?php echo $idModelDes ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Nội dung</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $arUser["noidung"] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['quyen'] == 1) { ?>
                                <td style="width : 130px !important">
                                    <?php if ($arUser["tinhtrang"] == "Chờ xử lý") { ?>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                            Đã xử lý
                                        </button>
                                    <?php } ?>
                                    <!-- Modal Update-->
                                    <div class="modal fade" id="<?php echo $idModelEdit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận đã xử lý</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" enctype="multipart/form-data" class="editRepair">
                                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="category-film" class="col-form-label">Chi phí:</label>
                                                                    <input type="text" class="form-control" id="category-film" name="chiphi" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="category-film" class="col-form-label">Thời gian:</label>
                                                                    <input type="text" class="form-control" id="category-film" name="thoigian" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary" name="xnsc">Xác nhận</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Update-->
                                </td>
                            <?php } ?>
                        </tr>
                    <?php $stt++;
                    } ?>
                    <!-- Modal Add-->
                    <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Yêu cầu sửa chữa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" id="addRepair">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="category-film" class="col-form-label">Thiết bị :</label>
                                                    <select class="form-select" aria-label="Default select example" id="theloai" tabindex="8" name="thietbi" required>
                                                        <option value="" selected>Chọn thiết bị</option>
                                                        <?php
                                                        foreach ($data["dataDeviceType"] as $arLsp) {
                                                        ?>
                                                            <option value="<?php echo $arLsp['id'] ?>"><?php echo $arLsp['ten'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="category-film" class="col-form-label">Nội dung:</label>
                                                    <textarea name="noidung" class="form-control" cols="30" tabindex="8" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary" name="ycsc">Gửi</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };


        $('#addRepair').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/sendRepair", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addRepair').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAdd');
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
        $('.editRepair').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/confirmRepair", // Đường dẫn đến controller xử lý
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