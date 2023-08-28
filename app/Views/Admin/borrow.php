<?php
if ($_SESSION['quyen'] == 2) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử mượn trả</h1>
    <div class="card mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Người dùng</th>
                        <th>Tên thiết bị</th>
                        <th>Ảnh</th>
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Địa điểm</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật tình trạng yêu cầu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="updateStatus">
                            <input type="hidden" class="form-control" id="id-update" name="id" value="<?php echo $arUser["id"] ?>">
                            <input type="hidden" class="form-control" id="id-device" name="thietbiid" value="<?php echo $arUser["thietbi_id"] ?>">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <select class="form-select" aria-label="Default select example" id="select-status" tabindex="8" name="tinhtrang" required>
                                            <option value="" selected>Chọn tình trạng</option>
                                            <?php if ($arUser["trangthai"] == "Chờ phê duyệt") { ?>
                                                <option value="Đã phê duyệt">Phê duyệt yêu cầu</option>
                                                <option value="Bị từ chối">Từ chối yêu cầu</option>
                                            <?php } ?>
                                            <?php if ($arUser["trangthai"] == "Đã phê duyệt") { ?>
                                                <option value="Đang mượn">Đang mượn</option>
                                            <?php } ?>
                                            <?php if ($arUser["trangthai"] == "Đang mượn") { ?>
                                                <option value="Đã trả">Đã trả</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" name="capnhat">Cập nhật</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        getBorrowDeviceList()

        function getBorrowDeviceList() {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/getBorrowDeviceList", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        console.log(response, );
                        let userTable = '';
                        table.clear();
                        response.data.forEach((e, index) => {
                            table.row.add([
                                index + 1,
                                e.hoten,
                                e.ten,
                                function() {
                                    return (`
                                    <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}?>"></td>
                                    `)
                                },
                                convertDateFormat(e.ngaymuon),
                                convertDateFormat(e.ngaytra),
                                // e.dactinhkithuat,
                                e.diadiem,
                                e.trangthai,
                                function() {
                                    return (e.trangthai == "Đã trả" || e.trangthai == "Bị từ chối" ? '' :
                                        `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-bs-toggle="modal" data-id=${e.id} data-bs-target="#ModalEdit">
                                        Cập nhật
                                        </button>                                    
                                    </td>
                                `
                                    )
                                },
                            ])
                        });
                        table.draw();

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
        }

        function convertDateFormat(inputDate) {
            var parsedDate = new Date(inputDate);

            if (isNaN(parsedDate)) {
                return 'Invalid input date';
            }

            var day = parsedDate.getDate().toString().padStart(2, '0');
            var month = (parsedDate.getMonth() + 1).toString().padStart(2, '0');
            var year = parsedDate.getFullYear();

            return day + '-' + month + '-' + year;
        }
        $('#updateStatus').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            // var formData = $(this).serializeJSON();
            // var formData = new FormData(this);

            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/updateBorrowStatus", // Đường dẫn đến controller xử lý
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
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, id);

                    $('#select-status').html('');
                    $('#select-status').append(`<option value="" selected>Chọn tình trạng</option>`)

                    let option;
                    if (response.data[0].trangthai === "Chờ phê duyệt") {
                        option += `<option value = "Đã phê duyệt"> Phê duyệt yêu cầu </option> 
                        <option value = "Bị từ chối"> Từ chối yêu cầu </option>`
                    } else if (response.data[0].trangthai === "Đã phê duyệt") {
                        option += `<option value = "Đang mượn" > Đang mượn </option>`
                    } else {
                        option += `<option value = "Đã trả">Đã trả </option>`
                    }

                    $('#select-status').append(option)
                    $('#id-update').val(response.data[0].id);
                    $('#id-device').val(response.data[0].thietbi_id);

                    // $('#hotenUpdate').val(response.hoten);
                    // $('#emailUpdate').val(response.email);
                    // $('#diachiUpdate').val(response.diachi);
                    // $('#sdtUpdate').val(response.sodienthoai);
                    // $('#matkhauUpdate').val(response.matkhau);
                    // $('#taikhoanUpdate').val(response.taikhoan);
                    // $('#idUpdate').val(response.id);
                }
            })
        });
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