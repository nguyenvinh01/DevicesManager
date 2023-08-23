<?php
if ($_SESSION['quyen'] == 1) {
    header("Location: dashboard");
}

?>
<?php

foreach ($data['locationList'] as $location) {
    // echo $location['id'];
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tra cứu thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Loại thiết bị</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["deviceList"] as $arUser) {
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                        $idModelDe = "exampleModalDe" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["ten"] ?></td>
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/<?php echo $arUser['hinhanh'] ?>"></td>
                            <td><?php echo $arUser["tenloai"] ?></td>
                            <td><?php echo $arUser["tinhtrang"] ?> </td>
                            <td style="width : 140px !important">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDe ?>">
                                    Chi tiết
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                    Mượn thiết bị
                                </button>

                            </td>
                            <!-- Modal Detail-->
                            <div class="modal fade" id="<?php echo $idModelDe ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Chi tiết</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label"><strong>Loại thiết bị:</strong></label>
                                                        <br> <?php echo $arUser["tenloai"] ?><br>
                                                        <label for="category-film" class="col-form-label"><strong>Tên thiết bị:</strong></label>
                                                        <br> <?php echo $arUser["ten"] ?><br>
                                                        <label for="category-film" class="col-form-label"><strong>Tình trạng:</strong></label>
                                                        <br> <?php echo $arUser["tinhtrang"] ?><br>
                                                        <label for="category-film" class="col-form-label"><strong>Số lượng:</strong></label>
                                                        <br> <?php echo $arUser["soluong"] ?><br>
                                                        <label for="category-film" class="col-form-label"><strong>Giá trị:</strong></label>
                                                        <br> <?php echo $arUser["giatri"] ?><br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                                        <br>
                                                        <img style="width: 300px !important;height: 270px !important;" src="./uploads/image/<?php echo $arUser['hinhanh'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="category-film" class="col-form-label"><strong>Đặc tính kĩ thuật:</strong></label>
                                                        <br> <?php echo $arUser["dactinhkithuat"] ?><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
        </div>
        <!-- Modal Update-->
        </tr>
        <!-- Modal D-->
        <div class="modal fade" id="<?php echo $idModelEdit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mượn thiết bị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" class="borrowDevice">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Thiết bị:</label>
                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["ten"] ?>" name="ten" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Địa điểm:</label>
                                        <select id="option-building" class="form-select col" aria-label="Default select example" name="toanha">
                                            <?php foreach ($data['locationList'] as $location) { ?>
                                                <option value="<?php echo $location['toanha']; ?>"><?php echo $location['toanha']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="category-film" class="col-form-label">Phòng:</label>
                                        <select id="option-room" class="form-select col" aria-label="Default select example" name="phong">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Ngày mượn:</label>
                                        <input type="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" id="ngay_muon" name="ngaymuon" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Ngày trả:</label>
                                        <input type="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" id="ngay_tra" name="ngaytra" required onchange="validateDate()">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="muontb">Mượn</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Update-->
<?php $stt++;
                    } ?>

</tbody>
</table>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };
        $('.borrowDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/finddevice/borrowDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        });
        $('#option-building').on('change', function(e) {

            $.ajax({
                url: "<?php echo BASE_URL; ?>/finddevice/getRoom",
                method: "GET",
                data: {
                    id: e.target.value
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#option-room').empty();
                    $.each(response, (i, item) => {
                        $('#option-room').append($('<option>', {
                            value: item.phong,
                            text: item.phong
                        }))
                        console.log(item);
                    })
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error('error');
                }
            })
        })

    })
</script>
<script>
    function validateDate() {
        var date1 = new Date(document.getElementById("ngay_muon").value);
        var date2 = new Date(document.getElementById("ngay_tra").value);
        if (date2 <= date1) {
            toastr.error("Ngày trả phải lớn hơn ngày mượn.");
            document.getElementById("ngay_tra").value = "";
        }
    }
    CKEDITOR.replace("editor");
</script>

<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }