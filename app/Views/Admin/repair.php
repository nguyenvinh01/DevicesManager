<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách yêu cầu sửa chữa đã nhận</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="col-8 mb-3">
                <div class="input-group mb-3">
                    <div class="col-2">
                        <select id="optionSelect" class="form-select col" aria-label="Default select example">
                            <option value="">Tất cả</option>
                            <option value="nguoisuachua">Người sửa chữa</option>
                            <option value="nguoigui">Người gửi</option>
                            <option value="thietbi">Tên thiết bị</option>
                        </select>
                    </div>

                    <input id="datatable-input" type="text" class="form-control col-16" placeholder="Search name, email..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-success col-2" type="submit" id="button-search">Search</button>
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

                        <input type="button" class="form-control btn-success" id="reset" name="reset" value="Reset">
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
                        <!-- <th>Chi phí</th> -->
                        <!-- <th>Thời gian</th> -->
                        <th>Người gửi</th>
                        <th>Người sửa chữa</th>
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
                                <form method="POST" enctype="multipart/form-data" id="editRepair">
                                    <input type="hidden" class="form-control" id="id-assign" name="id">
                                    <div class="col">
                                        <select class="form-select" id="list-staff" aria-label="Default select example" id="theloai" tabindex="8" name="id-staff" required>
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
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevStatus = '';
        let startDate = '';
        let endDate = '';
        let prevFilter = '';

        getRepairList();

        function getRepairList(keyword = '', page = 0, sDate = '', eDate = '', status = '', filter = '') {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/repair/getRepairList",
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
                        console.log(response, 11);
                        let userTable = '';
                        table.clear();
                        let index = page * 5;

                        response.data.forEach((e) => {
                            index++
                            table.row.add([
                                index,
                                e.ngaygui,
                                // e.noidung,
                                e.tentb,
                                // function() {
                                //     return (`
                                //     <td>
                                //     <a href="" data-bs-toggle="modal" data-bs-target="#ModalDes" class= "modal-desc" data-id = '${e.thietbi_id}'>Xem</a>
                                //     </td>
                                //     `)
                                // },
                                e.noidung,
                                e.hoten,
                                function() {
                                    const staffName = response.staff.find(s => e.phancong === s.id);
                                    if (staffName) {
                                        return `<a href="" data-bs-toggle="modal" data-bs-target="#ModalDes" class= "modal-desc" data-id = '${e.thietbi_id}'>${staffName.hoten}</a> `;
                                    } else return "Chưa phân công"
                                },
                                e.tinhtrang,
                                function() {
                                    return (
                                        e.tinhtrang == 'Hoàn thành' ? "" : `
                                    <td style="width : 130px !important">
                                    <button type="button" class="btn btn-primary modal-edit" data-id="${e.id}" data-bs-toggle="modal" data-bs-target="#ModalEdit">
                                        Phân công
                                    </button>
                                    </td>
                                    `)
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
                url: "<?php echo BASE_URL; ?>/repair/assignRepair", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData, // Dữ liệu gửi đi từ form
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'res');
                    if (response.status == "success") {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message);
                        var modalElement = document.getElementById(`exampleModalEdit${id}`);
                        var modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    } else {
                        // Hiển thị thông báo lỗi
                        console.log(response);
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    toastr.error(xhr.responseText);

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

                    response.staff.map((s) => {
                        if (s.id == response.staffAssign[0].phancong) {
                            console.log('selected', staffList);
                            staffList += `<option value="${s.id}" selected>${s.hoten}</option>`
                        } else {
                            console.log('not selected', staffList);
                            staffList += `<option value="${s.id}">${s.hoten}</option>`

                        }
                    })
                    console.log(1, staffList, 1);
                    $('#list-staff').append(staffList)
                    $('#id-assign').val(id)
                    // let typeList;
                    // console.log(response.devicetype, '1');
                    // response.devicetype.map((type) => {
                    //     if (type.id == response.data.loaithietbi_id) {
                    //         typeList += `<option value="${type.id}" selected>${type.ten}</option>`
                    //     } else {
                    //         typeList += `<option value="${type.id}">${type.ten}</option>`
                    //     }
                    // })
                    // $('#theloai').append(typeList);
                    // $('#id-edit').val(response.data.id);
                    // $('#device-name-edit').val(response.data.ten)
                    // $('#device-quantity-edit').val(response.data.soluong)
                    // $('#device-desc-edit').val(response.data.dactinhkithuat)
                    // $('#device-status-edit').val(response.data.tinhtrang)
                    // $('#id-edit').val(response.id);
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