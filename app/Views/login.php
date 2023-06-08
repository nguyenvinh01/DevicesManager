<?php
if (isset($_SESSION['taikhoanadmin'])) {
    header("Location: dashboard");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./app/config/head.php" ?>
</head>
<?php
if (isset($_GET['fail'])) {
    echo "
                    <script>
                        function Redirect() {
                        window.location = 'login.php';
                        }
                        alert('Sai tài khoản hoặc mật khẩu !') 
                        Redirect()
                    </script>
                    ";
}
?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">HỆ THỐNG TÀI SẢN THIẾT BỊ</h3>
                                </div>
                                <div class="card-body">
                                    <form action="login/validLogin" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="" name="taikhoan" />
                                            <label for="inputEmail">Tài khoản</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="" name="matkhau" />
                                            <label for="inputPassword">Mật khẩu</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" name="login">Đăng nhập</button>
                                            <a href="register">Đăng ký tài khoản</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./public/js/scripts.js"></script>
</body>

</html>