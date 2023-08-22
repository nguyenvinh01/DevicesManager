<div class="container-fluid px-4">
    <?php if ($_SESSION['quyen'] == 1) { ?>
        <h1 class="mt-4">Danh sách sự cố đã nhận</h1>
    <?php } else { ?>
        <h1 class="mt-4">Danh sách sự cố đã gửi của bạn</h1>
    <?php } ?>
    <div class="card mb-4">
        <?php if ($_SESSION['quyen'] == 2) { ?>
            <div class="card-header">
                <?php if (isset($_GET['msg'])) {
                    if ($_GET['msg'] == 1) { ?>
                        <div class="alert alert-success">
                            <strong>Thành công</strong>
                        </div>
                    <?php }  ?>
                <?php }  ?>

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                    Thêm mới
                </button>

            </div>
        <?php } ?>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <?php if ($_SESSION['quyen'] == 1) { ?>
                            <th>Người gửi</th>
                        <?php } ?>
                        <th>Ngày gửi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["incidentContent"] as $arUser) {
                        $idModelDes = "exampleModalDes" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["tieude"] ?></td>
                            <td>
                                <a href="" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDes ?>">
                                    Xem</a>
                            </td>
                            <?php if ($_SESSION['quyen'] == 1) { ?>
                                <td><?php echo $arUser["hoten"] ?></td>
                            <?php } ?>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaygui"])) ?></td>
                            <!--Des-->
                            <div class="modal fade" id="<?php echo $idModelDes ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $arUser["tieude"] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $arUser["noidung"] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php $stt++;
                    } ?>
                    <!-- Modal Add-->
                    <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" id="addIncident">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="category-film" class="col-form-label">Tiêu đề :</label>
                                                    <input type="text" class="form-control" id="category-film" name="tieude" required>
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
                                            <button type="submit" class="btn btn-primary" name="addsc">Lưu</button>
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

        $('#addIncident').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            $.ajax({
                url: "<?php echo BASE_URL; ?>/incident/sendIncident", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addIncident').serialize(),
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