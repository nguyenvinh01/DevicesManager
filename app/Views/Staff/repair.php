<head>
    <style>
        .custom-tag-red {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;
            background-color: #ff0000bd;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }

        .custom-tag-blue {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;
            background-color: #0b5ed7;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }

        .custom-tag-green {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;
            background-color: #157347;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }


        .custom-tag-gray {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;
            background-color: #7f878f;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }

        .custom-tag-yellow {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #091544;
            background-color: #eae425fa;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }

        .custom-tag-white {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #091544;
            background-color: #f8f9fa;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
        }
    </style>
</head>
<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách yêu cầu sửa chữa đã nhận</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="col-8 mb-3">
                <div class="input-group mb-3">
                    <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="nguoigui">Người gửi</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div>

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-primary col-2" type="submit" id="button-search">Search</button>
                    <div class="col-3 mx-3">
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

                        <input type="button" class="form-control btn-primary" id="reset" name="reset" value="Reset">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Ngày gửi</th>
                        <th>Thiết bị</th>
                        <th>Nội dung</th>
                        <th>Người gửi</th>
                        <!-- <th>Người sửa chữa</th> -->
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
        </div>
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
                                <!-- <div class="col-6">
                                    <label for="category-film" class="col-form-label">Tình trạng:</label>
                                    <input type="text" class="form-control" id="device-status-desc" disabled>
                                </div> -->
                                <div class="col-6">
                                    <label for="category-film" class="col-form-label">Mã thiết bị:</label>
                                    <input type="text" class="form-control" id="device-code-desc" disabled>
                                </div>
                            </div>
                            <!-- <div class="row">
                            </div> -->
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
                        <h5 class="modal-title" id="exampleModalLabel">Thông tin</h5>
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
        let prevStatus = '';
        let startDate = '';
        let endDate = '';
        let prevFilter = '';
        getRepairList();

        function getRepairList(keyword = '', page = 0, sDate = '', eDate = '', status = '', filter = '') {
            $.ajax({
                url: `<?php echo BASE_URL; ?>/repair/getRepairList`,
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
                    if (response.status == "success") {
                        console.log(response, 123);
                        // let userTable = '';
                        table.clear();
                        response.data.forEach((e, index) => {
                            console.log(e, 123);
                            table.row.add([
                                index + 1,
                                e.ngaygui,
                                // e.tentb,
                                function() {
                                    return (`
                                    <td>
                                        <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.thietbi_id}" data-bs-target="#ModalDes">
                                    ${e.tentb}</a>
                                    </td>                                    `)
                                },
                                e.noidung,
                                function() {
                                    return (
                                        `<a href="" class="modal-desc-user" data-bs-toggle="modal" data-id="${e.nguoidung_id}" data-bs-target="#ModalUser">${e.hoten}</a> `)
                                }, // function() {
                                //     const staffName = response.staff.find(s => e.phancong === s.id);
                                //     if (staffName) {
                                //         return staffName.hoten;
                                //     } else return ""
                                // },
                                // e.tinhtrang,
                                function() {
                                    if (e.tinhtrang == "Hỏng") {
                                        return `<span class="custom-tag-red">${e.tinhtrang}</span>`
                                    } else if (e.tinhtrang == "Hoàn thành") {
                                        return `<span class="custom-tag-blue">${e.tinhtrang}</span>`
                                    } else if (e.tinhtrang == "Thất lạc") {
                                        return `<span class="custom-tag-gray">${e.tinhtrang}</span>`
                                    } else if (e.tinhtrang == "Cần sửa chữa" || e.tinhtrang == "Đang kiểm tra" || e.tinhtrang == "Cần sửa chữa") {
                                        return `<span class="custom-tag-yellow">${e.tinhtrang}</span>`
                                    } else if (e.tinhtrang == "Chờ xử lý") {
                                        return `<span class="custom-tag-white">${e.tinhtrang}</span>`
                                    }
                                    return `<span class="custom-tag-green">${e.tinhtrang}</span>`

                                },
                                function() {
                                    return (
                                        e.tinhtrang == "Hoàn thành" ? '' : `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                        Cập nhật
                                    </button>
                                    </td>
                                    `)
                                },
                            ])
                        });
                        table.draw();
                        let pagination = generatePagination(prevPage, Math.ceil((response.count / 5)), 5);
                        // let itemPerPage = 5;
                        // if (prevPage == 0) {
                        //     pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        // } else {
                        //     pagination += '<li class="page-item"><a class="page-link" href="#" data-page="previous"> Previous</a></li>';
                        // }
                        // for (let i = 0; i < (response.count / itemPerPage); i++) {
                        //     if (i == prevPage) {
                        //         pagination += `<li class="page-item disabled"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                        //     } else {
                        //         pagination += `<li class="page-item"><a class="page-link" href="#" data-page=${i}>${i+1}</a></li>`

                        //     }
                        // }
                        // if (prevPage == Math.floor((response.count / itemPerPage))) {
                        //     console.log(response.count / itemPerPage, 'dis');
                        //     pagination += '<li class="page-item disabled"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        // } else {
                        //     console.log(response.count / itemPerPage);

                        //     pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next"> Next</a></li>';
                        // }
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
                    getRepairList(prevKeywordSearch, prevPage - 1, startDate, endDate, prevStatus, prevFilter)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getRepairList(prevKeywordSearch, prevPage + 1, startDate, endDate, prevStatus, prevFilter)
                    prevPage = prevPage + 1;
                }
            } else {

                getRepairList(prevKeywordSearch, clickedPage, startDate, endDate, prevStatus, prevFilter)
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
            getRepairList(prevKeywordSearch, 0, startDate, endDate, prevStatus, prevFilter)
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
            getRepairList(prevKeywordSearch, 0, startDate, endDate, prevStatus, prevFilter)
        })
        $('#select-status').change(function(e) {
            e.preventDefault();

            const status = $('#select-status').val();
            prevStatus = status;
            prevPage = 0;
            getRepairList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), status, prevFilter)

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
        $('#editRepair').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            var id = $(this).serialize().split(/[=,&]/)[1];

            console.log(formData, 11, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/updateStatusRepair", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'res');
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`ModalEdit`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        console.log(response);
                        // toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    // toastr.error(xhr.responseText);

                    console.error(xhr, status, error);
                }
            });
        });
        $(document).on('click', '.modal-edit', function() {
            var id = $(this).data('id');
            console.log('edit', id);
            let staffList;

            $.ajax({
                url: `<?php echo BASE_URL; ?>/repair/getDataModal?id=${id}`,
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
                        staffList += `
                        <option value="Cần sửa chữa">Cần sửa chữa</option>
                        <option value="Hoàn thành">Hoàn thành</option>
                        `
                        // staffList += `<option value="Cần sửa chữa">Cần sửa chữa</option>`

                    } else if (response.data[0].tinhtrang == "Cần sửa chữa") {
                        staffList += `
                        <option value="Đang sửa chữa">Đang sửa chữa</option>
                        <option value="Hỏng">Không thể sửa chữa</option>
                        `
                    } else if (response.data[0].tinhtrang == "Đang sửa chữa") {
                        staffList += `<option value="Hoàn thành">Hoàn thành</option>`
                    }
                    console.log(1, staffList, 1);
                    $('#list-staff').append(staffList)
                    $('#id-repair').val(id)
                }
            })
        });
        $(document).on('click', '.modal-desc-user', function() {
            var id = $(this).data('id');
            console.log(123, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/getUserById",
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
                url: "<?php echo BASE_URL; ?>/repair/getDeviceById",
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
                    $('#device-code-desc').val(response.data.mathietbi)
                    $('#device-desc-desc').val(response.data.dactinhkithuat)
                    $('#device-status-desc').val(response.data.tinhtrang)
                    $('#device-image-desc').attr("src", "./uploads/image/" + response.data.hinhanh)
                    // $('#id-del').val(response.id);
                }
            })
        });

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
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }