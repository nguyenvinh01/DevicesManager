<div class="container-fluid px-4">

    <h2>Chào mừng bạn đến với Website Quản lí tài sản thiết bị nhà trường</h2>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');

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

    // Khởi tạo và vẽ biểu đồ
    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
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