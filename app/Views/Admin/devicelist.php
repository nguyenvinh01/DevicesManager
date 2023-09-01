<?php

if ($_SESSION['quyen'] != 1) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="flex-column col-6">
                <div class="input-group mb-3">
                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Tên thiết bị..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-4 mx-3">
                        <select id="device-type" class="form-select col" aria-label="Default select example">
                            <option value="">Loại thiết bị</option>
                        </select>

                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                Thêm mới
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <!-- <th>Giá trị</th> -->
                        <th>Đặc tính kĩ thuật</th>
                        <th>Loại thiết bị</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

        </div>
        <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="editDevice">
                            <input type="hidden" class="form-control" id="id-edit" name="id" value="<?php echo $arUser["id"] ?>">
                            <div class="col">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                        <select class="form-select" aria-label="Default select example" id="theloai" tabindex="8" name="ltb" required>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <input type="hidden" name="size" value="1000000">
                                        <input type="file" class="form-control" name="image" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                        <input type="text" class="form-control" id="device-name-edit" value="<?php echo $arUser["ten"] ?>" name="ten" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <input type="text" class="form-control" id="device-status-edit" value="<?php echo $arUser["tinhtrang"] ?>" name="tinhtrang" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Số lượng:</label>
                                        <input type="number" class="form-control" id="device-quantity-edit" value="<?php echo $arUser["soluong"] ?>" name="soluong" required>
                                    </div>
                                    <!-- <div class="col-6">
                                        <label for="category-film" class="col-form-label">Giá trị:</label>
                                        <input type="number" class="form-control" id="category-film" value="<?php echo $arUser["giatri"] ?>" name="giatri" required>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                        <textarea name="dtkt" class="form-control" id="device-desc-edit" cols="30" tabindex="8" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="editma">Lưu</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Des-->
        <div class="modal fade" id="ModalDes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="desc-device-view"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="desc-device-detail">
                    </div>
                </div>
            </div>
        </div>
        <!--Dele-->
        <div class="modal fade" id="ModalDel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Thiết bị : <span id="del-device-name"></span>
                        <form method="post" id="delDevice">
                            <input type="hidden" class="form-control" id="id-del" name="id" value="<?php echo $arUser["id"] ?>">
                            <div class="modal-footer" style="margin-top: 20px">
                                <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Đóng
                                </button>
                                <button style="width:100px" type="submit" class="btn btn-danger" name="deletema"> Xóa</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--Dele-->
        <!-- Start Add <odal -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="addDevice">
                            <div class="col">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                        <select class="form-select" aria-label="Default select example" id="type-add" tabindex="8" name="ltb" required>
                                            <option value="" selected>Chọn loại thiết bị</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <input type="hidden" name="size" value="1000000">
                                        <input type="file" class="form-control" name="image" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                        <input type="text" class="form-control" id="category-film" name="ten" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <input type="text" class="form-control" id="category-film" name="tinhtrang" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Số lượng:</label>
                                        <input type="number" class="form-control" id="category-film" name="soluong" required>
                                    </div>
                                    <!-- <div class="col-6">
                                        <label for="category-film" class="col-form-label">Giá trị:</label>
                                        <input type="number" class="form-control" id="category-film" name="giatri" required>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                        <textarea name="dtkt" class="form-control" cols="30" tabindex="8" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" name="addma">Lưu</button>
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
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };
        getDeviceList()
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevTypeSearch = '';

        function getDeviceList(keyword = '', page = 0, type = '') {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/getDeviceList", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    type: type
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                        let userTable = '';
                        table.clear();
                        let index = 5 * prevPage;
                        response.data.forEach((e) => {
                            index++;
                            table.row.add([
                                index,
                                e.ten,
                                // e.hinhanh,
                                function() {
                                    return (`
                                    <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}?>"></td>
                                    `)
                                },
                                e.soluong,
                                // e.dactinhkithuat,
                                function() {
                                    return (`
                                    <td>
                                        <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalDes">
                                    Xem</a>
                                    </td>                                    `)
                                },
                                e.tenloai,
                                e.tinhtrang,
                                function() {
                                    return (
                                        `
                                    <td style="width : 130px !important">
                                        <button type="button" class="btn btn-primary modal-edit"  data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalEdit">
                                            Sửa
                                        </button>
                                        <button type="button" class="btn btn-danger modal-del" data-bs-toggle="modal" data-bs-target="#ModalDel"  data-id="${e.id}">
                                            Xóa
                                        </button>
                                    </td>
                                `
                                    )
                                },
                            ])
                        });
                        table.draw();
                        let typeAdd;
                        response.devicetype.map((type) => {
                            if (type.id == response.data.loaithietbi_id) {
                                typeAdd += `<option value="${type.id}" selected>${type.ten}</option>`
                            } else {
                                typeAdd += `<option value="${type.id}">${type.ten}</option>`
                            }
                        })
                        $('#type-add').append(typeAdd)

                        let pagination = ""
                        if (prevPage == 0) {
                            pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        } else {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        }
                        let itemPerPage = 5;
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
                    } else {}
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var clickedPage = $(this).data('page');
            console.log('page');
            if (clickedPage === 'previous') {
                if (prevPage > 0) {
                    console.log("Clicked Page: " + prevPage);
                    getDeviceList(prevKeywordSearch, prevPage - 1, prevTypeSearch)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getDeviceList(prevKeywordSearch, prevPage + 1, prevTypeSearch)
                    prevPage = prevPage + 1;
                }
            } else {

                getDeviceList(prevKeywordSearch, clickedPage, prevTypeSearch)
                prevPage = clickedPage;
                console.log("Clicked Page: " + prevPage);
            }
        });

        $.ajax({
            url: "<?php echo BASE_URL; ?>/devicelist/getDeviceType", // Đường dẫn đến controller xử lý
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    let typeList;
                    response.data.map((type) => {
                        // if (type.id == response.data.loaithietbi_id) {
                        typeList += `<option value="${type.id}">${type.ten}</option>`
                        // } else {
                        // typeList += `<option value="${type.id}">${type.ten}</option>`
                        // }
                    })
                    $('#device-type').append(typeList)
                } else {}
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
        $('#device-type').change(function(e) {
            e.preventDefault();
            const type = $('#device-type').val();
            console.log(type);
            prevTypeSearch = type;
            prevPage = 0;
            getDeviceList(prevKeywordSearch, 0, type)
        })
        $('#addDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/addDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, // Không xử lý dữ liệu FormData
                contentType: false, // Không đặt tiêu đề Content-Type
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

        $('#editDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = new FormData(this);
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id, this);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/editDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                processData: false, // Không xử lý dữ liệu FormData
                contentType: false, // Không đặt tiêu đề Content-Type
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        console.log(12333);
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        console.log(12333);

                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        });

        $('#delDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log($('.delUser').serialize());
            var formData = $(this).serialize();
            var id = formData.split('=')[1];

            // var modalId = $(this).data('modal-id');
            // var id = $(this).find('input[name="id"]').val();
            console.log(1111, formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/deleteDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        console.log(1111, response);

                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalDel${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        console.log(1111, response);
                        // Hiển thị thông báo lỗi\
                        toastr.error(response.message);

                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
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
            getDeviceList(keyword, 0, prevTypeSearch)
        })

        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            console.log('edit', id);

            $.ajax({
                url: `<?php echo BASE_URL; ?>/devicelist/getDataModal?id=${id}`,
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    let typeList;
                    console.log(response.devicetype, '1');
                    response.devicetype.map((type) => {
                        if (type.id == response.data.loaithietbi_id) {
                            typeList += `<option value="${type.id}" selected>${type.ten}</option>`
                        } else {
                            typeList += `<option value="${type.id}">${type.ten}</option>`
                        }
                    })
                    $('#theloai').append(typeList);
                    $('#id-edit').val(response.data.id);
                    $('#device-name-edit').val(response.data.ten)
                    $('#device-quantity-edit').val(response.data.soluong)
                    $('#device-desc-edit').val(response.data.dactinhkithuat)
                    $('#device-status-edit').val(response.data.tinhtrang)
                    // $('#id-edit').val(response.id);
                }
            })
        });

        $(document).on('click', '.modal-del', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#del-device-name').text(response.data.ten);
                    $('#id-del').val(response.data.id);
                }
            })
        });

        $(document).on('click', '.modal-desc', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.data.dactinhkithuat);

                    $('#desc-device-view').text(response.data.ten);
                    $('#desc-device-detail').text(response.data.dactinhkithuat);
                    // $('#id-del').val(response.id);
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