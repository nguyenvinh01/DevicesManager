<?php

require_once './app/config/constant.php';

?>


<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="<?php echo BASE_URL; ?>/dashboard">HỆ THỐNG</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <p style="color:white;margin-top:15px">Website quản lý tài sản, thiết bị tại trường đại học</p>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle no-caret" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    99+
                </span>
                <i class="bi bi-info-circle"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">Thông tin</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/logout">Đăng xuất</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Xin chào, <?php echo $_SESSION['tenhienthi'] ?><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">Thông tin</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/logout">Đăng xuất</a></li>
            </ul>
        </li>
    </ul>
</nav>