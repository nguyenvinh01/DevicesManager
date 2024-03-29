<?php
require_once './app/config/constant.php';

if (isset($_SESSION['taikhoanadmin'])) {
    header("Location: dashboard");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>HỆ THỐNG QUẢN LÝ THIẾT BỊ</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/public/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>/ckeditor/ckeditor.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-primary sb-nav-fixed">
    <main>
        <div class="container">
            <div id="toast-container" style="right:17px !important;"></div>
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">HỆ THỐNG QUẢN LÝ THIẾT BỊ</h3>
                        </div>
                        <div class="card-body">

                            <form method="POST" id="login">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="text" placeholder="" name="taikhoan" />
                                    <label for="inputEmail">Tài khoản</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPassword" type="password" placeholder="" name="matkhau" />
                                    <label for="inputPassword">Mật khẩu</label>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <div class="d-flex align-items-center justify-content-between  flex-column">

                                        <button class="btn btn-primary" type="submit" name="login">Đăng nhập</button>
                                        <a href="<?php echo BASE_URL; ?>/forget" class="mt-1">Quên mật khẩu</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between  flex-column">
                                        <a href="<?php echo BASE_URL; ?>/register">Đăng ký tài khoản</a>
                                        <a href="<?php echo BASE_URL; ?>/verify">Xác minh tài khoản</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script src="<?php echo BASE_URL; ?>/assets/demo/chart-area-demo.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/demo/chart-bar-demo.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/js/datatables-simple-demo.js"></script>

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

            $('#login').submit(function(e) {
                e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
                // Gửi yêu cầu Ajax
                // console.log($('#login').serialize());
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/login/validLogin", // Đường dẫn đến controller xử lý
                    method: 'POST',
                    data: $('#login').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            window.location.href = "<?php echo BASE_URL; ?>/dashboard";
                            sessionStorage.setItem('isLoggedIn', 'true');
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);

                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.error(error);
                    }
                });
            });
            var isRegister = sessionStorage.getItem('register');

            if (isRegister) {
                toastr.success('Đăng ký thành công');
                sessionStorage.clear();
            }
        })
    </script>
</body>

</html>