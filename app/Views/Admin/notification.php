<?php

if ($_SESSION['quyen'] != 1) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách thông báo</h1>
    <div class="card mb-4">
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
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["notificationContent"] as $arUser) {
                        $idModelDes = "exampleModalDes" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["tieude"] ?></td>
                            <td>
                                <a href="" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDes ?>">
                                    Xem</a>
                            </td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaytao"])) ?></td>

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
                                    <form method="POST" enctype="multipart/form-data" id="addNotification">
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
                                            <button type="submit" class="btn btn-primary" name="addtb">Lưu</button>
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
    $(document).ready(() => {
        $('#addNotification').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/notification/sendNotification", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAdd');
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        toastr.error(response.message);

                    }
                },
                error: function(xhr, status, error) {
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