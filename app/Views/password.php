<div class="container-fluid px-4">
    <h1 class="mt-4">Đổi mật khẩu</h1>
    <div class="card-body ">
        <form id="changePasswordForm" method="post">
            <!-- Form Group (birthday)-->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="currentPassword">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="newPassword">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="confirmPassword">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>

            </div>
            <button type="submit" class="btn btn-primary mt-3" name="changePass" id="btn-submit">Đổi mật khẩu</button>
        </form>
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

        $('#btn-submit').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "http://localhost/quanlithietbi/profile/changepass",
                method: 'POST',
                data: $('#changePasswordForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        console.log('qqqq');

                        toastr.success(response.message);
                        // var modalElement = document.getElementById('exampleModal');
                        // var modal = bootstrap.Modal.getInstance(modalElement);
                        // modal.hide();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
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