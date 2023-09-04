<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử mượn trả của bạn</h1>
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
                        <select id="select-status" class="form-select col select" aria-label="Default select example">
                            <option value="" selected disabled hidden>Trạng thái</option>
                            <option value="">Tất cả</option>
                            <!-- <option value="1">Admin</option> -->
                            <option value="Đang mượn">Đang mượn</option>
                            <option value="Chờ phê duyệt">Chờ phê duyệt</option>
                            <option value="Đã trả">Đã trả</option>
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
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên thiết bị</th>
                        <!-- <th>Ảnh</th> -->
                        <th>Địa điểm</th>
                        <th>Ngày mượn</th>
                        <th>Ngày trả</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

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
    </div>
</div>
<script>
    $(document).ready(function() {
        getBorrowHistoryList()
        let prevKeywordSearch = '';
        let prevPage = 0;
        let prevStatus = '';
        let startDate = '';
        let endDate = '';

        function getBorrowHistoryList(keyword = '', page = 0, sDate = '', eDate = '', status = '') {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/borrowhistory/getBorrowHistoryList", // Đường dẫn đến controller xử lý
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    status: status,
                    eDate: eDate,
                    sDate: sDate,
                },
                dataType: 'json',
                success: function(response) {
                    // if (response.status == "success") {
                    console.log(response.data[0], 444);
                    let userTable = '';
                    table.clear();
                    let index = page * 5;

                    response.data.forEach((e, index) => {
                        index++
                        table.row.add([
                            index,
                            // e.ten,
                            // function() {
                            //     return (`
                            // <td> 

                            // </td>
                            //         `)
                            // },
                            function() {
                                return (`
                                    <td>
                                        <a href="" class="modal-desc" data-bs-toggle="modal" data-id="${e.thietbi_id}" data-bs-target="#ModalDes">
                                    ${e.ten}</a>
                                    </td>                                    `)
                            },
                            e.diadiem,
                            e.ngaymuon,
                            e.ngaytra,
                            e.trangthai,
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
                    // } else {}
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
                    getBorrowHistoryList(prevKeywordSearch, prevPage - 1, startDate, endDate, prevStatus)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getBorrowHistoryList(prevKeywordSearch, prevPage + 1, startDate, endDate, prevStatus)
                    prevPage = prevPage + 1;
                }
            } else {

                getBorrowHistoryList(prevKeywordSearch, clickedPage, startDate, endDate, prevStatus)
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
            // if (option != prevOptionSearch || keyword != prevKeywordSearch) {
            //     prevKeywordSearch = keyword;
            //     prevOptionSearch = option;
            // }l
            console.log(startDate, endDate);
            getBorrowHistoryList(prevKeywordSearch, 0, startDate, endDate, prevStatus)
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
            getBorrowHistoryList(prevKeywordSearch, 0, startDate, endDate, prevStatus)
        })
        $('#select-status').change(function(e) {
            e.preventDefault();

            const status = $('#select-status').val();
            prevStatus = status;
            prevPage = 0;
            getBorrowHistoryList(prevKeywordSearch, 0, $("#startDate").val(), $("#endDate").val(), status)

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
    })
    $(document).on('click', '.modal-desc', function() {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: "<?php echo BASE_URL; ?>/borrowhistory/getDeviceById",
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
</script>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);

    }