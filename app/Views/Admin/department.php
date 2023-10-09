<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách phòng ban</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="phongban" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="phongban">Danh sách phòng ban</label>

                <input type="radio" class="btn-check" name="btnradio" id="diadiem" autocomplete="off">
                <label class="btn btn-outline-primary" for="diadiem">Danh sách địa điểm</label>

            </div>
            <div class="flex-row">
                <div class="dropdown mt-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thao tác
                    </button>
                    <ul class="dropdown-menu">
                        <button type="button" class="btn btn-primary dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalAddBuilding" id="ModalAddBuilding">
                            Thêm địa điểm
                        </button>
                        <button type="button" class="btn btn-primary dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalAddDepartment" id="ModalAddDepartment">
                            Thêm phòng ban
                        </button>
                    </ul>
                </div>
                <div class="flex-row col-6 mt-3">
                    <div class="input-group mb-3">
                        <input id="datatable-input" type="text" class="form-control col-16" placeholder="Tên phòng ban..." aria-label="Search..." aria-describedby="button-addon2">
                        <button class="btn btn-primary col-2" type="submit" id="button-search">Search</button>
                        <!-- <div class="col-4 mx-3">
                            <select id="device-type" class="form-select col" aria-label="Default select example">
                                <option value="">Loại thiết bị</option>
                            </select>

                        </div> -->
                    </div>
                </div>

            </div>

        </div>
        <div class="card-body">
            <table id="building-table">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên tòa</th>
                        <th>Tên phòng/tầng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table id="department-table">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên phòng ban</th>
                        <th>Địa điểm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

        </div>
        <!--Dele Modal Building-->
        <div class="modal fade" id="ModalDelBuilding" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Loại thiết bị : <p id="building-name-del"></p> -->
                        <form method="post" id="delBuilding">
                            <input type="hidden" class="form-control" id="id-del-building" name="id">
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
        <!--End Dele Cate Modal-->
        <!--Dele Depart Modal-->
        <div class="modal fade" id="ModalDelDepartment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tên phòng ban : <p id="department-name-del"></p>
                        <form method="post" id="delDepartment">
                            <input type="hidden" class="form-control" id="id-del-department" name="id">
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
        <!--End Dele Depart Modal-->
        <!-- Modal Update Builidng-->
        <div class="modal fade" id="ModalEditBuilding" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật địa điểm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="editBuilding">
                            <input type="hidden" class="form-control" id="id-edit" name="id">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="building-name-edit" class="col-form-label">Tên địa điểm:</label>
                                        <input type="text" class="form-control" id="building-name-edit" name="ten" required>
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
        <!-- Modal Update building-->

        <!-- Modal department Update-->
        <div class="modal fade" id="ModalEditDepartment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="editDepartment">
                            <input type="hidden" class="form-control" id="id-edit-department" name="id">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="department-name-edit" class="col-form-label">Tên phòng ban:</label>
                                        <input type="text" class="form-control" id="department-name-edit" name="tenphongban" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="category-film" class="col-form-label">Danh sách tòa nhà:</label>
                                    <select class="form-select building" aria-label="Default select example" id="building-department-edit" tabindex="8" name="toanha" required>
                                        <option value="" selected>Chọn tòa nhà</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="category-film" class="col-form-label">Danh sách tầng:</label>
                                    <select class="form-select" aria-label="Default select example" id="building-department-floor-edit" tabindex="8" name="tang" required>
                                        <option value="" selected>Chọn tầng</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="category-film" class="col-form-label">Danh sách phòng:</label>
                                    <select class="form-select" aria-label="Default select example" id="building-department-room-edit" tabindex="8" name="phong" required>
                                        <option value="" selected>Chọn phòng</option>
                                    </select>
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
        <!-- Modal department Update-->

        <!-- Modal Add Building-->
        <div class="modal fade" id="exampleModalAddBuilding" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới địa điểm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <form method="POST" enctype="multipart/form-data" id="addType">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                            <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                            <select class="form-select" aria-label="Default select example" id="cate-add" tabindex="8" name="categories" required>
                                                <option value="" selected>Chọn danh mục thiết bị</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="department-name-add" class="col-form-label">Tên loại thiết bị:</label>
                                            <input type="text" class="form-control" id="department-name-add" name="ten" required>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" name="adddm">Tạo </button>
                            </div>
                        </form> -->
                        <form method="POST" enctype="multipart/form-data" id="addLocation">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Tên địa điểm:</label>
                                        <input type="text" class="form-control" id="location-name-add" name="tendiadiem" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Danh sách tòa nhà:</label>
                                        <select class="form-select" aria-label="Default select example" id="building-add-location" tabindex="8" name="toanha" required>
                                            <option value="" selected>Chọn tòa nhà</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Danh sách tầng:</label>
                                        <select class="form-select" aria-label="Default select example" id="building-floor-location" tabindex="8" name="tang" required>
                                            <option value="" selected>Chọn tầng</option>
                                        </select>
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
        <!-- Modal Add Building-->
        <!-- Modal Add Department-->
        <div class="modal fade" id="exampleModalAddDepartment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới phòng ban</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="addDepartment">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Tên phòng ban:</label>
                                        <input type="text" class="form-control" id="department-name-add" name="tenphongban" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Danh sách tòa nhà:</label>
                                        <select class="form-select" aria-label="Default select example" id="building" tabindex="8" name="toanha" required>
                                            <option value="" selected>Chọn tòa nhà</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Danh sách tầng:</label>
                                        <select class="form-select" aria-label="Default select example" id="building-floor" tabindex="8" name="tang" required>
                                            <option value="" selected>Chọn tầng</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Danh sách phòng:</label>
                                        <select class="form-select" aria-label="Default select example" id="building-room" tabindex="8" name="phong" required>
                                            <option value="" selected>Chọn phòng</option>
                                        </select>
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
        <!-- Modal Add Department-->
    </div>
