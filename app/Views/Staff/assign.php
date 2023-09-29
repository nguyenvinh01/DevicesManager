<div class="container-fluid px-4">

    <h1 class="mt-4">Danh sách thiết bị kiểm tra</h1>
    <div class="card mb-4">

        <div class="card-header">
            <div class="col-18 mb-3">
                <div class="input-group mb-3">
                    <!-- <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="nguoisuachua">Người sửa chữa</option>
                            <option value="nguoigui">Người gửi</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div> -->
                    <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="hoten">Người sửa chữa</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div>
                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-2 mx-3">
                        <select id="select-status" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Trạng thái</option>
                            <option value="">Tất cả</option>
                            <option value="Chờ xử lý">Chờ xử lý</option>
                            <option value="Đang kiểm tra">Đang kiểm tra</option>
                            <option value="Đang kiểm tra">Đang kiểm tra</option>
                            <option value="Cần sửa chữa">Cần sửa chữa</option>
                            <option value="Đang sửa chữa">Đang sửa chữa</option>
                            <option value="Hoàn thành">Hoàn thành</option>
                        </select>
                    </div>
                    <div class="col-2 mx-3">
                        <select id="select-department" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Phòng ban</option>
                            <option value="">Tất cả</option>
                            <!-- <option value="1">Admin</option> -->
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
                </div>
            </div>
            <!-- <button type="button" class="btn btn-success" id="add-button" data-bs-toggle="modal" data-bs-target="#ModalAdd">
                Thêm mới
            </button> -->
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Mã đơn cấp phát</th>
                        <!-- <th>Số lượng</th> -->
                        <!-- <th>Người kiểm tra</th> -->
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

            <ul class="pagination justify-content-end mt-3" id="pagination">

        </div>
        <!-- Modal Update-->
        <!-- <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        </div> -->
        <!--End Modal Update-->
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
                                    <label for="category-film" class="col-form-label">Số lượng:</label>
                                    <input type="text" class="form-control" id="device-quantity-desc" disabled>
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
        <!-- Desc Assign -->

        <div class="modal fade" id="ModalDescAssign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="desc-borrow-view">Danh sách thiết bị mượn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="updateStatusAssign">
                            <div class="col">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="id-assign" name="borrow-id">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mã thiết bị</th>
                                                <th>Tên thiết bị</th>
                                                <th>Tình trạng</th>
                                                <!-- <th>Thao tác</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="table-assign-detail">
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
        <!-- Desc Assign -->
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
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevDepartment = '';
        let prevStatus = '';
        let startDate = '';
        let endDate = '';
        let prevFilter = '';
        getAssignList();
        $.ajax({
            url: `<?php echo BASE_URL; ?>/assign/getDepartment`,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(123, response);
                if (response.status == "success") {
                    let listDepartment;
                    response.data.forEach((d) => {
                        listDepartment += `<option value="${d.id}">${d.tenpb}</option>`
                    })
                    $('#select-department').append(listDepartment)
                } else {
                    toastr.error(123);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        function getAssignList(keyword = '', page = 0, sDate = '', eDate = '', department = '', filter = '', status = '') {
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getAssignList`,
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    department: department,
                    eDate: eDate,
                    sDate: sDate,
                    filter: filter,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response, 11);
                        let userTable = '';
                        table.clear();
                        let index = page * 10;
                        response.data.forEach((e) => {
                            index++
                            table.row.add([
                                index,
                                // e.ten_thietbi,
                                // function() {
                                //     return (`
                                //     <td>
                                //         <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.tentb}" data-bs-target="#ModalDes">
                                //     ${e.ten_thietbi}</a>
                                //     </td>                                    `)
                                // },
                                e.madoncapphat,
                                // e.soluong,
                                // e.ten_nv,
                                e.ngaykiemtra,
                                e.ten_phongban,
                                e.ten_toanha + "-" + e.ten_diadiem,
                                e.tinhtrang,
                                function() {
                                    return (
                                        e.tinhtrang == "Đã xử lý" ? "" : `
                                        <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-desc-assign dropdown-item" data-id="${e.madoncapphat}" data-bs-toggle="modal" data-bs-target="#ModalDescAssign">
                                                Chi tiết
                                                </button>
                                            </ul>
                                        </div>
                                    </td>
                                    `)
                                    // <td style="width : 130px !important">
                                    // <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                    //     Kiểm tra
                                    // </button>
                                    // </td>
                                },
                            ])
                        });
                        table.draw();
                        let pagination = ""
                        let itemPerPage = 15;
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
                    } else {
                        toastr.error(response.message);
                    }
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
                    getAssignList(prevKeywordSearch, prevPage - 1, startDate, endDate, prevDepartment, prevFilter, prevStatus)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getAssignList(prevKeywordSearch, prevPage + 1, startDate, endDate, prevDepartment, prevFilter, prevStatus)
                    prevPage = prevPage + 1;
                }
            } else {

                getAssignList(prevKeywordSearch, clickedPage, startDate, endDate, prevDepartment, prevFilter, prevStatus)
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
            var filter = $('#optionSelect').val();
            prevFilter = filter;
            // if (option != prevOptionSearch || keyword != prevKeywordSearch) {
            //     prevKeywordSearch = keyword;
            //     prevOptionSearch = option;
            // }l
            console.log(startDate, endDate);
            getAssignList(prevKeywordSearch, 0, startDate, endDate, prevDepartment, prevFilter, prevStatus)
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
            getAssignList(prevKeywordSearch, 0, startDate, endDate, prevDepartment, prevFilter, prevStatus)
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

        $('#select-department').change(function(e) {
            e.preventDefault();

            const department = $('#select-department').val();
            prevDepartment = department;
            prevPage = 0;
            getAssignList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), prevDepartment, prevFilter, prevStatus)

        })
        $('#select-status').change(function(e) {
            e.preventDefault();

            const status = $('#select-status').val();
            prevStatus = status;
            prevPage = 0;
            getAssignList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), prevDepartment, prevFilter, prevStatus)
        })

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


        $('#updateStatusAssign').submit(function(e) {
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
                console.log(value, key);
            });
            paramsArray.shift()
            console.log(paramsArray, params, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/updateAssignStatus", // Đường dẫn đến controller xử lý
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
                        var modalElement = document.getElementById(`ModalDescAssign`);
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
        $(document).on('click', '.modal-desc-assign', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            let staffList;
            console.log('modaledit', id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getAssignDetail", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    idCapPhat: id
                }, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        let index = 1;
                        let list;
                        const statusAssign = ['Hoàn thành']

                        response.data.forEach((assign) => {
                            const options = {};

                            // Tạo danh sách các tùy chọn cho mỗi trạng thái
                            options['Chờ xử lý'] = `
                            <option value="Đang kiểm tra">Đang kiểm tra</option>
                                `;

                            options['Đang kiểm tra'] = `<option value="Cần sửa chữa">Cần sửa chữa</option>
                            <option value="Thất lạc">Thất lạc</option>
                            <option value="Hoàn thành">Hoàn thành</option>`;

                            options['Cần sửa chữa'] = `
                            <option value="Đang sửa chữa">Đang sửa chữa</option>
                            `;
                            options['Đang sửa chữa'] = `
                            <option value="Hoàn thành">Hoàn thành</option>
                            `;
                            const selectId = `select-status-assign-${assign.id}`;

                            const selectHtml = `
                            <select class="form-select" aria-label="Default select example" id="${selectId}" tabindex="8" name="${assign.id_thietbi}" required>
                                <option value="${assign.trangthai}" selected hidden>${assign.trangthai}</option>
                                ${options[`${assign.trangthai}`]}
                            </select>
                        `;
                            list += `
                            <tr>
                                <td>${index}</td>
                                <td>${assign.mathietbi}</td>
                                <td>${assign.ten_thietbi}</td>
                                <td>${selectHtml}</td>
                            </tr>
                            `
                            index++;
                        })
                        $('#table-assign-detail').html(list)
                        $('#id-assign').val(response.data[0].madoncapphat)

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
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
                        staffList += `<option value="Thất lạc">Thất lạc</option>`
                        staffList += `<option value="Hoàn thành">Hoàn thành</option>`
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
        $(document).on('click', '.modal-desc', function() {
            var id = $(this).data('id');
            console.log(id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getDeviceById",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, 123);

                    $('#desc-device-view').text(response.data.ten);
                    $('#desc-device-detail').text(response.data.dactinhkithuat);
                    $('#device-name-desc').val(response.data.ten)
                    $('#device-quantity-desc').val(response.data.soluong)
                    $('#device-desc-desc').val(response.data.dactinhkithuat)
                    $('#device-status-desc').val(response.data.tinhtrang)
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