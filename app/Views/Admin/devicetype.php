<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách loại thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                Thêm mới
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên loại thiết bị</th>
                        <th>Mã loại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <!--Dele Modal-->
            <div class="modal fade" id="ModalDel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Loại thiết bị : <p id="devicetype-name-del"></p>
                            <form method="post" id="delType">
                                <input type="hidden" class="form-control" id="id-del" name="id">
                                <div class="modal-footer" style="margin-top: 20px">
                                    <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Đóng
                                    </button>
                                    <button style="width:100px" type="submit" class="btn btn-danger" name="deletedm"> Xóa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Dele Modal-->
            <!-- Modal Update-->
            <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="editType">
                                <input type="hidden" class="form-control" id="id-edit" name="id">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="devicetype-name-edit" class="col-form-label">Tên loại thiết bị:</label>
                                            <input type="text" class="form-control" id="devicetype-name-edit" name="ten" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" name="editdm">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Update-->
            <!-- Modal Add-->
            <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="addType">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                            <select class="form-select" aria-label="Default select example" id="cate-add" tabindex="8" name="categories" required>
                                                <option value="" selected>Chọn danh mục thiết bị</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="devicetype-name-add" class="col-form-label">Tên loại thiết bị:</label>
                                            <input type="text" class="form-control" id="devicetype-name-add" name="ten" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" name="adddm">Tạo </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Update-->
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };
        getDeviceType()
        // $('#cate-add').change(function() {
        //     let cate = $('#cate-add').val();
        //     console.log(cate, '123');
        $.ajax({
            url: "<?php echo BASE_URL; ?>/devicelist/getDeviceCategories", // Đường dẫn đến controller xử lý
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    $('#cate-add').html('')
                    let cateAdd = `<option value="">Chọn Danh mục</option>`;
                    response.data.map((cate) => {
                        // if (type.id == response.data.loaithietbi_id) {
                        //     typeAdd += `<option value="${type.id}" selected>${type.ten}</option>`
                        // } else {
                        cateAdd += `<option value="${cate.madanhmuc}">${cate.tendanhmuc}</option>`
                        // }
                    })
                    $('#cate-add').append(cateAdd)
                } else {}
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        // })
        $('#addType').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('#addType').serialize());
            $.ajax({
                url: "<?php echo BASE_URL; ?>/deviceType/addDeviceType", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addType').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAdd');
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

        $('#editType').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/deviceType/editDeviceType", // Đường dẫn đến controller xử lý
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

        $('#delType').submit(function(e) {
            e.preventDefault();
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            console.log(1111, formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/deviceType/deleteDeviceType",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalDel${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        toastr.error(response.message);

                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicetype/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#devicetype-name-edit').val(response.ten);
                    $('#id-edit').val(response.id);
                }
            })
        });
        $(document).on('click', '.modal-del', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicetype/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#devicetype-name-del').text(response.ten);
                    $('#id-del').val(response.id);
                }
            })
        });

        function getDeviceType() {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/deviceType/getDeviceType", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                        let userTable = '';
                        table.clear();
                        response.data.forEach((e, index) => {
                            table.row.add([
                                index + 1,
                                e.ten,
                                e.maloai,
                                function() {
                                    return (
                                        `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalEdit">
                                        Sửa
                                    </button>
                                    <button type="button" class="btn btn-danger modal-del" data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalDel">
                                        Xóa
                                    </button>
                                    </td>
                                        `
                                    )
                                },
                            ])
                        })
                        table.draw();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
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