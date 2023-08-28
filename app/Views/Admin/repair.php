<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách yêu cầu sửa chữa đã nhận</h1>
    <div class="card mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Ngày gửi</th>
                        <th>Thiết bị</th>
                        <th>Nội dung</th>
                        <!-- <th>Chi phí</th> -->
                        <!-- <th>Thời gian</th> -->
                        <th>Người gửi</th>
                        <th>Người sửa chữa</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
                                <input type="hidden" class="form-control" id="id-assign" name="id">
                                <div class="col">
                                    <!-- <div class="row">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Chi phí:</label>
                                            <input type="text" class="form-control" id="category-film" name="chiphi" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Thời gian:</label>
                                            <input type="text" class="form-control" id="category-film" name="thoigian" required>
                                        </div>
                                    </div> -->
                                    <select class="form-select" id="list-staff" aria-label="Default select example" id="theloai" tabindex="8" name="id-staff" required>
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


        getRepairList();

        function getRepairList() {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/getRepairList",
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
                                e.ngaygui,
                                // e.noidung,
                                function() {
                                    return (`
                                    <td>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#ModalDes" class= "modal-desc" data-id = '${e.thietbi_id}'>Xem</a>
                                    </td>
                                    `)
                                },
                                e.noidung,
                                e.hoten,
                                function() {
                                    const staffName = response.staff.find(s => e.phancong === s.id);
                                    if (staffName) {
                                        return staffName.hoten;
                                    } else return ""
                                },
                                e.tinhtrang,
                                function() {
                                    return (`
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                        Phân công
                                    </button>
                                    </td>
                                    `)
                                },
                                // convertDateFormat(e.ngaytao),
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
        $('#editRepair').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/assignRepair", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'res');
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        console.log(response);
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    toastr.error(xhr.responseText);

                    console.error(xhr, status, error);
                }
            });
        });
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            console.log('edit', id);
            let staffList;

            $.ajax({
                url: `<?php echo BASE_URL; ?>/repair/getDataModal?id=${id}`,
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'repair');
                    $('#list-staff').html('');
                    $('#list-staff').append(`<option value="" selected>Chọn tình trạng</option>`);

                    response.staff.map((s) => {
                        if (s.id == response.staffAssign[0].phancong) {
                            console.log('selected', staffList);
                            staffList += `<option value="${s.id}" selected>${s.hoten}</option>`
                        } else {
                            console.log('not selected', staffList);
                            staffList += `<option value="${s.id}">${s.hoten}</option>`

                        }
                    })
                    console.log(1, staffList, 1);
                    $('#list-staff').append(staffList)
                    $('#id-assign').val(id)
                    // let typeList;
                    // console.log(response.devicetype, '1');
                    // response.devicetype.map((type) => {
                    //     if (type.id == response.data.loaithietbi_id) {
                    //         typeList += `<option value="${type.id}" selected>${type.ten}</option>`
                    //     } else {
                    //         typeList += `<option value="${type.id}">${type.ten}</option>`
                    //     }
                    // })
                    // $('#theloai').append(typeList);
                    // $('#id-edit').val(response.data.id);
                    // $('#device-name-edit').val(response.data.ten)
                    // $('#device-quantity-edit').val(response.data.soluong)
                    // $('#device-desc-edit').val(response.data.dactinhkithuat)
                    // $('#device-status-edit').val(response.data.tinhtrang)
                    // $('#id-edit').val(response.id);
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