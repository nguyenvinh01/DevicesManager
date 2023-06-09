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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("./app/config/head.php") ?>
    <!-- <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>HỆ THỐNG</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="./public/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="./public/bootstrap.min.js"></script>
    <script src="./ckeditor/ckeditor.js"></script> -->
</head>

<body class="sb-nav-fixed">
    <?php include("./app/config/header.php"); ?>
    <div id="layoutSidenav">
        <?php include('./app/config/menu.php') ?>
        <div id="layoutSidenav_content">
            <main>
                <?php require_once "./app/Views/" . $data["page"] . ".php" ?>
            </main>
        </div>

    </div>
    <?php include('./app/config/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./public/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="./assets/demo/chart-area-demo.js"></script>
    <script src="./assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="./public/js/datatables-simple-demo.js"></script>
</body>

</html>