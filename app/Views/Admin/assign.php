<div class="container-fluid px-4">

    <h1 class="mt-4">Danh sách cấp phát sử dụng thiết bị</h1>
    <div class="card mb-4">

        <div class="card-header">
            <div class="col-8 mb-3">
                <div class="input-group mb-3">
                    <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="hoten">Người sửa chữa</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div>

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
                    <div class="col-3 mx-3">
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
            <button type="button" class="btn btn-success" id="add-button" data-bs-toggle="modal" data-bs-target="#ModalAdd">
                Thêm mới
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Mã đơn cấp phát</th>
                        <!-- <th>Số lượng</th> -->
                        <th>Người kiểm tra</th>
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
        <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Xác nhận đã xử lý</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="assginStaff">
                            <input type="hidden" class="form-control" id="id-manage-device" name="id">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Nhân viên :</label>
                                        <select class="form-select" aria-label="Default select example" id="staff-list" tabindex="8" name="id-staff" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Ngày kiểm tra:</label>
                                        <input type="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" id="ngay_kiem_tra" name="ngaykiemtra" required>
                                        </select>
                                    </div>
                                </div>
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
        <!-- Modal Update-->

        <!--Des-->
        <div class="modal fade" id="ModalRevoke" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Xác nhận thu hồi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Mã cấp phát : <span id="idRevoke"></span>
                        <form method="post" id="revokeDevice">
                            <input type="hidden" class="form-control" id="idDel" name="id" value="">
                            <div class="modal-footer" style="margin-top: 20px">
                                <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Đóng
                                </button>
                                <button style="width:100px" type="submit" class="btn btn-danger" name="deletenv"> Thu hồi</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal Add-->
        <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm thiết bị quản lý</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="addAssign">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12 row">
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Danh mục thiết bị:</label>
                                            <select class="form-select" aria-label="Default select example" id="cate-add" tabindex="8" name="categories" required>
                                                <option value="" selected>Chọn danh mục thiết bị</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="category-film" class="col-form-label">Loại thiết bị:</label>
                                            <select class="form-select type-add" aria-label="Default select example" id="devicetype" tabindex="8" name="ltb" required>
                                                <option value="" selected>Chọn loại thiết bị</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Số lượng :</label>
                                        <input type="number" class="form-control" id="quantityInput" min="1" name="soluong">
                                        <span id="device-quantity"></span>
                                        <!-- <div class="input-group-append">
                                                <span class="input-group-text">/10</span>
                                            </div> -->
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Phòng ban :</label>

                                        <select class="form-select" aria-label="Default select example" id="department" tabindex="8" name="phongban" required>
                                            <option value="" selected>Chọn phòng ban</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End -->

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
        <!-- Modal desc user-->
        <div class="modal fade" id="ModalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Người kiểm tra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="editUser">
                            <input type="hidden" class="form-control" id="idUpdate" name="id" value="">
                            <div class="col mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Họ tên:</label>
                                        <input type="text" class="form-control" value="" id="hotenUpdate" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Email:</label>
                                        <input type="text" class="form-control" value="" id="emailUpdate" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category-film" class="col-form-label">Số điện thoại:</label>
                                        <input type="text" class="form-control" id="sdtUpdate" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal user desc-->
        <!-- Desc Assign -->

        <div class="modal fade" id="ModalDescAssign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="capnhat">Cập nhật</button> -->
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

        getAssignList();
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevDepartment = '';
        let startDate = '';
        let endDate = '';
        let prevFilter = '';
        let idRevoke;
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
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        function getAssignList(keyword = '', page = 0, sDate = '', eDate = '', department = '', filter = '') {
            console.log('fetch');
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getAssignList`,
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    department: department,
                    eDate: eDate,
                    sDate: sDate,
                    filter: filter
                },
                dataType: 'json',
                success: function(response) {
                    console.log(123);
                    if (response.status == "success") {
                        console.log(response, 11);
                        let userTable = '';
                        table.clear();
                        let index = page * 10;

                        response.data.forEach((e) => {
                            index++;
                            table.row.add([
                                index,
                                e.madoncapphat,
                                // function() {
                                //     return (`
                                //     <td>
                                //         <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.tentb}" data-bs-target="#ModalDes">
                                //     ${e.ten_thietbi}</a>
                                //     </td>                                    `)
                                // },
                                // e.soluong,
                                // e.ten_nv,
                                function() {
                                    return (e.ten_nv ? `
                                    <td>
                                        <a href="" class="modal-desc-user" data-bs-toggle="modal" data-id="${e.nhanvien_id}" data-bs-target="#ModalUser">
                                    ${e.ten_nv}</a>
                                    </td>` : 'Chưa phân công')
                                },
                                e.ngaykiemtra,
                                e.ten_phongban,
                                e.ten_toanha + "-" + e.ten_diadiem,
                                e.trangthai,
                                function() {
                                    return (
                                        `

                                    <td style="width : 130px !important">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Thao tác
                                            </button>
                                            <ul class="dropdown-menu">
                                                <button type="button" class="btn btn-primary modal-desc-assign dropdown-item" data-id="${e.madoncapphat}" data-bs-toggle="modal" data-bs-target="#ModalDescAssign">
                                                Chi tiết
                                                </button>
                                                <button type="button" class="btn btn-primary modal-edit dropdown-item" data-id="${e.madoncapphat}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                                Phân công
                                                </button>
                                                ${e.trangthai == "Đã Thu Hồi" ? "" : `<button type="button" class="btn btn-primary modal-revoke dropdown-item" data-id="${e.madoncapphat}" data-bs-toggle="modal" data-bs-target="#ModalRevoke">
                                                Thu hồi
                                                </button>`}
                                                
                                            </ul>
                                        </div>
                                    </td>
                                    `)
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
                    getAssignList(prevKeywordSearch, prevPage - 1, startDate, endDate, prevDepartment, prevFilter)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getAssignList(prevKeywordSearch, prevPage + 1, startDate, endDate, prevDepartment, prevFilter)
                    prevPage = prevPage + 1;
                }
            } else {

                getAssignList(prevKeywordSearch, clickedPage, startDate, endDate, prevDepartment, prevFilter)
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
            getAssignList(prevKeywordSearch, 0, startDate, endDate, prevDepartment, prevFilter)
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
            getAssignList(prevKeywordSearch, 0, startDate, endDate, prevDepartment, prevFilter)
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
            getAssignList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), prevDepartment, prevFilter)

        })
        $('#addAssign').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            console.log('submit');
            var formData = new FormData(this);
            // console.log($('#addAssign').serialize(), 'addAssign');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/addAssign", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: $('#addAssign').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById('ModalAdd');
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error("error");
                }
            });
        });

        $('#devicetype').on('change', function(e) {
            e.preventDefault();
            let deviceList;
            $('#device-quantity').text('');
            $('#quantityInput').attr('max', 0)

            const id = $('#devicetype option').filter(":selected").val();
            console.log(id);
            $.ajax({
                url: `<?php echo BASE_URL; ?>/assign/getDeviceById?id=${id}`, // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#device-quantity').text(`Số lượng thiết bị trong kho: ${response.data.count}`);
                        $('#quantityInput').attr('max', response.data.count)
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
                        // $('#device-list').append('<option value="" selected>Chọn loại thiết bị</option>');
                        // response.data.forEach((d) => {
                        //     deviceList += `<option value="${d.id}">${d.ten}</option>`
                        // })

                        // $('#device-list').append(deviceList);

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#add-button').click(function(e) {
            e.preventDefault();
            // let deviceType;
            let department;
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getDataAddModal", // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // $('#devicetype').html('');
                        // $('#devicetype').append('<option value="" selected>Chọn loại thiết bị</option>');
                        // response.dataDeviceType.forEach((dt) => {
                        //     deviceType += `<option value="${dt.id}">${dt.ten}</option>`
                        // })
                        // $('#devicetype').append(deviceType);


                        $('#department').html('');
                        $('#department').append('<option value="" selected>Chọn phòng ban</option>');
                        response.dataDepartment.forEach((dp) => {
                            department += `<option value="${dp.id}">${dp.tenpb}</option>`
                        })
                        $('#department').append(department);

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#assginStaff').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/assignStaff", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalEdit`);
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

        $.ajax({
            url: "<?php echo BASE_URL; ?>/assign/getDeviceCategories", // Đường dẫn đến controller xử lý
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
        $('#revokeDevice').submit(function(e) {
            e.preventDefault();
            console.log(idRevoke);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/revokeDevice", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: {
                    id: idRevoke
                }, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        toastr.success(response.message);
                        var modalElement = document.getElementById('ModalRevoke');
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $('#cate-add').change(function() {
            let cate = $(this).val();
            console.log(cate, '123');
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getDeviceType", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    cate: cate
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        let typeList;
                        $('#devicetype').html('')
                        $('#devicetype').each(function() {
                            let typeAdd = `<option value="">Chọn loại thiết bị</option>`;
                            response.data.map((type) => {
                                // if (type.id == response.data.loaithietbi_id) {
                                //     typeAdd += `<option value="${type.id}" selected>${type.ten}</option>`
                                // } else {
                                typeAdd += `<option value="${type.maloai}">${type.ten} (${type.so_luong})</option>`
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
                        response.data.forEach((assign) => {

                            list += `
                        <tr>
                            <td>${index}</td>
                            <td>${assign.mathietbi}</td>
                            <td>${assign.ten_thietbi}</td>
                            <td>${assign.tinhtrang == null ? '' : assign.tinhtrang}</td>
                        </tr>
                            `
                            index++;
                        })
                        $('#table-assign-detail').html(list)

                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $(document).on('click', '.modal-edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            let staffList;
            console.log('modaledit', id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getStaff", // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#staff-list').html('');
                        $('#staff-list').append('<option value="" selected>Chọn nhân viên kiểm tra</option>');
                        response.data.forEach((s) => {
                            if (s.id == id) {
                                staffList += `<option value="${s.id}" selected>${s.hoten}</option>`
                            } else {
                                staffList += `<option value="${s.id}">${s.hoten}</option>`
                            }
                        })
                        $('#staff-list').append(staffList);
                        $('#id-manage-device').val(id);
                    } else {}
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.error(error);
                }
            });
        })
        $(document).on('click', '.modal-revoke', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            let staffList;
            console.log('modaledit', id);
            idRevoke = id;
            $('#idRevoke').text(idRevoke)
            // $.ajax({
            //     url: "<?php echo BASE_URL; ?>/assign/revokeDevice", // Đường dẫn đến controller xử lý
            //     method: 'POST',
            //     data: {
            //         id: id
            //     }, // Dữ liệu gửi đi từ form
            //     dataType: 'json',
            //     success: function(response) {
            //         console.log(response);
            //         // if (response.status == "success") {
            //         //     $('#staff-list').html('');
            //         //     $('#staff-list').append('<option value="" selected>Chọn nhân viên kiểm tra</option>');
            //         //     response.data.forEach((s) => {
            //         //         if (s.id == id) {
            //         //             staffList += `<option value="${s.id}" selected>${s.hoten}</option>`
            //         //         } else {
            //         //             staffList += `<option value="${s.id}">${s.hoten}</option>`
            //         //         }
            //         //     })
            //         //     $('#staff-list').append(staffList);
            //         //     $('#id-manage-device').val(id);
            //         // } else {}
            //     },
            //     error: function(xhr, status, error) {
            //         // Xử lý lỗi khi gửi yêu cầu Ajax
            //         console.error(error);
            //     }
            // });
        })
        $(document).on('click', '.modal-desc-user', function() {
            var id = $(this).data('id');
            console.log(123, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getUserById",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#hotenUpdate').val(response.data.hoten);
                    $('#emailUpdate').val(response.data.email);
                    $('#sdtUpdate').val(response.data.sodienthoai);
                    // $('#idUpdate').val(response.id);
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