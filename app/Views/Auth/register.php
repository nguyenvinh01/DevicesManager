<?php
if (isset($_SESSION['taikhoanadmin'])) {
    // header("Location: dashboard");
}
require_once './app/config/constant.php';

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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/public/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>/ckeditor/ckeditor.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Đăng Ký</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="register">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="" name="hoten" required />
                                            <label for="inputEmail">Họ tên</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" placeholder="" name="email" required />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="" name="sodienthoai" required />
                                            <label for="inputEmail">Số điện thoại</label>
                                        </div>
                                        <div class="mb-3">
                                            <select class="form-select" aria-label="Default select example" id="department" tabindex="8" name="phongban" required>
                                                <option value="" selected>Chọn phòng ban</option>
                                            </select>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="" name="diachi" required />
                                            <label for="inputEmail">Địa chỉ</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" placeholder="" name="taikhoan" required />
                                            <label for="inputEmail">Tài khoản</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <!-- <input class="form-control" id="inputPassword" type="password" placeholder="" name="matkhau" required /> -->
                                            <input type="password" class="form-control needs-validation" id="validationPassword" minlength="8" name="matkhau" placeholder="Mật khẩu" value="" required>
                                            <div class="progress" style="height: 5px;">
                                                <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                Mật khẩu của bạn phải có độ dài từ 8-20 ký tự, phải chứa các ký tự đặc biệt như "!@#$%&*_?", số, chữ thường và chữ hoa.
                                            </small>
                                            <div id="feedbackin" class="valid-feedback">
                                                Mật khẩu phù hợp!
                                            </div>
                                            <!-- <div id="feedbackin" class="valid-feedback">

                                            </div> -->
                                            <div id="feedbackirn" class="invalid-feedback">
                                                <tag id="strengthMessage"></tag>
                                                <tag id="lengthMessage"></tag>
                                                <tag id="specialCharMessage"></tag>
                                                <tag id="upperCaseMessage"></tag>
                                                <tag id="lowerCaseMessage"></tag>
                                                <tag id="numberMessage"></tag>
                                                <!-- <p>Atlead 8 characters</p>

                                                <p>Number, special character</p>
                                                <p>Caplital Letter and Small letters</p> -->
                                            </div>
                                            <label for="inputPassword">Mật khẩu</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" name="register">Đăng Ký</button>
                                            <a href="login">Đăng nhập tài khoản</button>
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
            let phongban;
            $('#register').submit(function(e) {
                e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
                // Gửi yêu cầu Ajax
                console.log($('#register').serialize());
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/register/registerUser", // Đường dẫn đến controller xử lý
                    method: 'POST',
                    data: $('#register').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            sessionStorage.setItem('register', 'true');
                            window.location.href = "<?php echo BASE_URL; ?>/login";
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $.ajax({
                url: "<?php echo BASE_URL; ?>/register/getDepartment", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response.data);
                    response.data.forEach((pb) => {
                        console.log(pb.tenpb);

                        phongban += `<option value="${pb.id}">${pb.tenpb}</option>`
                    })
                    $('#department').append(phongban);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        })
        window.addEventListener('load', function() {
            var form = document.getElementsByClassName('needs-validation');
            form.validationPassword.addEventListener('keypress', function(event) {

                var checkx = true;
                var chr = String.fromCharCode(event.which);

                var matchedCase = new Array();
                matchedCase.push("[!@#$%&*_?]");
                matchedCase.push("[A-Z]");
                matchedCase.push("[0-9]");
                matchedCase.push("[a-z]");

                for (var i = 0; i < matchedCase.length; i++) {
                    if (new RegExp(matchedCase[i]).test(chr)) {
                        checkx = false;
                    }
                }

                if (form.validationPassword.value.length >= 20)
                    checkx = true;

                if (checkx) {
                    event.preventDefault();
                    event.stopPropagation();
                }

            });

            var matchedCase = new Array();
            matchedCase.push("[$@$$!%*#?&]");
            matchedCase.push("[A-Z]");
            matchedCase.push("[0-9]");
            matchedCase.push("[a-z]");


            form.validationPassword.addEventListener('keyup', function() {

                var messageCase = new Array();
                messageCase.push(" Ký tự đặc biệt");
                messageCase.push(" Viết hoa");
                messageCase.push(" Số");
                messageCase.push(" Viết thường");

                var ctr = 0;
                var rti = "";
                for (var i = 0; i < matchedCase.length; i++) {
                    if (new RegExp(matchedCase[i]).test(form.validationPassword.value)) {
                        if (i == 0) messageCase.splice(messageCase.indexOf(" Ký tự đặc biệt"), 1);
                        if (i == 1) messageCase.splice(messageCase.indexOf(" Viết hoa"), 1);
                        if (i == 2) messageCase.splice(messageCase.indexOf(" Số"), 1);
                        if (i == 3) messageCase.splice(messageCase.indexOf(" Viết thường"), 1);
                        ctr++;
                    }
                }
                // $('#specialCharMessage').text(messageCase[0]);
                // $('#upperCaseMessage').text(messageCase[1]);
                // $('#numberMessage').text(messageCase[2]);
                // $('#lowerCaseMessage').text(messageCase[3]);
                var progressbar = 0;
                var strength = "";
                var bClass = "";
                switch (ctr) {
                    case 0:
                    case 1:
                        strength = "Mật khẩu yếu";
                        progressbar = 15;
                        bClass = "bg-danger";
                        break;
                    case 2:
                        strength = "Rất yếu";
                        progressbar = 25;
                        bClass = "bg-danger";
                        break;
                    case 3:
                        strength = "Yếu";
                        progressbar = 34;
                        bClass = "bg-warning";
                        break;
                    case 4:
                        strength = "Vừa";
                        progressbar = 65;
                        bClass = "bg-warning";
                        break;
                }

                if (strength == "Vừa" && form.validationPassword.value.length >= 8) {
                    strength = "Mạnh";
                    bClass = "bg-success";
                    form.validationPassword.setCustomValidity("");
                } else {
                    form.validationPassword.setCustomValidity(strength);
                }

                var sometext = "";

                if (form.validationPassword.value.length < 8) {
                    var lengthI = 8 - form.validationPassword.value.length;
                    sometext += ` thêm ${lengthI} ký tự, `;
                    // $('#lengthMessage').text(`Thêm ${lengthI} ký tự`)
                }

                sometext += messageCase;
                if (sometext) {
                    sometext = " cần" + sometext;
                }
                // console.log(messageCase, 'strength, some text', sometext);
                // $("#strengthMessage").text(strength); 
                $("#feedbackin, #feedbackirn").text(strength + sometext);
                $("#progressbar").removeClass("bg-danger bg-warning bg-success").addClass(bClass);
                var plength = form.validationPassword.value.length;
                if (plength > 0) progressbar += ((plength - 0) * 1.75);
                //console.log("plength: " + plength);
                var percentage = progressbar + "%";
                form.validationPassword.parentNode.classList.add('was-validated');
                //console.log("pacentage: " + percentage);
                $("#progressbar").width(percentage);

                if (form.validationPassword.checkValidity() === true) {
                    form.verifyPassword.disabled = false;
                } else {
                    form.verifyPassword.disabled = true;
                }
            });
        }, false);
    </script>
</body>

</html>