</div>
<script>
    $(document).ready(() => {
        let table_building = new DataTable('#building-table', {
            searching: false,
            bPaginate: false,
            info: false,
            "language": {
                "emptyTable": "Không có dữ liệu"
            }
        });
        let table_department = new DataTable('#department-table', {
            searching: false,
            bPaginate: false,
            info: false,
            "language": {
                "emptyTable": "Không có dữ liệu"
            }
        });
        let prevKeywordSearch = '';
        let prevPage = 0;
        let option = 'phongban';
        // let prevTypeSearch = '';
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };
        $('#building-table').hide()
        getDepartmentList(prevKeywordSearch, 0)

        $('#addDepartment').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('#addDepartment').serialize());
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/addDepartment", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addDepartment').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAddDepartment');
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
        $('#addLocation').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('#addLocation').serialize());
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/addLocation", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addLocation').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAddLocation');
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
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var clickedPage = $(this).data('page');
            let selected = $('input[type=radio][name=btnradio]:selected').attr('id');
            if (option == "phongban") {
                if (clickedPage === 'previous') {
                    if (prevPage > 0) {
                        console.log("Clicked Page: " + prevPage);
                        getDepartmentList(prevKeywordSearch, prevPage - 1)
                        prevPage = prevPage - 1;
                    }
                } else if (clickedPage === 'next') {
                    if (prevPage >= 0) {
                        console.log("Clicked Page: " + prevPage);
                        getDepartmentList(prevKeywordSearch, prevPage + 1)
                        prevPage = prevPage + 1;
                    }
                } else {
                    getDepartmentList(prevKeywordSearch, clickedPage)
                    prevPage = clickedPage;
                    console.log("Clicked Page: " + prevPage);
                }
            } else if (option == "diadiem") {
                console.log('page');
                if (clickedPage === 'previous') {
                    if (prevPage > 0) {
                        console.log("Clicked Page: " + prevPage);
                        getBuilding(prevKeywordSearch, prevPage - 1)
                        prevPage = prevPage - 1;
                    }
                } else if (clickedPage === 'next') {
                    if (prevPage >= 0) {
                        console.log("Clicked Page: " + prevPage);
                        getBuilding(prevKeywordSearch, prevPage + 1)
                        prevPage = prevPage + 1;
                    }
                } else {
                    getBuilding(prevKeywordSearch, clickedPage)
                    prevPage = clickedPage;
                    console.log("Clicked Page: " + prevPage);
                }
            }
        });
        $('#editDepartment').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/editDepartment", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalEditDepartment`);
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

        $('#delDepartment').submit(function(e) {
            e.preventDefault();
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            console.log(1111, formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/deleteDepartment",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalDelCate`);
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
        $('#button-search').click((e) => {
            e.preventDefault();
            console.log('search');
            var keyword = $('#datatable-input').val();
            prevKeywordSearch = keyword;
            // if (option != prevOptionSearch || keyword != prevKeywordSearch) {
            //     prevKeywordSearch = keyword;
            //     prevOptionSearch = option;
            // }
            getDepartmentList(keyword, 0)
        })
        $(document).on('click', '.modal-edit-building', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#department-name-edit').val(response.ten);
                    $('#id-edit').val(response.id);
                }
            })
        });
        $(document).on('click', '.modal-del-building', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#department-name-del').text(response.ten);
                    $('#id-del').val(response.id);
                }
            })
        });
        $(document).on('click', '.modal-edit-department', function() {
            var id = $(this).data('id');
            let toanha, tang, phong;

            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getDataEditDepartment",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-department-edit').html('')
                    $('#building-department-floor-edit').html('')
                    $('#building-department-room-edit').html('')

                    response.building.forEach(b => {
                        if (b.id == response.data.toanha) {
                            toanha += `<option value="${b.id}" selected>${b.tentoanha}</option>`
                        } else {
                            toanha += `<option value="${b.id}">${b.tentoanha}</option>`

                        }
                    })
                    response.floor.forEach(f => {
                        if (f.tang == response.data.tang) {
                            tang += `<option value="${f.tang}" selected>${f.tang}</option>`
                        } else {
                            tang += `<option value="${f.tang}">${f.tang}</option>`

                        }
                    })
                    response.room.forEach(r => {
                        if (r.phong == response.data.phong) {
                            phong += `<option value="${r.phong}" selected>${r.phong}</option>`
                        } else {
                            phong += `<option value="${r.phong}">${r.phong}</option>`

                        }
                    })
                    console.log();
                    $('#building-department-edit').html(toanha)
                    $('#building-department-floor-edit').html(tang)
                    $('#building-department-room-edit').html(phong)
                    $('#department-name-edit').val(response.data.tenpb)
                    $('#id-edit-department').val(response.data.id_pb)
                    console.log(response.data.id);

                }
            })
        });
        $(document).on('click', '.modal-del-department', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getDataDelDepartment",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#department-name-del').text(response.data.tenpb);
                    $('#id-del-department').val(response.data.id);
                }
            })
        });

        // Start add department
        $('#ModalAddDepartment').click(function(e) {
            e.preventDefault();
            let phongban = '';
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getBuilding", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#building').html('')
                        response.data.forEach((pb) => {
                            console.log(pb);

                            phongban += `<option value="${pb.toanhaid}">${pb.tentoanha}</option>`
                        })
                        $('#building').append(phongban);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#building').change(function(e) {
            e.preventDefault();
            let tang = '<option value="" selected>Chọn tầng</option>';
            const id = $('#building option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getFloor", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idToaNha: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-floor').html('');
                    if (response.status == "success") {

                        response.data.forEach((pb) => {
                            console.log(pb.tenpb);

                            tang += `<option value="${pb.tang}">${pb.tang}</option>`
                        })
                        $('#building-floor').append(tang);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#building-add-location').change(function(e) {
            e.preventDefault();
            let tang = '<option value="" selected>Chọn tầng</option>';
            const id = $('#building-add-location option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getFloor", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idToaNha: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-floor-location').html('');
                    if (response.status == "success") {

                        response.data.forEach((pb) => {
                            console.log(pb.tenpb);

                            tang += `<option value="${pb.tang}">${pb.tang}</option>`
                        })
                        $('#building-floor-location').append(tang);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#building-floor').change(function(e) {
            e.preventDefault();
            let tang = '<option value="" selected>Chọn phòng</option>';
            const id = $('#building option').filter(":selected").val();
            const idTang = $('#building-floor option').filter(":selected").val();

            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getRoom", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idToaNha: id,
                    idTang: idTang
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-room').html('');
                    if (response.status == "success") {

                        response.data.forEach((pb) => {
                            console.log(pb.tenpb);

                            tang += `<option value="${pb.phong}">${pb.phong}</option>`
                        })
                        $('#building-room').append(tang);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        // End Add Department

        $('#building-department-edit').change(function(e) {
            e.preventDefault();
            let tang = '<option value="" selected>Chọn tầng</option>';
            const id = $('#building-department-edit option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getFloor", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idToaNha: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-department-floor-edit').html('');
                    if (response.status == "success") {

                        response.data.forEach((pb) => {
                            console.log(pb.tenpb);

                            tang += `<option value="${pb.tang}">${pb.tang}</option>`
                        })
                        $('#building-department-floor-edit').append(tang);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#building-department-floor-edit').change(function(e) {
            e.preventDefault();
            let tang = '<option value="" selected>Chọn phòng</option>';
            const id = $('#building-department-edit option').filter(":selected").val();
            const idTang = $('#building-department-floor-edit option').filter(":selected").val();

            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getRoom", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idToaNha: id,
                    idTang: idTang
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#building-department-room-edit').html('');
                    if (response.status == "success") {

                        response.data.forEach((pb) => {
                            console.log(pb.tenpb);

                            tang += `<option value="${pb.phong}">${pb.phong}</option>`
                        })
                        $('#building-department-room-edit').append(tang);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })

        $('#ModalAddBuilding').click(function(e) {
            e.preventDefault();
            let phongban = '';
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getBuilding", // Đường dẫn đến controller xử lý
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#building-add-location').html('')
                        response.data.forEach((pb) => {
                            console.log(pb);

                            phongban += `<option value="${pb.toanhaid}">${pb.tentoanha}</option>`
                        })
                        $('#building-add-location').append(phongban);
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            })
        })

        function getBuilding(keyword = '', page = 0) {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getBuildingList", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                        table_building.clear();
                        let index = 10 * prevPage;
                        response.data.forEach((e) => {
                            index++;
                            table_building.row.add([
                                index,
                                e.tentoanha,
                                e.phong,
                                function() {
                                    return (
                                        `
                                    <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-edit-building dropdown-item" data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalEditBuilding">
                                                    Sửa phòng
                                                </button>
                                                <button type="button" class="btn btn-danger modal-del-building dropdown-item" data-bs-toggle="modal" data-id="${e.madanhmuc}" data-bs-target="#ModalDelBuilding">
                                                    Xóa phòng
                                                </button>
                                            </ul>
                                        </div>
                                    </td>
                                        `
                                    )
                                },
                            ])
                        })
                        table_building.draw();
                        const paginationHtml = generatePagination(prevPage, Math.ceil((response.count / 10)), 10);
                        console.log('page', response.count / 10);
                        // In phân trang vào một phần tử HTML với id="pagination"
                        $('#pagination').html(paginationHtml);
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

        function getDepartmentList(keyword = '', page = 0) {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/department/getDepartmentList", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        table_department.clear();
                        let index = 10 * prevPage;
                        response.data.forEach((e) => {
                            index++;
                            table_department.row.add([
                                index,
                                e.tenpb,
                                e.tentoanha + "-" + e.phong,
                                function() {
                                    return (
                                        `
                                    <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-edit-department dropdown-item" data-bs-toggle="modal" data-id="${e.id_phongban}" data-bs-target="#ModalEditDepartment">
                                                    Sửa địa điểm
                                                </button>
                                                <button type="button" class="btn btn-danger modal-del-department dropdown-item" data-bs-toggle="modal" data-id="${e.id_phongban}" data-bs-target="#ModalDelDepartment">
                                                    Xóa phòng ban
                                                </button>
                                            </ul>
                                        </div>
                                    </td>
                                        `
                                    )
                                },
                            ])
                        })
                        table_department.draw();
                        const paginationHtml = generatePagination(prevPage, Math.ceil((response.count / 10)), 10);

                        // In phân trang vào một phần tử HTML với id="pagination"
                        $('#pagination').html(paginationHtml);
                        // $('#pagination').html(pagination)
                    } else {
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        }

        function generatePagination(currentPage, totalPages, itemPerPage) {
            let pagination = '';
            const centerPages = 3; // Số trang ở giữa bạn muốn hiển thị

            if (currentPage === 0) {
                pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
            } else {
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
            }

            if (totalPages <= 1) {
                pagination += '<li class="page-item active"><a class="page-link" href="#" data-page="0">1</a></li>';
            } else if (totalPages <= 5) {
                for (let i = 0; i < totalPages; i++) {
                    if (i === currentPage) {
                        pagination += `<li class="page-item active"><a class="page-link" href="#" data-page="${i}">${i + 1}</a></li>`;
                    } else {
                        pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i + 1}</a></li>`;
                    }
                }
            } else {
                const startPage = Math.max(currentPage - Math.floor(centerPages / 2), 0);
                const endPage = Math.min(startPage + centerPages - 1, totalPages - 1);

                if (startPage > 0) {
                    pagination += `<li class="page-item"><a class="page-link" href="#" data-page="0">1</a></li>`;
                    if (startPage > 1) {
                        pagination += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    if (i === currentPage) {
                        pagination += `<li class="page-item active"><a class="page-link" href="#" data-page="${i}">${i + 1}</a></li>`;
                    } else {
                        pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i + 1}</a></li>`;
                    }
                }

                if (endPage < totalPages - 1) {
                    if (endPage < totalPages - 2) {
                        pagination += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages - 1}">${totalPages}</a></li>`;
                }
            }

            if (currentPage >= totalPages - 1 || totalPages < 0) {
                pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
            } else {
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
            }

            return pagination;
        }



        $('input[type=radio][name=btnradio]').change(function() {
            const selectedValue = this.id; // Lấy id của radio button được chọn
            console.log(this);
            option = selectedValue;
            // Ẩn tất cả các bảng
            // $('#department-table').hide();
            // $('#building-table').hide()

            // Gọi hàm để gọi dữ liệu Ajax và hiển thị nó
            if (selectedValue == 'phongban') {
                $('#building-table').hide()
                $('#department-table').show();
                prevPage = 0;

                getDepartmentList(prevKeywordSearch, 0)

            } else if (selectedValue == 'diadiem') {
                $('#department-table').hide();
                $('#building-table').show()
                prevPage = 0;
                getBuilding(prevKeywordSearch, 0)

            }
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