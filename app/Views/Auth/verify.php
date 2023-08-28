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
        <!-- <div class="container">
            <div id="toast-container" style="right:17px !important;"></div>
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Xác minh tài khoản thành công</h3>
                        </div>
                        <div class="card-body">
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
        <div id="myModal" class="modal-open">
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

            // $('#login').submit(function(e) {
            //     e.preventDefault(); 
            // Gửi yêu cầu Ajax
            // console.log($('#login').serialize());
            console.log(1232);

            // $.ajax({
            //     url: "<?php echo BASE_URL; ?>/register/verify?token=123", // Đường dẫn đến controller xử lý
            //     method: 'GET',
            //     // data: $('#login').serialize(),
            //     // dataType: 'json',
            //     success: function(response) {
            //         console.log(response);
            //         // if (response.status == "success") {
            //         //     window.location.href = "<?php echo BASE_URL; ?>/dashboard";
            //         //     sessionStorage.setItem('isLoggedIn', 'true');
            //         //     toastr.success(response.message);
            //         // } else {
            //         //     toastr.error(response.message);

            //         // }
            //     },
            //     error: function(xhr, status, error) {
            //         // Xử lý lỗi khi gửi yêu cầu Ajax
            //         console.error(error);
            //     }
            // });
        });
        // })
    </script>
</body>

</html>