<?php

if ($_SESSION['quyen'] != 1) {
    header("Location: dashboard");
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách người dùng</h1>
    <div class="card mb-4">
        <div class="card-header d-flex flex-column">
            <div class="flex-column col-8">
                <div class="input-group mb-3">
                    <div class="col-2">
                        <select id="filterSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="hoten">Họ tên</option>
                            <option value="email">Email</option>
                            <option value="sodienthoai">Số điện thoại</option>
                            <option value="taikhoan">Tài khoản</option>
                            <option value="diachi">Địa chỉ</option>
                        </select>
                    </div>

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-3 mx-3">
                        <select id="select-role" class="form-select col" aria-label="Default select example">
                            <option value="" selected disabled hidden>Loại tài khoản</option>
                            <option value="0">Tất cả</option>
                            <!-- <option value="1">Admin</option> -->
                            <option value="2">Người dùng</option>
                            <option value="3">Nhân viên</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                    Thêm mới
                </button>
                <!-- <button class="btn btn-success" id="btn-export">
                    Export
                </button>
                <button class="btn btn-success" id="btn-export" data-bs-toggle="modal" data-bs-target="#exampleModalImport">
                    Import
                </button> -->
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Họ tên</th>
                        <!-- <th>Email</th>
                        <th>Số điện thoại</th> -->
                        <th>Tài khoản</th>
                        <th>Địa chỉ</th>
                        <!-- <th>Mật khẩu</th> -->
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

            </ul>


            <!--Dele-->
            <div class="modal fade" id="exampleModalDel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Người dùng : <span id="hotenDel"></span>
                            <form method="post" id="delUser">
                                <input type="hidden" class="form-control" id="idDel" name="id" value="">
                                <div class="modal-footer" style="margin-top: 20px">
                                    <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Đóng
                                    </button>
                                    <button style="width:100px" type="submit" class="btn btn-danger" name="deletenv"> Xóa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Dele-->
            </td>

            </tr>
            <!-- Modal Update-->
            <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="editUser">
                                <input type="hidden" class="form-control" id="idUpdate" name="id" value="">
                                <div class="col mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Họ tên:</label>
                                            <input type="text" class="form-control" value="" id="hotenUpdate" name="hoten" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Email:</label>
                                            <input type="text" class="form-control" value="" id="emailUpdate" name="email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Tài khoản:</label>
                                            <input type="text" class="form-control" id="taikhoanUpdate" name="taikhoan" value="" required>
                                        </div>
                                        <!-- <div class="col-6">
                                            <label for="category-film" class="col-form-label">Mật khẩu:</label>
                                            <input type="text" class="form-control" id="matkhauUpdate" value="" name="matkhau" required>
                                        </div> -->
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Số điện thoại:</label>
                                            <input type="text" class="form-control" id="sdtUpdate" value="" name="sdt" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Địa chỉ:</label>
                                            <input type="text" class="form-control" id="diachiUpdate" name="diachi" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" name="editnv">Lưu</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Modal Update-->
            <!-- Modal Add-->
            <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="addUser">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Họ tên:</label>
                                            <input type="text" class="form-control" id="addUserName" name="hoten" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Email:</label>
                                            <input type="email" class="form-control" id="addUserEmail" name="email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Tài khoản:</label>
                                            <input type="text" class="form-control" id="addUserAcc" name="taikhoan" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Mật khẩu:</label>
                                            <input type="text" class="form-control" id="addUserPass" name="matkhau" pattern=".{6,}" title="Mật khẩu phải có ít nhất 6 ký tự" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Số điện thoại:</label>
                                            <input type="text" class="form-control" id="addUserSdt" name="sdt" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Địa chỉ:</label>
                                            <input type="text" class="form-control" id="addUserAddress" name="diachi" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary" name="addnv">Lưu</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Modal Add-->
            <!-- Import modal -->
            <div class="modal fade" id="exampleModalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="importExcel">
                                <input type="file" name="excelFile" accept=".xlsx">
                                <button class="btn btn-success" type="submit">Import </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- import modal -->
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        console.log('userlist', table);
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };
        let prevOptionSearch = '';
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevRoleSearch = 0;
        getUserList()

        $('#editUser').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/editUser",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {

                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#importExcel').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#importExcel')[0]);

            console.log(111, $(this));
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/importExcel",
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response, 112);
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalImport`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        toastr.error(response.message);

                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(xhr.responseText);

                }
            });
        });
        $('#btn-export').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/exportExcel",
                method: "POST",
                success: function(response) {
                    console.log(response, 'response');
                    // if (response === 'success') {
                    $.ajax({
                        url: response,
                        method: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(data) {
                            console.log(data, 'data');
                            saveAs(data, response);
                        },
                        error: function(xhr, status, error) {
                            console.log(error, 'loi');
                        }
                    });
                    // } else {
                    //     console.log(response.message);
                    // }
                },
                error: function() {}
            });
        });
        $('#addUser').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/addUser",
                method: 'POST',
                data: $('#addUser').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById('exampleModalAdd');
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

        $('#delUser').submit(function(e) {
            e.preventDefault();
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            console.log(1111, formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/deleteUser",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalDel`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $('#button-search').click((e) => {
            e.preventDefault();
            console.log('search');
            var option = $('#filterSelect').val();
            var keyword = $('#datatable-input').val();
            var role = $('#select-role').val();
            console.log(role, 'role', option);
            const data = {
                option: option,
                keyword: keyword
            }
            if (option != prevOptionSearch || keyword != prevKeywordSearch) {
                prevKeywordSearch = keyword;
                prevOptionSearch = option;
            }
            getUserList(option, keyword, prevPage, role)
        })

        $('#select-role').change(function() {
            var role = $(this).val();
            console.log(role, 123);
            prevPage = 0;
            getUserList(prevOptionSearch, prevKeywordSearch, prevPage, role)
        });
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var clickedPage = $(this).data('page');
            console.log('page');
            if (clickedPage === 'previous') {
                if (prevPage > 0) {
                    console.log("Clicked Page: " + prevPage);
                    getUserList(prevOptionSearch, prevKeywordSearch, prevPage - 1, prevRoleSearch)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getUserList(prevOptionSearch, prevKeywordSearch, prevPage + 1, prevRoleSearch)
                    prevPage = prevPage + 1;
                }
            } else {

                getUserList(prevOptionSearch, prevKeywordSearch, clickedPage, prevRoleSearch)
                prevPage = clickedPage;
                console.log("Clicked Page: " + prevPage);
            }
        });
        $(document).on('click', '.modal-Edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/getModalEdit",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#hotenUpdate').val(response.hoten);
                    $('#emailUpdate').val(response.email);
                    $('#diachiUpdate').val(response.diachi);
                    $('#sdtUpdate').val(response.sodienthoai);
                    $('#matkhauUpdate').val(response.matkhau);
                    $('#taikhoanUpdate').val(response.taikhoan);
                    $('#idUpdate').val(response.id);
                }
            })
        });
        $(document).on('click', '.modal-Del', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/userlist/getModalDel",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#idDel').val(response.id)
                    $('#hotenDel').text(response.hoten)
                }
            })
        });

        function getUserList(option = '', keyword = '', page = 0, role = '') {
            $.ajax({
                url: `<?php echo BASE_URL; ?>/userlist/getUserList?option=${option}&keyword=${keyword}&page=${page}&role=${role}`,
                method: "GET",
                success: function(response) {
                    console.log(response, 'res');
                    let userTable = '';
                    table.clear();
                    response.data.forEach((e, index) => {
                        table.row.add([
                            index + 1,
                            e.hoten,
                            // e.email,
                            // e.sodienthoai,
                            e.taikhoan,
                            e.diachi,
                            function() {
                                return (
                                    `
                                    <td style="width : 130px !important">
                                        <button type="button" class="btn btn-primary modal-Edit"  data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#exampleModalEdit">
                                            Sửa
                                        </button>
                                        <button type="button" class="btn btn-danger modal-Del" data-bs-toggle="modal" data-bs-target="#exampleModalDel"  data-id="${e.id}">
                                            Xóa
                                        </button>
                                    </td>
                                `
                                )
                            },
                        ])
                    })
                    table.draw();
                    let pagination = ""
                    if (prevPage == 0) {
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                    } else {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                    }
                    let itemPerPage = 10;
                    for (let i = 0; i < (response.count / itemPerPage); i++) {
                        if (i == prevPage) {
                            pagination += `<li class="page-item disabled"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                        } else {
                            pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                        }
                    }
                    if (prevPage == Math.floor((response.count / itemPerPage))) {
                        console.log(response.count / itemPerPage, 'dis');
                        pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                    } else {
                        console.log(response.count / itemPerPage);

                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                    }
                    $('#pagination').html(pagination)
                }
            })
        }
    })
</script>

<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }