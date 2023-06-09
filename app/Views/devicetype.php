<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách loại thiết bị</h1>
    <div class="card mb-4">
        <div class="card-header">
            <?php if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 1) { ?>
                    <div class="alert alert-success">
                        <strong>Thành công</strong>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        <strong>Không thể xóa !</strong>
                    </div>
                <?php }  ?>
            <?php }  ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
                Thêm mới
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="background-color : #6D6D6D">
                        <th>STT</th>
                        <th>Tên loại thiết bị</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($data["dataDeviceType"] as $arUser) {
                        $idModelDel = "exampleModalDel" . $arUser["id"];
                        $idModelEdit = "exampleModalEdit" . $arUser["id"];
                    ?>
                        <tr>
                            <td><?php echo $stt ?></td>
                            <td><?php echo $arUser["ten"] ?></td>
                            <td style="width : 130px !important">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelEdit ?>">
                                    Sửa
                                </button>
                                <?php if ($_SESSION['quyen'] == 1) { ?>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $idModelDel ?>">
                                        Xóa
                                    </button>
                                <?php } ?>
                                <!--Dele-->
                                <div class="modal fade" id="<?php echo $idModelDel ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn xóa ?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Loại thiết bị : <?php echo $arUser["ten"] ?>
                                                <form action="deviceType/deleteDeviceType" method="post">
                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                                    <div class="modal-footer" style="margin-top: 20px">
                                                        <button style="width:100px" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Đóng
                                                        </button>
                                                        <button style="width:100px" type="submit" class="btn btn-danger" name="deletedm"> Xóa</button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Dele-->
                            </td>

                        </tr>
                        <!-- Modal Update-->
                        <div class="modal fade" id="<?php echo $idModelEdit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="deviceType/editDeviceType" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $arUser["id"] ?>">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="category-film" class="col-form-label">Tên loại thiết bị:</label>
                                                        <input type="text" class="form-control" id="category-film" value="<?php echo $arUser["ten"] ?>" name="ten" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary" name="editdm">Lưu</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Update-->
                    <?php $stt++;
                    } ?>
                    <!-- Modal Add-->
                    <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="deviceType/addDeviceType" method="POST" enctype="multipart/form-data">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="category-film" class="col-form-label">Tên loại thiết bị:</label>
                                                    <input type="text" class="form-control" id="category-film" name="ten" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary" name="adddm">Lưu </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Modal Update-->


                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace("editor");
</script>
<script>
    for (var i = 1; i < 200; i++) {
        var name = "editor" + i
        CKEDITOR.replace(name);
    }