<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử mượn trả của bạn</h1>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên thiết bị</th>
                        <th>Ảnh</th>
                        <th>Địa điểm</th>
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getBorrowHistoryList()

        function getBorrowHistoryList() {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowhistory/getBorrowHistoryList", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // if (response.status == "success") {
                    console.log(response.data[0], 444);
                    let userTable = '';
                    table.clear();

                    response.data.forEach((e, index) => {
                        console.log(e, 12321);
                        table.row.add([
                            index + 1,
                            e.ten,
                            function() {
                                return (`
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}"></td>
                                    `)
                            },
                            e.diadiem,
                            e.ngaymuon,
                            e.ngaytra,
                            e.trangthai,
                        ])
                    });
                    table.draw();
                    // } else {}
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    })
</script>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }