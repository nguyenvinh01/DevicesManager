<?php
require_once './app/config/constant.php';
// if (!isset($_GET['token'])) {
//     header("Location: ../login");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>HỆ THỐNG</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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

        <div id="myModalSuccess" class="modal">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <h4 class="modal-title w-100">Thành Công</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Bạn đã xác minh tài khoản thành công</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-block w-100" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModalError" class="modal">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box" style="background-color: red;">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <h4 class="modal-title w-100">Thất bại</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Tài khoản đã xác minh</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-block w-100" data-dismiss="modal" style="background-color: red;">OK</button> <!-- Nút OK màu đỏ -->
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

            // Lấy URL hiện tại
            var currentURL = window.location.href;

            // Trích xuất token từ URL (assumption: token là phần query parameter 'token')
            var tokenRegex = /token=([^&]+)/;
            var match = currentURL.match(tokenRegex);
            var receivedToken = match ? match[1] : null;
            console.log(receivedToken);
            if (receivedToken) {
                // Kiểm tra xem token có đúng định dạng hay không (ở đây ta giả sử token là chuỗi 32 ký tự)
                // var tokenPattern = /^[0-9a-f]{32}$/i;
                // var tokenPattern = /^[0-9a-f]{64}$/i;
                var tokenPattern = /^[0-9a-f]{64}$/i;
                if (tokenPattern.test(receivedToken)) {
                    // Gửi yêu cầu kiểm tra token qua AJAX
                    // toastr.success("valid token");

                    $.ajax({
                        url: "<?php echo BASE_URL; ?>/verify/VerifyToken", // Đường dẫn đến file PHP kiểm tra token
                        method: "GET",
                        data: {
                            token: receivedToken
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                console.log("Token is valid");
                                toastr.success(response.message);
                                $('#myModalSuccess').modal('show');
                                // Thực hiện các hành động sau khi xác minh token thành công
                            } else {
                                console.log("Invalid token");
                                toastr.error(response.message);
                                $('#myModalError').modal('show');
                                setTimeout(function() {
                                    window.location.href = "<?php echo BASE_URL; ?>/login";
                                }, 2000); // Thực hiện các hành động sau khi xác minh token thất bại
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr, status, error);
                            // Xử lý lỗi khi gửi yêu cầu AJAX
                        }
                    });
                } else {
                    console.log("Invalid token format");
                    toastr.error("Invalid token format");

                    // Xử lý khi token không đúng định dạng
                }
            } else {
                console.log("Token not found in URL");
                toastr.error("Token not found in URL");

                // Xử lý khi không tìm thấy token trong URL
            }
        });
        // })
    </script>
</body>

</html>