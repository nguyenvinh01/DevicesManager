<?php
require_once './app/config/constant.php';
?>

<head>
    <style>
        .container-scroll {
            /* width: 300px; */
            height: 200px !important;
            overflow: hidden !important;
        }

        .scroll-content {
            width: 100%;
            height: 100%;
            overflow: auto !important;
            padding-right: 17px !important;
        }

        /* Custom scrollbar style */
        ::-webkit-scrollbar {
            width: 10px;
            /* Độ rộng của custom scrollbar */
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
            /* Màu nền của scrollbar */
            border-radius: 10px;
            /* Bo góc của scrollbar */
        }

        ::-webkit-scrollbar-thumb:hover {
            /* background-color: #555; */
            /* Màu nền của scrollbar khi hover */
        }
    </style>
</head>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                if ($_SESSION['quyen'] == 1) {
                ?>
                    <!-- <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Thống kê dữ liệu
                    </a> -->
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/userlist">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý tài khoản
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/devicetype">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý loại thiết bị
                    </a>
                    <div class="accordion scroll-menu" id="sidebarAccordion">
                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#devicetypeCollapse">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Quản lý thiết bị
                        </a>
                        <div>
                            <ul class="nav scroll-content container-scroll" id="device-type-item">
                            </ul>
                        </div>
                    </div>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/borrowdevice">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý mượn trả
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/notification">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý thông báo
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/assign">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý phân quyền sử dụng
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/repair">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý sửa chữa
                    </a>

                    <!-- <a class="nav-link" href="<?php echo BASE_URL; ?>/incident">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý sự cố
                    </a> -->
                <?php
                } else if ($_SESSION['quyen'] == 2) {
                ?>
                    <!-- <a class="nav-link" href="<?php echo BASE_URL; ?>/finddevice">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Tra cứu thiết bị
                    </a> -->
                    <div class="accordion" id="sidebarAccordion">
                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#devicetypeCollapse">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tra cứu thiết bị
                        </a>
                        <div>
                            <ul class="nav" id="device-type-item">
                            </ul>
                        </div>
                    </div>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/borrowhistory">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Lịch sử mượn trả
                    </a>
                    <!-- <a class="nav-link" href="<?php echo BASE_URL; ?>/incident">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Thông báo sự cố
                    </a> -->
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/repair">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Gửi yêu cầu sửa chữa
                    </a>
                <?php
                } else {
                ?>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/repair">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Quản lý sửa chữa
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/assign">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Kiểm tra định kỳ
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <script>
        $(document).ready(() => {
            <?php
            if ($_SESSION['quyen'] != 3) {
            ?>
                const controller = <?php echo $_SESSION['quyen'] ?> == 1 ? 'devicelist' : 'finddevice'
                $.ajax({
                    url: `<?php echo BASE_URL; ?>/${controller}/getDeviceCategories`, // Đường dẫn đến controller xử lý
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        if (response.status == "success") {
                            $('#device-type-item').html('')
                            let typeList = '';
                            typeList += `
                                <li class="nav-item">
                                <a class="nav-link ms-4" href="<?php echo BASE_URL; ?>/${controller}">Tất cả (${response.all.soluong_all})</a>
                                </li>`
                            response.data.map((type) => {
                                typeList += `
                                <li class="nav-item">
                                <a class="nav-link ms-4" href="<?php echo BASE_URL; ?>/${controller}?cate=${type.madanhmuc}">${type.tendanhmuc} (${type.so_luong})</a>
                                </li>`

                            })
                            $('#device-type-item').html(typeList)
                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            <?php } ?>


        })
    </script>
</div>