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
                            <!-- <option value="">Loại thiết bị</option> -->
                        </select>

                    </div>
                </div>
            </div>
            <!-- <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                    Thêm mới
                </button>
            </div> -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Thao tác
                </button>
                <div class="dropdown-menu">
                    <button type="button" class="btn btn-success dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                        Thêm mới
                    </button>
                    <button class="btn btn-success dropdown-item" id="btn-export">
                        Export
                    </button>
                    <!-- <button class="btn btn-success dropdown-item" id="btn-export" data-bs-toggle="modal" data-bs-target="#exampleModalImport">
                        Import
                    </button> -->
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Mã thiết bị</th>
                        <th>Chi tiết</th>
                        <th>Loại thiết bị</th>
                        <th>Trạng thái</th>
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
                            <input type="hidden" class="form-control" id="id-edit" name="id">
                            <div class="col">
                                <div class="row">

                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <input type="hidden" name="size" value="1000000">
                                        <input type="file" class="form-control" name="image" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                        <select class="form-select cate-add" aria-label="Default select example" id="danhmuc-edit" tabindex="8" name="categories" required>
                                            <option value="" selected>Chọn danh mục thiết bị</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                        <select class="form-select type-add" aria-label="Default select example" id="theloai-edit" tabindex="8" name="ltb" required>
                                            <option value="" selected>Chọn loại thiết bị</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                        <input type="text" class="form-control" id="device-name-edit" name="ten" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <!-- <input type="text" class="form-control" id="device-status-edit" name="trangthai" required> -->
                                        <select class="form-select type-add" aria-label="Default select example" id="device-status-edit" tabindex="8" name="trangthai" required>
                                            <option value="" selected>Chọn trạng thái</option>
                                            <option value="Sẵn Sàng">Sẵn Sàng</option>
                                            <option value="Thất lạc">Thất lạc</option>
                                            <option value="Hỏng">Hỏng</option>
                                            <option value="Chờ sửa chữa">Chờ sửa chữa</option>
                                            <!-- <option value="Đang cấp phát">Đang cấp phát</option>
                                            <option value="Đang mượn">Đang mượn</option> -->
                                            <!-- <option value="Đang mượn">Đang mượn</option> -->
                                        </select>
                                    </div>
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
        <!-- End Edit -->


        <!-- Start duplicate -->
        <div class="modal fade" id="ModalDuplicate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sao chép</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="duplicateDevice">
                            <input type="hidden" class="form-control" id="id-dup" name="id">
                            <div class="col">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <input type="hidden" name="size" value="1000000">
                                        <input type="file" class="form-control" name="image" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                        <select class="form-select cate-add" aria-label="Default select example" id="danhmuc-dup" tabindex="8" name="categories" required>
                                            <option value="" selected>Chọn danh mục thiết bị</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                        <select class="form-select type-add" aria-label="Default select example" id="theloai-dup" tabindex="8" name="ltb" required>
                                            <option value="" selected>Chọn loại thiết bị</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                        <input type="text" class="form-control" id="device-name-dup" name="ten" required>
                                    </div>
                                    <!-- <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <input type="text" class="form-control" id="device-status-dup" name="tinhtrang" required>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                        <textarea name="dtkt" class="form-control" id="device-desc-dup" cols="30" tabindex="8" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="editma">Tạo</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End duplicate -->
        <!--Des-->
        <div class="modal fade" id="ModalDes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="desc-device-view"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <img alt="Thiet bi" id="device-image-desc" style="width: 200px !important;height: 100px !important;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                    <input type="text" class="form-control" id="device-name-desc" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Tình trạng:</label>
                                    <input type="text" class="form-control" id="device-status-desc" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Mã thiết bị: </label>
                                    <input type="text" class="form-control" id="device-code-desc" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="category-film" class="col-form-label">Đặc tính kĩ thuật:</label>
                                    <textarea name="dtkt" class="form-control" disabled id="device-desc-desc" cols="30" tabindex="8" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
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
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <input type="hidden" name="size" value="1000000">
                                        <input type="file" class="form-control" name="image" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                        <select class="form-select cate-add" aria-label="Default select example" tabindex="8" name="categories" id="danhmuc-add" required>
                                            <option value="" selected>Chọn danh mục thiết bị</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                        <select class="form-select type-add" aria-label="Default select example" tabindex="8" name="ltb" id="theloai-add" required>
                                            <option value="" selected>Chọn loại thiết bị</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tên thiết bị:</label>
                                        <input type="text" class="form-control" id="category-film" name="ten" required>
                                    </div>
                                    <!-- <div class="col-6">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <input type="text" class="form-control" id="category-film" name="tinhtrang" required>
                                    </div> -->
                                </div>
                                <div class="row">
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
        let selectedRowsData = [];

        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevTypeSearch = '';
        let check = '<?php echo $_GET['cate'] ?>';
        if (!check) {
            $('#device-type').attr('style', 'display: none')
        }

        function getDeviceList(keyword = '', page = 0, type = '') {
            let cate = '<?php echo $_GET['cate'] ?>'
            $.ajax({
                url: `<?php echo BASE_URL; ?>/devicelist/getDeviceList`, // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    type: type,
                    cate: cate
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
                                e.mathietbi,
                                // function() {
                                //     return (`
                                //     <td> 
                                //     <!-- <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}?>"> -->
                                //     </td>
                                //     `)
                                // },
                                // e.soluong,
                                // e.dactinhkithuat,
                                function() {
                                    return (`
                                    <td>
                                        <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalDes">
                                    Xem</a>
                                    </td>                                    `)
                                },
                                e.tenloai,
                                e.trangthai,
                                // e.tinhtrang,
                                function() {
                                    return (
                                        `
                                    <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-edit dropdown-item"  data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalEdit">
                                                    Sửa thông tin
                                                </button>
                                                <button type="button" class="btn btn-danger modal-del dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalDel"  data-id="${e.id}">
                                                Xóa thiết bị
                                                </button>
                                                <button type="button" class="btn btn-danger modal-dup dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalDuplicate"  data-id="${e.id}">
                                                Sao chép
                                                </button>
                                            </ul>
                                        </div>
                                    </td>
                                        `
                                    )
                                },
                            ])
                        });
                        table.draw();
                        $('.cate-add').each(function() {
                            let cateAdd = `<option value="">Chọn Danh mục</option>`;
                            response.categories.data.map((cate) => {
                                cateAdd += `<option value="${cate.madanhmuc}">${cate.tendanhmuc}</option>`;
                            });
                            $(this).html(cateAdd);
                        });

                        let pagination = ""
                        let itemPerPage = 5;
                        if (prevPage == 0) {
                            pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        } else {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        }
                        for (let i = 0; i < (response.count / itemPerPage); i++) {
                            if (i == prevPage) {
                                pagination += `<li class="page-item disabled"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                            } else {
                                pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                            }
                        }
                        console.log(Math.floor((response.count / itemPerPage)) - 1, 'page');
                        if (prevPage == Math.floor((response.count / itemPerPage))) {
                            console.log(response.count / itemPerPage, 'dis');
                            pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        } else {
                            console.log(response.count / itemPerPage);

                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        }
                        $('#pagination').html(pagination)
                        prevTypeSearch = type;
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
        $('#btn-export').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/exportExcel",
                data: {
                    keyword: prevKeywordSearch,
                    type: prevTypeSearch,
                    cate: '<?php echo $_GET['cate'] ?>'
                },
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
        $('.cate-add').change(function() {
            let cate = $(this).val();
            console.log(cate, '123');
            console.log(cate, '123');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/getDeviceType", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    cate: cate
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        let typeList;
                        $('.type-add').html('')
                        $('.type-add').each(function() {
                            let typeAdd = `<option value="">Chọn loại thiết bị</option>`;
                            response.data.map((type) => {
                                // if (type.id == response.data.loaithietbi_id) {
                                //     typeAdd += `<option value="${type.id}" selected>${type.ten}</option>`
                                // } else {
                                typeAdd += `<option value="${type.maloai}">${type.ten}</option>`
                                // }
                            })
                            $(this).append(typeAdd)
                        })
                        // $('#device-type').append(typeList)
                    } else {}
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        })
        $.ajax({
            url: "<?php echo BASE_URL; ?>/devicelist/getDeviceType", // Đường dẫn đến controller xử lý
            method: 'GET',
            data: {
                cate: '<?php echo $_GET['cate'] ?>'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    let typeList;
                    typeList += `<option value="" hidden>Loại thiết bị</option>`
                    response.data.map((type) => {
                        typeList += `<option value="${type.maloai}">${type.ten}</option>`

                    })
                    $('#device-type').append(typeList)
                } else {}
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
        $('#device-type').change(function(e) {
            // e.preventDefault();
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
            formData.append('cate', '<?php echo $_GET['cate'] ?>')
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
        $('#duplicateDevice').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = new FormData(this);
            // formData.append('cate', '<?php echo $_GET['cate'] ?>')
            console.log(formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/devicelist/duplicateDevice", // Đường dẫn đến controller xử lý
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

        $(document).on('click', '.modal-dup', function() {
            var id = $(this).data('id');
            console.log('dup', id);

            $.ajax({
                url: `<?php echo BASE_URL; ?>/devicelist/getDataModal`,
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    let typeList;
                    let cateList;
                    console.log(response, 1);
                    $('#theloai-dup').html('')
                    $('#danhmuc-dup').html('')
                    response.cate.map((type) => {
                        if (type.madanhmuc == response.data.madanhmuc) {
                            cateList += `<option value="${type.madanhmuc}" selected>${type.tendanhmuc}</option>`
                        } else {
                            cateList += `<option value="${type.madanhmuc}">${type.tendanhmuc}</option>`
                        }
                    })
                    $('#danhmuc-dup').append(cateList);

                    response.devicetype.map((type) => {
                        if (type.maloai == response.data.loaithietbi_code) {
                            typeList += `<option value="${type.maloai}" selected>${type.ten}</option>`
                        } else {
                            typeList += `<option value="${type.maloai}">${type.ten}</option>`
                        }
                    })
                    $('#theloai-dup').append(typeList);
                    $('#id-dup').val(response.data.id);
                    $('#device-name-dup').val(response.data.ten)
                    $('#device-desc-dup').val(response.data.dactinhkithuat)
                    $('#device-status-dup').val(response.data.trangthai)
                    // $('#id-edit').val(response.id);
                }
            })
        });
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            console.log('edit', id);

            $.ajax({
                url: `<?php echo BASE_URL; ?>/devicelist/getDataModal`,
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    let typeList;
                    let cateList;
                    console.log(response, 1);
                    $('#theloai-edit').html('')
                    $('#danhmuc-edit').html('')
                    response.cate.map((type) => {
                        if (type.madanhmuc == response.data.madanhmuc) {
                            cateList += `<option value="${type.madanhmuc}" selected>${type.tendanhmuc}</option>`
                        } else {
                            cateList += `<option value="${type.madanhmuc}">${type.tendanhmuc}</option>`
                        }
                    })
                    $('#danhmuc-edit').append(cateList);

                    response.devicetype.map((type) => {
                        if (type.maloai == response.data.loaithietbi_code) {
                            typeList += `<option value="${type.maloai}" selected>${type.ten}</option>`
                        } else {
                            typeList += `<option value="${type.maloai}">${type.ten}</option>`
                        }
                    })
                    $('#theloai-edit').append(typeList);
                    $('#theloai').append(typeList);
                    $('#id-edit').val(response.data.id);
                    $('#device-name-edit').val(response.data.ten)
                    $('#device-desc-edit').val(response.data.dactinhkithuat)
                    // $('#device-status-edit').val(response.data.trangthai)
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
                    $('#device-name-desc').val(response.data.ten)
                    $('#device-code-desc').val(response.data.mathietbi)
                    $('#device-desc-desc').val(response.data.dactinhkithuat)
                    $('#device-status-desc').val(response.data.trangthai)
                    $('#device-image-desc').attr("src", "./uploads/image/" + response.data.hinhanh)
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