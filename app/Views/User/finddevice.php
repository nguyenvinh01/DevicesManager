<div class="container-fluid px-4">
    <h1 class="mt-4">Tra cứu thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="flex-column col-8">
                <div class="input-group mb-3">
                    <!-- <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="hoten">Người dùng</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div> -->

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Tên thiết bị..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-primary col-2" type="submit" id="button-search">Tìm kiếm</button>
                    <div class="col-3 mx-3">
                        <select id="select-type" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Loại thiết bị</option>
                            <option value="">Tất cả</option>
                        </select>
                    </div>

                </div>
                <div class="">
                    <button type="button" class="btn btn-primary" id="borrow-all">
                        Mượn nhiều
                    </button>
                </div>
                <!-- <div class="col-16 d-flex flex-row">
                    <div class="form-group me-3">
                        <label for="startDate">Ngày bắt đầu:</label>
                        <input type="date" class="form-control" id="startDate" name="startDate">
                    </div>

                    <div class="form-group mx-3">
                        <label for="reset">Ngày kết thúc:</label>
                        <input type="date" class="form-control" id="endDate" name="endDate">
                    </div>

                    <div class="form-group">
                        <label for="endDate"></label>

                        <input type="button" class="form-control btn-primary" id="reset" name="reset" value="Reset">
                    </div>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th></th>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
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
        <!-- Modal Detail-->
        <div class="modal fade" id="ModalDesc" tabindex="-1" style="z-index: 1060 !important" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chi tiết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id-device-detail" name="id" value="<?php echo $arUser["id"] ?>">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label"><strong>Loại thiết bị:</strong></label>
                                    <p id="type-device-detail"></p>
                                    <label for="category-film" class="col-form-label"><strong>Mã thiết bị:</strong></label>
                                    <p id="code-device-detail"></p>
                                    <label for="category-film" class="col-form-label"><strong>Tên thiết bị:</strong></label>
                                    <p id="name-device-detail"></p>
                                    <!-- <label for="category-film" class="col-form-label"><strong>Tình trạng:</strong></label>
                                    <p id="status-device-detail"></p> -->
                                    <label for="category-film" class="col-form-label"><strong>Đặc tính kĩ thuật:</strong></label>
                                    <p id="desc-device-detail"></p>
                                </div>
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Ảnh:</label>
                                    <br>
                                    <img id="image-device-detail" style="width: 300px !important;height: 270px !important;" src="">
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
        <!-- Modal detail-->
        <!-- Modal \Multi-->
        <div class="modal fade" id="ModalBorrowMul" tabindex="-1" style="z-index: 1050 !important" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mượn thiết bị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="borrowMultiDevice">
                            <!-- <input type="hidden" class="form-control" id="id-device-borrow" name="id" value="<?php echo $arUser["id"] ?>"> -->
                            <div class="col">
                                <div class="row">
                                    <h2>Danh sách thiết bị mượn<i class="bi bi-trash3"></i></h2>
                                    <div class="col-12">
                                        <ul class="list-group" id="multi-device-desc">
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Địa điểm:</label>
                                        <select id="option-building" class="form-select col" aria-label="Default select example" name="toanha">
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
        <!-- Modal Multi-->
        <!-- Modal D-->
        <div class="modal fade" id="ModalBorrow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mượn thiết bị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="borrowDevice">
                            <input type="hidden" class="form-control" id="id-device-borrow" name="id">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Thiết bị:</label>
                                        <input type="text" class="form-control disabled" id="name-device-borrow" name="ten" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label"> Mã thiết bị:</label>
                                        <input type="text" class="form-control disabled" id="code-device-borrow" name="mathietbi" readonly>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Số lượng: </label>
                                        <input type="number" class="form-control disabled" id="quantity-device-borrow" name="soluong">
                                        <span id="quantity-device"></span>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Địa điểm:</label>
                                        <select id="option-building-borrow" class="form-select col" aria-label="Default select example" name="toanha">
                                        </select>
                                        <label for="category-film" class="col-form-label">Phòng:</label>
                                        <select id="option-room-borrow" class="form-select col" aria-label="Default select example" name="phong">
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
        <!-- Modal Update-->
    </div>
    <script>
        $(document).ready(function() {
            var column = table.column(0); // Cột thứ tư, lấy theo index (0-based)
            column.visible(!column.visible());
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut',
            };
            let prevKeywordSearch = '';
            let prevPage = 0;
            let prevType = '';
            let listBorrow = [];
            getDeviceList()
            let check = '<?php echo $_GET['cate'] ?>';
            if (!check) {
                $('#select-type').attr('style', 'display: none')
            }
            $(document).on('click', '#remove-item-multi', function(e) {
                e.preventDefault();
                console.log(123);
                var id = $(this).data('id');
                removeItem(id);
            });

            $('#borrow-all').click(function() {
                listBorrow = [];
                var checkboxes = document.querySelectorAll('input[name="item"]:checked');
                checkboxes.forEach((check) => {
                    if (!listBorrow.some((item) => item == check.value)) {
                        // listBorrow.append(check.value)
                        listBorrow = [...listBorrow, check.value];

                    }
                })
                console.log(listBorrow);
                if (listBorrow.length == 0) {

                    var column = table.column(0); // Cột thứ tư, lấy theo index (0-based)
                    column.visible(!column.visible());
                } else {
                    $('#ModalBorrowMul').modal('show')
                    console.log(1231123, listBorrow.length);
                    $.ajax({
                        url: "<?php echo BASE_URL; ?>/finddevice/getMultiDevice", // Đường dẫn đến controller xử lý
                        method: 'GET',
                        data: {
                            id: listBorrow
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response, 'list');
                            let list = '';
                            $('#multi-device-desc').html('')

                            response.data.forEach((device) => {
                                list += `
                                <a class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between modal-desc" data-id="${device.id}" onclick="$('#ModalDesc').modal('show')">
                                        <p class="mb-1" id="multi-device-code">${device.ten}</p>
                                        <p class="mb-1" id="multi-device-name">${device.mathietbi}</p>
                                    </div>
                                    <p class="fas fa-window-close" id="remove-item-multi" data-id="${device.id}"></p>
                                    </a>
                                `
                            })
                            $('#multi-device-desc').html(list)
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            })

            function removeItem(id) {
                listBorrow = listBorrow.filter((item) => item != id)
                console.log(listBorrow, 'new');
                if (listBorrow.length > 0) {

                    $.ajax({
                        url: "<?php echo BASE_URL; ?>/finddevice/getMultiDevice", // Đường dẫn đến controller xử lý
                        method: 'GET',
                        data: {
                            id: listBorrow
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response, 'list');
                            let list = '';
                            $('#multi-device-desc').html('')

                            response.data.forEach((device) => {
                                list += `
                                    <a class="list-group-item list-group-item-action" aria-current="true">
                                        <div class="d-flex w-100 justify-content-between modal-desc" data-id="${device.id}" onclick="$('#ModalDesc').modal('show')">
                                            <p class="mb-1" id="multi-device-code">${device.ten}</p>
                                            <p class="mb-1" id="multi-device-name">${device.mathietbi}</p>
                                        </div>
                                        <p class="fas fa-window-close" id="remove-item-multi" data-id="${device.id}"></p>
                                    </a>
                                    `
                            })
                            $('#multi-device-desc').html(list)
                            getDeviceList()
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#multi-device-desc').html('Không có thiết bị')
                    getDeviceList()

                }
            }

            function getDeviceList(keyword = '', page = 0, type = '') {
                let cate = '<?php echo $_GET['cate'] ?>'
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/getDeviceList", // Đường dẫn đến controller xử lý
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
                            let index = page * 5;
                            response.data.forEach((e) => {
                                index++
                                table.row.add([
                                    function() {
                                        return (listBorrow.some((list) => list == e.id) ?
                                            `
                                        <td>
                                        <input class="form-check-input" type="checkbox" name="item" value="${e.id}" checked>
                                        </td>
                                        ` : `
                                        <td>
                                        <input class="form-check-input" type="checkbox" name="item" value="${e.id}">
                                        </td>
                                        `)
                                    },
                                    index,
                                    e.ten,
                                    function() {
                                        return (`
                                        <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}"></td>
                                    `)
                                    },
                                    e.tenloai,
                                    e.trangthai,
                                    function() {
                                        return (
                                            `
                                    <td style="width : 130px !important">
                                        <button type="button" class="btn btn-warning modal-desc"  data-bs-toggle="modal" data-id="${e.id}" data-bs-target="#ModalDesc">
                                            Chi tiết
                                        </button>
                                        <button type="button" class="btn btn-primary modal-borrow" data-bs-toggle="modal" data-bs-target="#ModalBorrow"  data-id="${e.id}">
                                            Mượn
                                        </button>
                                    </td>
                                `
                                        )
                                    },
                                ])
                            });
                            table.draw();
                            if (listBorrow.length == 0) {

                                var column = table.column(0); // Cột thứ tư, lấy theo index (0-based)
                                column.visible(false);
                            }
                            let pagination = generatePagination(prevPage, Math.ceil((response.count / 5)), 5);
                            $('#pagination').html(pagination)
                            let location;
                            response.location.data.map(l => {
                                location += `<option value="${l.id_toanha}">${l.toanha}</option>`
                            })
                            $('#option-building').append(location)
                            $('#option-building-borrow').append(location)
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
                        getDeviceList(prevKeywordSearch, prevPage - 1, prevType)
                        prevPage = prevPage - 1;
                    }
                } else if (clickedPage === 'next') {
                    if (prevPage >= 0) {
                        console.log("Clicked Page: " + prevPage);
                        getDeviceList(prevKeywordSearch, prevPage + 1, prevType)
                        prevPage = prevPage + 1;
                    }
                } else {

                    getDeviceList(prevKeywordSearch, clickedPage, prevType)
                    prevPage = clickedPage;
                    console.log("Clicked Page: " + prevPage);
                }
            });
            $('#button-search').click((e) => {
                e.preventDefault();
                console.log('search');
                var keyword = $('#datatable-input').val();
                prevKeywordSearch = keyword;
                prevPage = 0;

                getDeviceList(prevKeywordSearch, 0, prevType)
            })

            $('#select-type').change(function(e) {
                e.preventDefault();

                const type = $('#select-type').val();
                prevType = type;
                prevPage = 0;
                getDeviceList(prevKeywordSearch, 0, type)

            })

            $.ajax({
                url: "<?php echo BASE_URL; ?>/finddevice/getDeviceType",
                method: "GET",
                data: {
                    cate: '<?php echo $_GET['cate']; ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        let typeList;
                        response.data.forEach((type) => {
                            typeList += `<option value="${type.maloai}">${type.ten}</option>`
                        })
                        $('#select-type').append(typeList)
                    } else {
                        // Hiển thị thông báo lỗi
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            })
            $('#borrowDevice').submit(function(e) {
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
                        console.log(response);
                        if (response.status == "success") {
                            // Hiển thị thông báo thành công
                            toastr.success(response.message);
                            var modalElement = document.getElementById(`ModalBorrow`);
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


            $('#borrowMultiDevice').submit(function(e) {
                e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
                // Gửi yêu cầu Ajax
                var formData = $(this).serialize();
                // formData.append('id', listBorrow)
                formData += `&id=${listBorrow}`
                console.log(formData);
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/borrowMultiDevice", // Đường dẫn đến controller xử lý
                    method: 'POST',
                    data: formData, // Dữ liệu gửi đi từ form
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == "success") {
                            // Hiển thị thông báo thành công
                            toastr.success(response.message);
                            var modalElement = document.getElementById(`ModalBorrowMul`);
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

            $(document).on('click', '.modal-desc', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/getDataModal",
                    method: "GET",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response, id, '123');

                        $('#id-device-detail').text(response.data.id);
                        $('#type-device-detail').text(response.data.loaitb);
                        $('#name-device-detail').text(response.data.ten);
                        $('#status-device-detail').text(response.data.trangthai);
                        $('#code-device-detail').text(response.data.mathietbi);
                        $('#image-device-detail').attr('src', `./uploads/image/${response.data.hinhanh}`);
                        $('#desc-device-detail').text(response.data.dactinhkithuat);
                        // $('#id-del').val(response.id);
                    }
                })
            });

            $(document).on('click', '.modal-borrow', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/getDataModal",
                    method: "GET",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#id-device-borrow').val(response.data.id);
                        $('#name-device-borrow').val(response.data.ten);
                        // $('#quantity-device-borrow').attr('max', response.data.soluong);
                        // $('#quantity-device').text(`Số lượng còn lại: ${response.data.soluong}`);
                        $('#code-device-borrow').val(response.data.mathietbi);

                    }
                })
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
                        console.log(response, 'room');
                        $('#option-room').empty();
                        $.each(response.data, (i, item) => {
                            $('#option-room').append($('<option>', {
                                value: item.phong,
                                text: item.phong
                            }))
                        })
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.error('error');
                    }
                })
            })
            $('#option-building-borrow').on('change', function(e) {
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/getRoom",
                    method: "GET",
                    data: {
                        id: e.target.value
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response, 'room');
                        $('#option-room-borrow').empty();
                        $.each(response.data, (i, item) => {
                            $('#option-room-borrow').append($('<option>', {
                                value: item.phong,
                                text: item.phong
                            }))
                        })
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.error('error');
                    }
                })
            })

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