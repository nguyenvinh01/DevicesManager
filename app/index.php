<?php
// session_start();
if (empty($_SESSION['taikhoanadmin'])) {
    header("Location: login");
    exit();
}
if (!isset($_GET["url"])) {
    header("Location: dashboard");
    exit();
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
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="sb-nav-fixed">

    <?php include("./app/config/header.php"); ?>
    <div id="layoutSidenav">
        <?php include('./app/config/menu.php') ?>
        <div id="layoutSidenav_content">
            <main>
                <?php include("./app/config/library.php"); ?>
                <?php require_once "./app/Views/" . $data["page"] . ".php" ?>
            </main>
        </div>
    </div>
    <div id="toast-container" style="z-index: 99999; top: 10px; right: 0px; "></div>

    <?php include('./app/config/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/3.2.1/jquery.serializejson.min.js" integrity="sha512-SdWDXwOhhVS/wWMRlwz3wZu3O5e4lm2/vKK3oD0E5slvGFg/swCYyZmts7+6si8WeJYIUsTrT3KZWWCknSopjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/3.2.1/jquery.serializejson.js" integrity="sha512-sQKI/4Pk8sWk7RP6xI2uDkXpIHyuaJgFX8/IGKzVj+6Wt06IcQU5s7nF6A3f0iOZpSXhlOPPNDDYKcaBlSYLNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo BASE_URL; ?>/assets/demo/chart-area-demo.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/demo/chart-bar-demo.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/js/datatables-simple-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.js" integrity="sha512-UNbeFrHORGTzMn3HTt00fvdojBYHLPxJbLChmtoyDwB6P9hX5mah3kMKm0HHNx/EvSPJt14b+SlD8xhuZ4w9Lg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        let table = new DataTable('#datatablesSimple', {
            searching: false,
            bPaginate: false,
            info: false
        });
        $(document).ready(function() {

            var isLoggedIn = sessionStorage.getItem('isLoggedIn');
            console.log('login');
            if (isLoggedIn) {
                // Xóa trạng thái đăng nhập từ sessionStorage
                sessionStorage.removeItem('isLoggedIn');
                // Hiển thị thông báo thành công bằng Toastr
                toastr.success('Đăng nhập thành công');
            }
        });
    </script>
    <!-- <script>
        CKEDITOR.replace("editor");
    </script>
    <script>
        for (var i = 1; i < 200; i++) {
            var name = "editor" + i
            CKEDITOR.replace(name);

        }
    </script> -->
</body>

</html>