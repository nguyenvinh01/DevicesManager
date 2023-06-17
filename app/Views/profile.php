<div class="container-fluid px-4">
    <h1 class="mt-4">Thông tin tài khoản</h1>
    <!-- <div class="card mb-4"> -->
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="updateUser">
            <!-- Username field -->
            <div class="mb-3 gx-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputUsername">Tài khoản</label>
                    <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="<?php echo $data['dataProfile']['taikhoan'] ?>" name="taikhoan">
                </div>
            </div>
            <!-- Full name field -->
            <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputFullName">Họ và tên</label>
                    <input class="form-control" id="inputFullName" type="text" placeholder="Enter your full name" value="<?php echo $data['dataProfile']['hoten'] ?>" name="hoten">
                </div>
            </div>
            <!-- Location field -->
            <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputLocation">Địa chỉ</label>
                    <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="<?php echo $data['dataProfile']['diachi'] ?>" name="diachi">
                </div>
            </div>
            <!-- Email field -->
            <div class="mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                    <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="<?php echo $data['dataProfile']['email'] ?>" name="email">
                </div>
            </div>
            <!-- Phone number field -->
            <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1" for="inputPhone">Số điện thoại</label></label>
                    <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="<?php echo $data['dataProfile']['sodienthoai'] ?>" name="sodienthoai">
                </div>
            </div>
            <!-- Update button -->
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Cập nhật</button>
            <a class="btn btn-primary" type="button" href="<?php echo BASE_URL; ?>/profile/password">Đổi mật khẩu</a>
        </form>

        <!-- Modal update -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận cập nhật</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Xác nhận cập nhật thông tin
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="btn-submit">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
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

        $('#btn-submit').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo BASE_URL; ?>/profile/updateUser",
                method: 'POST',
                data: $('#updateUser').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log('qqqq');

                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModal');
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
    });
</script>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }