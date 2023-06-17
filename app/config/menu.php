<?php
require_once './app/config/constant.php';
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                if ($_SESSION['quyen'] == 1) {
                ?>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Thống kê dữ liệu
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/userlist">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý tài khoản
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/devicetype">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý loại thiết bị
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/devicelist">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý thiết bị
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/borrowdevice">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý mượn trả
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/notification">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý thông báo
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/repair">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý sửa chữa
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/incident">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý sự cố
                    </a>
                <?php
                } else {
                ?>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/finddevice">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Tra cứu thiết bị
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/borrowhistory">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Lịch sử mượn trả
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/incident">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Thông báo sự cố
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/repair">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Gửi yêu cầu sửa chữa
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
</div>