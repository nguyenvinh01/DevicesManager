<div class="container-fluid px-4">

    <h1 class="mt-4">Danh sách thiết bị kiểm tra</h1>
    <div class="card mb-4">

        <div class="card-header">
            <!-- <button type="button" class="btn btn-success" id="add-button" data-bs-toggle="modal" data-bs-target="#ModalAdd">
                Thêm mới
            </button> -->
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Thiết bị</th>
                        <th>Số lượng</th>
                        <th>Người kiểm tra</th>
                        <th>Thời gian kiểm tra</th>
                        <th>Phòng ban</th>
                        <th>Địa điểm</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            <!--Des-->
            <!-- <div class="modal fade" id="ModalDesc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nội dung</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo $arUser["noidung"] ?>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Modal Update-->
            <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xác nhận đã xử lý</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="editRepair">
                                <input type="hidden" class="form-control" id="id-repair" name="id">
                                <div class="col">
                                    <select class="form-select" id="list-staff" aria-label="Default select example" id="theloai" tabindex="8" name="status-repair" required>
                                        <option value="" selected>Chọn tình trạng</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" name="xnsc">Xác nhận</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal Update-->
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
        getAssignList();

        function getAssignList() {
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getAssignList`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response, 11);
                        let userTable = '';
                        table.clear();
                        response.data.forEach((e, index) => {
                            table.row.add([
                                index + 1,
                                e.ten_thietbi,
                                e.soluong,
                                e.ten_nv,
                                e.ngaykiemtra,
                                e.ten_phongban,
                                e.ten_toanha + "-" + e.ten_diadiem,
                                e.tinhtrang,
                                function() {
                                    return (
                                        e.tinhtrang == "Đã xử lý" ? "" : `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                        Kiểm tra
                                    </button>
                                    </td>
                                    `)
                                },
                            ])
                        });
                        table.draw();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $('#addAssign').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log('submit');
            var formData = new FormData(this);
            console.log(formData, 'addAssign');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/addAssign", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addAssign').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('ModalAdd');
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error("error");
                }
            });
        });

        $('#devicetype').on('change', function(e) {
            e.preventDefault();
            let deviceList;
            $('#device-quantity').text('');
            $('#quantityInput').attr('max', 0)

            const id = $('#devicetype option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getDeviceByType?id=${id}`, // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#device-list').html('');
                        $('#device-list').append('<option value="" selected>Chọn loại thiết bị</option>');
                        response.data.forEach((d) => {
                            deviceList += `<option value="${d.id}">${d.ten}</option>`
                        })

                        $('#device-list').append(deviceList);

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#device-list').on('change', function(e) {
            e.preventDefault();
            let deviceList;
            const id = $('#device-list option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getDeviceById?id=${id}`, // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        if (response.data) {
                            $('#device-quantity').text("Số lượng còn lại: " + response.data.soluong);
                            $('#quantityInput').attr('max', response.data.soluong)
                        } else {
                            $('#device-quantity').text('');
                        }
                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })

        $('#assginStaff').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/assignStaff", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalEdit`);
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
        $('#editRepair').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/updateStatusRepair", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'res');
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        // toastr.success(response.message);
                        // var modalElement = document.getElementById(`exampleModalEdit${id}`);
                        // var modal = bootstrap.Modal.getInstance(modalElement);
                        // modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        console.log(response);
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    // toastr.error(xhr.responseText);

                    console.error(xhr, status, error);
                }
            });
        });
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            console.log('edit', id);
            let staffList;

            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getDataModal`,
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'repair');
                    $('#list-staff').html('');
                    $('#list-staff').append(`<option value="" selected>Chọn tình trạng</option>`);
                    if (response.data[0].tinhtrang == "Chờ xử lý") {
                        staffList += `<option value="Đang kiểm tra">Đang kiểm tra</option>`
                    } else if (response.data[0].tinhtrang == "Đang kiểm tra") {
                        staffList += `<option value="Cần sửa chữa">Cần sửa chữa</option>`
                        // staffList += `<option value="Cần sửa chữa">Cần sửa chữa</option>`

                    } else if (response.data[0].tinhtrang == "Cần sửa chữa") {
                        staffList += `<option value="Đang sửa chữa">Đang sửa chữa</option>`
                        // staffList += `<option value="Cần sửa chữa">Cần sửa chữa</option>`
                    } else if (response.data[0].tinhtrang == "Đang sửa chữa") {
                        staffList += `<option value="Hoàn thành">Hoàn thành</option>`
                        // staffList += `<option value="Cần sửa chữa">Cần sửa chữa</option>`
                    }
                    console.log(1, staffList, 1);
                    $('#list-staff').append(staffList)
                    $('#id-repair').val(id)
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