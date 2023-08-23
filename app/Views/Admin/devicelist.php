<?php

if ($_SESSION['quyen'] != 1) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="flex-column col-6">
                <div class="input-group mb-3">
                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-4 mx-3">
                        <select id="filterSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                        </select>

                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                Thêm mới
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá trị</th>
                        <th>Đặc tính kĩ thuật</th>
                        <th>Loại thiết bị</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                    $stt = 1;
                    foreach ($data["dataDeviceList"] as $arUser) {
                        $idModelDel = "exampleModalDel" . $arUser["id"];
                        $idModelDes = "exampleModalDes" . $arUser["id"];
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["ten"] ?></td>
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/<?php echo $arUser['hinhanh'] ?>"></td>
                            <td><?php echo $arUser["soluong"] ?></td>
                            <td><?php echo $arUser["giatri"] ?></td>
                            <td>
                                <a href="" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDes ?>">
                                    Xem</a>
                            </td>
                            <td><?php echo $arUser["tenloai"] ?></td>
                            <td><?php echo $arUser["tinhtrang"] ?> </td>
                            <td style="width : 140px !important">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                    Sửa
                                </button>

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDel ?>">
                                    Xóa
                                </button>

                                <!--Des-->
                                <div class="modal fade" id="<?php echo $idModelDes ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $arUser["ten"] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <?php echo $arUser["dactinhkithuat"] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Dele-->
                                <div class="modal fade" id="<?php echo $idModelDel ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Thiết bị : <?php echo $arUser["ten"] ?>
                                                <form method="post" class="delDevice">
                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                                    <div class="modal-footer" style="margin-top: 20px">
                                                        <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Đóng
                                                        </button>
                                                        <button style="width:100px" type="submit" class="btn btn-danger" name="deletema"> Xóa</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Dele-->
                            </td>

                        </tr>
                        <!-- Modal Update-->
                        <div class="modal fade" id="<?php echo $idModelEdit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data" class="editDevice">
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                                        <select class="form-select" aria-label="Default select example" id="theloai" tabindex="8" name="ltb" required>
                                                            <?php
                                                            foreach ($data["dataDeviceType"] as $arLspud) {
                                                                if ($arLspud['id'] == $arUser["loaithietbi_id"]) {
                                                            ?>
                                                                    <option value="<?php echo $arLspud['id'] ?>" selected><?php echo $arLspud['ten'] ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $arLspud['id'] ?>"><?php echo $arLspud['ten'] ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                                        <input type="hidden" name="size" value="1000000">
                                                        <input type="file" class="form-control" name="image" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["ten"] ?>" name="ten" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["tinhtrang"] ?>" name="tinhtrang" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Số lượng:</label>
                                                        <input type="number" class="form-control" id="category-film" value="<?php echo $arUser["soluong"] ?>" name="soluong" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Giá trị:</label>
                                                        <input type="number" class="form-control" id="category-film" value="<?php echo $arUser["giatri"] ?>" name="giatri" required>
                                                    </div>
                                                </div>
                                                <?php
                                                $edit = "editor" . $stt;
                                                ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                                        <textarea name="dtkt" class="form-control" cols="30" tabindex="8" rows="10"><?php echo $arUser["dactinhkithuat"] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary" name="editma">Lưu</button>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
        </div>
        <!-- Modal Update-->
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
                    <form method="POST" enctype="multipart/form-data" id="addDevice">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                    <select class="form-select" aria-label="Default select example" id="theloai" tabindex="8" name="ltb" required>
                                        <option value="" selected>Chọn loại thiết bị</option>
                                        <?php
                                        foreach ($data["dataDeviceType"] as  $arLspud) {
                                        ?>
                                            <option value="<?php echo $arLspud['id'] ?>"><?php echo $arLspud['ten'] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Ảnh:</label>
                                    <input type="hidden" name="size" value="1000000">
                                    <input type="file" class="form-control" name="image" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                    <input type="text" class="form-control" id="category-film" name="ten" required>
                                </div>
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Tình trạng:</label>
                                    <input type="text" class="form-control" id="category-film" name="tinhtrang" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Số lượng:</label>
                                    <input type="number" class="form-control" id="category-film" name="soluong" required>
                                </div>
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Giá trị:</label>
                                    <input type="number" class="form-control" id="category-film" name="giatri" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                    <textarea name="dtkt" class="form-control" cols="30" tabindex="8" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addma">Lưu</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Update-->


    </tbody>
    </table>
    </div>
</div>
</div>

<script>
    $(document).ready(() => {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };

        $('#addDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/addDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, // Không xử lý dữ liệu FormData
                contentType: false, // Không đặt tiêu đề Content-Type
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

        $('.editDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = new FormData(this);
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/editDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                processData: false, // Không xử lý dữ liệu FormData
                contentType: false, // Không đặt tiêu đề Content-Type
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        console.log(12333);
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit`);
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

        $('.delDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            // var modalId = $(this).data('modal-id');
            // var id = $(this).find('input[name="id"]').val();
            console.log(1111, formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/deleteDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalDel${id}`);
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