<div class="container-fluid px-4">
    <?php if ($_SESSION['quyen'] == 1) { ?>
        <div class="row mt-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Yêu cầu đang chờ phê duyệt : <strong> <?php echo $pheduyet['tongso'] ?></strong> </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small text-white"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Số thiết bị đang mượn : <strong> <?php echo $chomuon['tongso'] ?></strong> </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small text-white"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Tổng số sửa chữa : <strong> <?php echo $artinhkh['tongso'] ?></strong> </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small text-white"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">Tổng số thiết bị : <strong> <?php echo $artinhnk['tongso'] ?></strong> </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small text-white"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h2>Chào mừng bạn đến với Website tài sản thiết bị nhà trường</h2>
    <?php } ?>
</div>