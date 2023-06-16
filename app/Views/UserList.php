<?php

if ($_SESSION['quyen'] != 1) {
    header("Location: dashboard");
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách người dùng</h1>
    <div class="card mb-4">
        <div class="card-header">
            <?php if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 1) { ?>
                    <div class="alert alert-success">
                        <strong>Thành công</strong>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        <strong>Không thể xóa !</strong>
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
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Tài khoản</th>
                        <th>Mật khẩu</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // echo $listUser;
                    $stt = 1;
                    // echo $data["listUser"];
                    foreach ($data['listuser'] as $arUser) {
                        $idModelDel = "exampleModalDel" . $arUser["id"];
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["hoten"] ?></td>
                            <td><?php echo $arUser["email"] ?> </td>
                            <td><?php echo $arUser["sodienthoai"] ?></td>
                            <td><?php echo $arUser["diachi"] ?></td>
                            <td><?php echo $arUser["taikhoan"] ?></td>
                            <td><?php echo $arUser["matkhau"] ?> </td>
                            <td style="width : 130px !important">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                    Sửa
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDel ?>">
                                    Xóa
                                </button>

                                <!--Dele-->
                                <div class="modal fade" id="<?php echo $idModelDel ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Người dùng : <?php echo $arUser["hoten"] ?>
                                                <form method="post" class="delUser">
                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                                    <div class="modal-footer" style="margin-top: 20px">
                                                        <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Đóng
                                                        </button>
                                                        <button style="width:100px" type="submit" class="btn btn-danger" name="deletenv"> Xóa</button>
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
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data" class="editUser">
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Họ tên:</label>
                                                        <input type="text" class="form-control" value="<?php echo $arUser["hoten"] ?>" id="category-film" name="hoten" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Email:</label>
                                                        <input type="text" class="form-control" value="<?php echo $arUser["email"] ?>" id="category-film" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Tài khoản:</label>
                                                        <input type="text" class="form-control" id="category-film" name="taikhoan" value="<?php echo $arUser["taikhoan"] ?>" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Mật khẩu:</label>
                                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["matkhau"] ?>" name="matkhau" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Số điện thoại:</label>
                                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["sodienthoai"] ?>" name="sdt" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Địa chỉ:</label>
                                                        <input type="text" class="form-control" id="category-film" name="diachi" value="<?php echo $arUser["diachi"] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary" name="editnv">Lưu</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Update-->
                    <?php $stt = $stt + 1;
                    } ?>
                    <!-- Modal Add-->
                    <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" id="addUser">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Họ tên:</label>
                                                    <input type="text" class="form-control" id="addUserName" name="hoten" required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Email:</label>
                                                    <input type="email" class="form-control" id="addUserEmail" name="email" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Tài khoản:</label>
                                                    <input type="text" class="form-control" id="addUserAcc" name="taikhoan" required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Mật khẩu:</label>
                                                    <input type="text" class="form-control" id="addUserPass" name="matkhau" pattern=".{6,}" title="Mật khẩu phải có ít nhất 6 ký tự" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Số điện thoại:</label>
                                                    <input type="text" class="form-control" id="addUserSdt" name="sdt" required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Địa chỉ:</label>
                                                    <input type="text" class="form-control" id="addUserAddress" name="diachi" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary" name="addnv">Lưu</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Modal Add-->
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
        $('.editUser').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "http://localhost/quanlithietbi/userlist/editUser", // Đường dẫn đến controller xử lý
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

        $('#addUser').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            $.ajax({
                url: "http://localhost/quanlithietbi/userlist/addUser", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addUser').serialize(),
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

        $('.delUser').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            // var modalId = $(this).data('modal-id');
            // var id = $(this).find('input[name="id"]').val();
            console.log(1111, formData);
            $.ajax({
                url: "http://localhost/quanlithietbi/userlist/deleteUser", // Đường dẫn đến controller xử lý
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
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }