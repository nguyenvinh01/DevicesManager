<?php
if ($_SESSION['quyen'] == 2) {
    header("Location: dashboard");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử mượn trả</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="flex-column col-8">
                <div class="input-group mb-3">
                    <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="hoten">Người dùng</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div>

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-3 mx-3">
                        <select id="select-status" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Trạng thái</option>
                            <option value="">Tất cả</option>
                            <!-- <option value="1">Admin</option> -->
                            <option value="Đang mượn">Đang mượn</option>
                            <option value="Chờ phê duyệt">Chờ phê duyệt</option>
                            <option value="Đã trả">Đã trả</option>
                            <option value="Đã phê duyệt">Đã phê duyệt</option>
                            <option value="Bị từ chối">Bị từ chối</option>
                            <option value="Quá hạn">Quá hạn</option>
                            <!-- <option value="3">Nhân viên</option> -->
                        </select>
                    </div>

                </div>
                <div class="col-16 d-flex flex-row">
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
                    <div class="form-group ms-3">
                        <label for="btn-export"></label>
                        <!-- <button class="btn btn-success" id="btn-export">
                            Export
                        </button> -->
                        <input type="button" class="form-control btn-success" id="btn-export" name="reset" value="Export">

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Người dùng</th>
                        <!-- <th>Tên thiết bị</th> -->
                        <th>Mã đơn mượn</th>
                        <!-- <th>Số lượng</th> -->
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Địa điểm</th>
                        <!-- <th>Tình trạng</th> -->
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

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
                            <input type="hidden" class="form-control" id="id-update" name="id">
                            <input type="hidden" class="form-control" id="id-device" name="thietbiid">
                            <!-- <input type="hidden" class="form-control" id="id-quantity" name="soluong"> -->
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Tình trạng:</label>
                                        <select class="form-select" aria-label="Default select example" id="select-status-edit" tabindex="8" name="tinhtrang" required>
                                            <option value="" selected>Chọn tình trạng</option>
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


        <!-- Desc device -->

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
                                    <label for="category-film" class="col-form-label">Mã thiết bị:</label>
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
        <!-- Desc -->
        <!-- Desc borrow -->

        <div class="modal fade" id="ModalDescBorrow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="desc-borrow-view">Danh sách thiết bị mượn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="updateStatusBorrow">
                            <div class="col">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="id-borrow" name="borrow-id">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mã thiết bị</th>
                                                <th>Tên thiết bị</th>
                                                <th>Trạng thái</th>
                                                <!-- <th>Thao tác</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="table-borrow-detail">
                                        </tbody>
                                    </table>
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
        <!-- Desc Borrow -->
    </div>
</div>
<script>
    $(document).ready(() => {
        let prevOptionSearch = '';
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevStatus = '';
        let startDate = '';
        let endDate = '';
        let prevFilter = '';
        $.ajax({
            url: "<?php echo BASE_URL; ?>/borrowdevice/autoUpdateStatus", // Đường dẫn đến controller xử lý
            method: 'POST',
            // data: formData, // Dữ liệu gửi đi từ form
            dataType: 'json',
            success: function(response) {
                console.log('update status');
                // if (response.status == "success") {
                //     // Hiển thị thông báo thành công
                //     // toastr.success(response.message);
                // } else {
                //     // Hiển thị thông báo lỗi
                //     // toastr.error(response.message);
                // }
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.error(error);
            }
        });
        getBorrowDeviceList()

        function getBorrowDeviceList(keyword = '', page = 0, sDate = '', eDate = '', status = '', filter = '') {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/getBorrowDeviceList", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    status: status,
                    eDate: eDate,
                    sDate: sDate,
                    filter: filter
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        let userTable = '';
                        table.clear();
                        let index = page * 5;
                        response.data.forEach((e) => {
                            index++;
                            table.row.add([
                                index,
                                e.hoten,
                                // function() {
                                //     return (`
                                //     <td>
                                //     <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.thietbi_id}" data-bs-target="#ModalDes">
                                //     ${e.ten}</a>
                                //     </td>                                    `)
                                // },
                                e.madonmuon,
                                // e.soluong,
                                // function() {
                                //     return (`
                                //     <td> <img style="width: 300px !important;height: 200px !important;" src="./uploads/image/${e.hinhanh}?>"></td>
                                //     `)
                                // },
                                convertDateFormat(e.ngaymuon),
                                convertDateFormat(e.ngaytra),
                                // e.dactinhkithuat,
                                e.diadiem,
                                // e.trangthai,
                                function() {
                                    // return (e.trangthai == "Đã trả" || e.trangthai == "Từ chối yêu cầu" || e.trangthai == "Quá hạn" ? '' :
                                    return (`
                                    <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-desc-borrow dropdown-item" data-bs-toggle="modal" data-id=${e.madonmuon} data-bs-target="#ModalDescBorrow">
                                                    Cập nhật trạng thái
                                                </button>  
                                            </ul>
                                        </div>
                                    </td>
                                `)
                                },
                            ])
                        });
                        table.draw();

                        let pagination = "";
                        let itemPerPage = 5; // Số lượng trang hiển thị trên một dãy phân trang
                        let totalPages = Math.ceil(response.count / itemPerPage); // Tính tổng số trang

                        // Tạo nút "Previous"
                        if (prevPage == 0) {
                            pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        } else {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        }

                        // Tạo dãy các trang
                        if (totalPages <= 3) {
                            // Nếu có ít hơn hoặc bằng 3 trang, hiển thị tất cả trang
                            for (let i = 0; i < totalPages; i++) {
                                if (i == prevPage) {
                                    pagination += `<li class="page-item disabled"><a class="page-link" href="#" data-page=${i}>${i + 1}</a></li>`;
                                } else {
                                    pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${i}>${i + 1}</a></li>`;
                                }
                            }
                        } else {
                            // Nếu có nhiều hơn 3 trang, hiển thị ba trang trước và sau trang hiện tại
                            let startPage = Math.max(prevPage - 1, 0); // Trang đầu tiên
                            let endPage = Math.min(prevPage + 1, totalPages - 1); // Trang cuối cùng

                            if (startPage > 0) {
                                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="0">1</a></li>';
                                if (startPage > 1) {
                                    pagination += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                }
                            }

                            for (let i = startPage; i <= endPage; i++) {
                                if (i == prevPage) {
                                    pagination += `<li class="page-item disabled"><a class="page-link" href="#" data-page=${i}>${i + 1}</a></li>`;
                                } else {
                                    pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${i}>${i + 1}</a></li>`;
                                }
                            }

                            if (endPage < totalPages - 1) {
                                if (endPage < totalPages - 2) {
                                    pagination += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                }
                                pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${totalPages - 1}>${totalPages}</a></li>`;
                            }
                        }

                        // Tạo nút "Next"
                        if (prevPage == totalPages - 1) {
                            pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        } else {
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        }

                        $('#pagination').html(pagination);

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
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var clickedPage = $(this).data('page');
            console.log('page');
            if (clickedPage === 'previous') {
                if (prevPage > 0) {
                    console.log("Clicked Page: " + prevPage);
                    getBorrowDeviceList(prevKeywordSearch, prevPage - 1, startDate, endDate, prevStatus, prevFilter)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getBorrowDeviceList(prevKeywordSearch, prevPage + 1, startDate, endDate, prevStatus, prevFilter)
                    prevPage = prevPage + 1;
                }
            } else {

                getBorrowDeviceList(prevKeywordSearch, clickedPage, startDate, endDate, prevStatus, prevFilter)
                prevPage = clickedPage;
                console.log("Clicked Page: " + prevPage);
            }
        });
        $('#btn-export').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/exportExcel",
                data: {
                    keyword: prevKeywordSearch,
                    status: prevStatus,
                    eDate: endDate,
                    sDate: startDate,
                    filter: prevFilter
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
        $('#button-search').click((e) => {
            e.preventDefault();
            console.log('search');
            var keyword = $('#datatable-input').val();
            prevKeywordSearch = keyword;
            prevPage = 0;
            var filter = $('#optionSelect').val();
            prevFilter = filter;
            // if (option != prevOptionSearch || keyword != prevKeywordSearch) {
            //     prevKeywordSearch = keyword;
            //     prevOptionSearch = option;
            // }l
            console.log(startDate, endDate);
            getBorrowDeviceList(prevKeywordSearch, 0, startDate, endDate, prevStatus, prevFilter)
        })
        $('#reset').click((e) => {
            e.preventDefault();
            $("#endDate").val('');
            $("#startDate").val('');
            startDate = '';
            endDate = '';
            // if (option != prevOptionSearch || keyword != prevKeywordSearch) {
            //     prevKeywordSearch = keyword;
            //     prevOptionSearch = option;
            // }l
            getBorrowDeviceList(prevKeywordSearch, 0, startDate, endDate, prevStatus, prevFilter)
        })
        $('#select-status').change(function(e) {
            e.preventDefault();

            const status = $('#select-status').val();
            prevStatus = status;
            prevPage = 0;
            getBorrowDeviceList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), status, prevFilter)

        })
        $("#startDate").on("change", function() {
            var sDate = new Date($(this).val());
            var eDate = new Date(sDate);
            eDate.setMonth(eDate.getMonth() + 1);

            startDate = convertInputDate(sDate);

            endDate = convertInputDate(eDate);
            $("#endDate").val(endDate);
        });

        function convertInputDate(date) {
            const inputDate = new Date(date);

            // Get year, month, and day from the Date object
            const year = inputDate.getFullYear();
            const month = String(inputDate.getMonth() + 1).padStart(2, '0');
            const day = String(inputDate.getDate()).padStart(2, '0');

            // Format the date in "yyyy-mm-dd" format
            return `${year}-${month}-${day}`;
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
                        var modalElement = document.getElementById(`ModalEdit${id}`);
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

                    $('#select-status-edit').html('');
                    $('#select-status-edit').append(`<option value="" selected>Chọn tình trạng</option>`)

                    let option;
                    if (response.data[0].trangthai == "Chờ phê duyệt") {
                        option += `<option value = "Đã phê duyệt"> Phê duyệt yêu cầu </option> 
                        <option value = "Từ chối yêu cầu"> Từ chối yêu cầu </option>`
                    } else if (response.data[0].trangthai == "Đã phê duyệt") {
                        option += `<option value = "Đang mượn" > Đang mượn </option>`
                    } else {
                        option += `<option value = "Đã trả">Đã trả </option>`
                        option += `<option value = "Trả Thiếu">Trả Thiếu </option>`
                        option += `<option value = "Làm mất">Làm mất </option>`
                    }
                    $('#select-status-edit').append(option)
                    $('#id-update').val(response.data[0].id);
                    $('#id-device').val(response.data[0].thietbi_id);
                    $('#id-quantity').val(response.data[0].soluong);


                }
            })
        });
        $(document).on('click', '.modal-desc', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/getDataModal",
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
                    $('#device-status-desc').val(response.data.tinhtrang)
                    $('#device-image-desc').attr("src", "./uploads/image/" + response.data.hinhanh)
                    // $('#id-del').val(response.id);
                }
            })
        });
        $('#updateStatusBorrow').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            // var formData = $(this).serializeJSON();
            // var formData = new FormData(this);

            var id = $(this).serialize().split(/[=,&]/)[1];
            const params = new URLSearchParams(formData);

            const paramsArray = [];

            params.forEach((value, key) => {
                paramsArray.push({
                    key,
                    value
                });
            });
            paramsArray.shift()
            console.log(paramsArray, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/updateBorrowStatus", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: {
                    id: id,
                    status: paramsArray
                }, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalDescBorrow`);
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
        $(document).on('click', '.modal-desc-borrow', function() {
            var id = $(this).data('id');
            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowdevice/getBorrowDetail",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, 123);
                    $('#table-borrow-detail').html('')
                    let list;
                    // Tạo danh sách select và tùy chọn trước vòng lặp
                    const selects = [];
                    const options = {};

                    // Tạo danh sách các tùy chọn cho mỗi trạng thái
                    options['Chờ phê duyệt'] = `
                            <option value="Đã phê duyệt">Phê duyệt yêu cầu</option>
                            <option value="Từ chối yêu cầu">Từ chối yêu cầu</option>
                        `;

                    options['Đã phê duyệt'] = `<option value="Đang mượn">Đang mượn</option>`;

                    options['Đang mượn'] = `
                    <option value="Đã trả">Đã trả</option>
                    <option value="Thất lạc">Thất lạc</option>
                    <option value="Sửa chữa">Sửa chữa</option>
                    `;
                    options['Quá hạn'] = `
                    <option value="Đã trả">Đã trả</option>
                    <option value="Thất lạc">Thất lạc</option>
                    <option value="Sửa chữa">Sửa chữa</option>
                    `;
                    //    options['Khác'] = `<option value="Đã trả">Đã trả</option>
                    //    <option value="Trả thiếu">Trả thiếu</option>
                    //    <option value="Làm mất">Làm mất</option>`;
                    let index = 1;
                    const statusBorrow = ['Đã trả', 'Thất lạc', 'Chờ sửa chữa', 'Từ chối yêu cầu']
                    response.data.forEach((borrow) => {
                        const selectId = `select-status-borrow-${borrow.id}`;
                        const selectHtml = `
                        <select class="form-select" aria-label="Default select example" id="${selectId}" tabindex="8" name="${borrow.mathietbi}" required>
                            <option value="${borrow.trangthai}" selected hidden>${borrow.trangthai}</option>
                            ${options[`${borrow.trangthai}`]}
                        </select>
                    `;
                        selects.push({
                            id: selectId,
                            trangthai: borrow.trangthai
                        });
                        list += `
                        <tr>
                            <td>${index}</td>
                            <td>${borrow.mathietbi}</td>
                            <td>${borrow.ten}</td>
                            <td>${statusBorrow.some((e) => borrow.trangthai == e) ? borrow.trangthai : selectHtml}</td>
                        </tr>
                            `
                        index++;
                    })

                    $('#table-borrow-detail').html(list)
                    $('#id-borrow').val(response.data[0].madonmuon)
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