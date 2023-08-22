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
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data["borrowHistoryList"] as $arUser) {
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["ten"] ?></td>
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/<?php echo $arUser['hinhanh'] ?>"></td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaymuon"])) ?></td>
                            <td><?php echo date("d-m-Y", strtotime($arUser["ngaytra"])) ?></td>
                            <td><?php echo $arUser["trangthai"] ?> </td>
                        </tr>
                    <?php $stt++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }