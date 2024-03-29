<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Yêu cầu đang chờ phê duyệt : <strong> <?php echo $data["dataDashboard"]["sum_approve_device"]; ?></strong> </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Số thiết bị đang mượn : <strong> <?php echo $data["dataDashboard"]["sum_device"]; ?></strong> </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Tổng số sửa chữa : <strong> <?php echo $data["dataDashboard"]["sum_fix_device"]; ?></strong> </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">Tổng số thiết bị : <strong> <?php echo $data["dataDashboard"]["sum_device"]; ?></strong> </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <canvas id="myChart"></canvas>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    // Cấu hình biểu đồ
    var options = {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    };
    // JavaScript code
    getDeviceBorrowCount()

    // var cDate = new Date();
    // var currentDate = cDate.toISOString().slice(0, 10);
    // // var formattedDate = currentDate.toString().slice(0, 10);
    // cDate.setMonth(cDate.getMonth() - 1);
    // var oneMonthAgo = cDate.toISOString().slice(0, 10);
    // console.log(currentDate, cDate.toISOString().slice(0, 10), oneMonthAgo);
    // getDeviceBorrowCount()

    function getDeviceBorrowCount() {
        var cDate = new Date();
        var currentDate = cDate.toISOString().slice(0, 10);
        // var formattedDate = currentDate.toString().slice(0, 10);
        cDate.setMonth(cDate.getMonth() - 1);
        var oneMonthAgo = cDate.toISOString().slice(0, 10);
        $.ajax({
            url: '<?php echo BASE_URL; ?>/dashboard/getDeviceBorrowCountByDate', // Thay thế bằng URL của phương thức trong controller của bạn
            method: 'GET',
            data: {
                startDate: currentDate,
                endDate: oneMonthAgo
            },
            dataType: 'json',
            success: function(data) {
                // Xử lý dữ liệu trả về từ controller ở đây
                console.log(data);
            },
            error: function() {
                // Xử lý lỗi nếu có
                console.error('Lỗi trong quá trình truy vấn dữ liệu');
            }
        });
    }

    // Dữ liệu biểu đồ
    var data = {
        labels: [
            <?php foreach ($data['data'] as $row) : ?> '<?php echo $row['ngaymuon']; ?>',
            <?php endforeach; ?>
        ],
        datasets: [{
            label: 'Số lượng thiết bị đã mượn',
            data: [
                <?php foreach ($data['data'] as $row) : ?>
                    <?php echo $row['total']; ?>,
                <?php endforeach; ?>
            ],
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1
        }]
    };



    // Khởi tạo và vẽ biểu đồ
    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
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
    } -->