<?php
if ($_SESSION['quyen'] == 1) {
    header("Location: dashboard");
}

?>
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
                    <button class="btn btn-success col-2" type="submit" id="button-search">Tìm kiếm</button>
                    <div class="col-3 mx-3">
                        <select id="select-type" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Loại thiết bị</option>
                            <option value="">Tất cả</option>
                        </select>
                    </div>

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

                        <input type="button" class="form-control btn-success" id="reset" name="reset" value="Reset">
                    </div>
                </div> -->
            </div>
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
                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

        </div>
        <!-- Modal Detail-->
        <div class="modal fade" id="ModalDesc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="category-film" class="col-form-label"><strong>Tên thiết bị:</strong></label>
                                    <p id="name-device-detail"></p>
                                    <label for="category-film" class="col-form-label"><strong>Tình trạng:</strong></label>
                                    <p id="status-device-detail"></p>
                                    <label for="category-film" class="col-form-label"><strong>Số lượng:</strong></label>
                                    <p id="quantity-device-detail"></p>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Ảnh:</label>
                                        <br>
                                        <img id="image-device-detail" style="width: 300px !important;height: 270px !important;" src="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label"><strong>Đặc tính kĩ thuật:</strong></label>
                                        <p id="desc-device-detail"></p>
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
            <!-- Modal Update-->
            <!-- Modal D-->

        </div>
        <div class="modal fade" id="ModalBorrow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mượn thiết bị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" class="borrowDevice">
                            <input type="hidden" class="form-control" id="id-device-borrow" name="id" value="<?php echo $arUser["id"] ?>">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Thiết bị:</label>
                                        <input type="text" class="form-control disabled" id="name-device-borrow" value="<?php echo $arUser["ten"] ?>" name="ten" readonly>
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
        <!-- Modal Update-->
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
            let prevKeywordSearch = '';
            let prevPage = 0;
            let prevType = '';
            getDeviceList()

            function getDeviceList(keyword = '', page = 0, type = '') {
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/finddevice/getDeviceList", // Đường dẫn đến controller xử lý
                    method: 'GET',
                    data: {
                        keyword: keyword,
                        page: page,
                        type: type,
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
                                    index,
                                    e.ten,
                                    function() {
                                        return (`
                            <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}"></td>
                                    `)
                                    },
                                    e.tenloai,
                                    e.tinhtrang,
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
                            if (prevPage == Math.floor((response.count / itemPerPage))) {
                                console.log(response.count / itemPerPage, 'dis');
                                pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                            } else {
                                console.log(response.count / itemPerPage);

                                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                            }
                            $('#pagination').html(pagination)
                            let location;
                            response.location.data.map(l => {
                                location += `<option value="${l.id_toanha}">${l.toanha}</option>`
                            })
                            $('#option-building').append(location)
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
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        let typeList;
                        response.data.forEach((type) => {
                            typeList += `<option value="${type.id}">${type.ten}</option>`
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
                        console.log(response);
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
                        $('#status-device-detail').text(response.data.tinhtrang);
                        $('#quantity-device-detail').text(response.data.soluong);
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