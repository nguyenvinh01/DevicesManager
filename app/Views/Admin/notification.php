<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách thông báo</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="flex-row col-4">
                <div class="input-group mb-3 flex-row d-flex">
                    <input id="datatable-input" type="text" class="form-control col-4" placeholder="Tên nội dung..." aria-label="Search..." aria-describedby="button-addon2">
                    <button class="btn btn-primary col-4" type="submit" id="button-search">Tìm kiếm</button>
                    <div class="col-16 d-flex flex-row me-3">
                        <div class="form-group me-3">
                            <label for="startDate"></label>
                            <input type="date" class="form-control" id="startDate" name="startDate">
                        </div>

                        <div class="form-group mx-3">
                            <label for="reset"></label>
                            <input type="date" class="form-control" id="endDate" name="endDate">
                        </div>

                        <div class="form-group">
                            <label for="endDate"></label>

                            <input type="button" class="form-control btn-primary" id="reset" name="reset" value="Reset">
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                    Thêm mới
                </button>

            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
            <ul class="pagination justify-content-end mt-3" id="pagination">

        </div>
        <div class="modal fade" id="ModalDes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-body-desc-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal-body-desc-content">
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="addNotification">
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Tiêu đề :</label>
                                        <input type="text" class="form-control" id="category-film" name="tieude" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="category-film" class="col-form-label">Nội dung:</label>
                                        <textarea name="noidung" class="form-control" cols="30" tabindex="8" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" name="addtb">Lưu</button>
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
        getNotification()
        let prevKeywordSearch = '';
        let prevPage = 0;
        let startDate = '';
        let endDate = '';

        function getNotification(keyword = '', page = 0, sDate = '', eDate = '') {
            $.ajax({
                url: "<?php echo BASE_URL; ?>/notification/getNotification",
                method: 'GET',
                data: {
                    keyword: keyword,
                    page: page,
                    eDate: eDate,
                    sDate: sDate,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response, 11);
                        let userTable = '';
                        table.clear();
                        let index = page * 15;

                        response.data.forEach((e) => {
                            index++
                            table.row.add([
                                index,
                                e.tieude,
                                // e.noidung,
                                function() {
                                    return (`
                                    <td>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#ModalDes" class="modal-desc" data-id='${e.id}'>Xem</a>
                                    </td>
                                    `)
                                },
                                e.ngaytao,
                                // convertDateFormat(e.ngaytao),
                            ])
                        });
                        table.draw();

                        let pagination = generatePagination(prevPage, Math.ceil((response.count / 15)), 15);
                        // let itemPerPage = 15;
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
                    getNotification(prevKeywordSearch, prevPage - 1, startDate, endDate)
                    prevPage = prevPage - 1;
                }
            } else if (clickedPage === 'next') {
                if (prevPage >= 0) {
                    console.log("Clicked Page: " + prevPage);
                    getNotification(prevKeywordSearch, prevPage + 1, startDate, endDate)
                    prevPage = prevPage + 1;
                }
            } else {

                getNotification(prevKeywordSearch, clickedPage, startDate, endDate)
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
            getNotification(prevKeywordSearch, 0, startDate, endDate)
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
            getNotification(prevKeywordSearch, 0, startDate, endDate)
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
        $(document).on('click', '.modal-desc', function() {
            var id = $(this).data('id');
            console.log(123, id);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/notification/getDataModal",
                method: "GET",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'res');
                    $('#modal-body-desc-title').html(`Tiêu đề: <span>${response.data[0].tieude}</span>`)
                    $('#modal-body-desc-content').html(`
                    <div class="mx-3 my-3">
                    Nội dung thông báo:
                    <p>
                    <span>${response.data[0].noidung}</span>
                    </p>
                    
                    </div>
                    
                    `)
                    // $('#id-del').val(response.id);
                }
            })
        });

        $('#addNotification').submit(function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định khi gửi biểu mẫu
            // Gửi yêu cầu Ajax
            var formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: "<?php echo BASE_URL; ?>/notification/sendNotification", // Đường dẫn đến controller xử lý
                method: 'POST',
                data: formData,
                dataType: 'json',
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