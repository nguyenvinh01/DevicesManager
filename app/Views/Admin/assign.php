<div class="container-fluid px-4">

    <h1 class="mt-4">Danh sách phân quyền sử dụng thiết bị</h1>
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
                        <th>Thiết bị</th>
                        <th>Số lượng</th>
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
                                        <!-- <div class="row">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Thời gian:</label>
                                            <input type="text" class="form-control" id="category-film" name="thoigian" required>
                                        </div>
                                    </div> -->
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
                <!-- <div class="modal fade" id="ModalDesc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nội dung</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo $arUser["noidung"] ?>
                        </div>
                    </div>
                </div>
            </div> -->
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
                                                    <label for="category-film" class="col-form-label">Loại thiết bị :</label>
                                                    <select class="form-select" aria-label="Default select example" id="devicetype" tabindex="8" name="loaithietbi" required>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label for="category-film" class="col-form-label">Thiết bị :</label>
                                                    <select class="form-select" aria-label="Default select example" id="device-list" tabindex="8" name="thietbi" required>
                                                    </select>

                                                </div>
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
                                        <!-- <div class="row my-3">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Tình trạng :</label>
                                            <select class="form-select" aria-label="Default select example" id="department" tabindex="8" name="phongban" required>
                                                <option value="" selected>Chọn tình trạng</option>
                                            </select>
                                        </div>
                                    </div> -->
                                        <!-- <div class="row">
                                        <div class="col-12">
                                            <label for="category-film" class="col-form-label">Nội dung:</label>
                                            <textarea name="noidung" class="form-control" cols="30" tabindex="8" rows="10"></textarea>
                                        </div>
                                    </div> -->
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
        </div>
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
                                e.ten_thietbi,
                                e.soluong,
                                e.ten_nv,
                                e.ngaykiemtra,
                                e.ten_phongban,
                                e.ten_toanha + "-" + e.ten_diadiem,
                                e.tinhtrang,
                                function() {
                                    return (
                                        e.tinhtrang == "Đã xử lý" ? "" : `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                        Kiểm tra
                                    </button>
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
            console.log(formData, 'addAssign');
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
                        // Hiển thị thông báo lỗi
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
            let deviceType;
            let department;
            $.ajax({
                url: "<?php echo BASE_URL; ?>/assign/getDataAddModal", // Đường dẫn đến controller xử lý
                method: 'GET',
                // data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        $('#devicetype').html('');
                        $('#devicetype').append('<option value="" selected>Chọn loại thiết bị</option>');
                        response.dataDeviceType.forEach((dt) => {
                            deviceType += `<option value="${dt.id}">${dt.ten}</option>`
                        })
                        $('#devicetype').append(deviceType);


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