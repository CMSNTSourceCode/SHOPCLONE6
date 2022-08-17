<?php

define("IN_SITE", true);

require_once(__DIR__ . "/../../../libs/db.php");
require_once(__DIR__ . "/../../../libs/helper.php");
require_once(__DIR__ . "/../../../libs/lang.php");
require_once(__DIR__ . '/../../../models/is_admin.php');
require_once(__DIR__ . "/../../../libs/database/users.php");

if (!$row = $CMSNT->get_row(" SELECT * FROM `withdraw_ref` WHERE `id` = '" . check_string($_GET['id']) . "' ")) {
    die('<script type="text/javascript">if(!alert("Item không tồn tại trong hệ thống")){location.reload();}</script>');
}
if (isset($_POST['btnSave'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){location.href=`' . base_url_admin('withdraw') . '`;}</script>');
    }
    if($row['status'] == 2){
        die('<script type="text/javascript">if(!alert("Đơn rút này đã được hoàn tiền rồi, không thể thay đổi trạng thái")){location.href=`' . base_url_admin('withdraw') . '`;}</script>');
    }
    if($_POST['status'] == 2){
        $CMSNT->cong('users', 'ref_money', $row['amount'], " `id` = '".$row['user_id']."' ");
        $CMSNT->insert('log_ref', [
            'user_id'       => $row['user_id'],
            'reason'        => 'Hoàn tiền đơn rút #'.$row['trans_id'],
            'sotientruoc'   => getRowRealtime('users', $row['user_id'], 'ref_money') - $row['amount'],
            'sotienthaydoi' => $row['amount'],
            'sotienhientai' => getRowRealtime('users', $row['user_id'], 'ref_money'),
            'create_gettime'    => gettime()
        ]);
    } 
    $isUpdate = $CMSNT->update("withdraw_ref", [
        'status'            => check_string($_POST['status']),
        'reason'            => check_string($_POST['reason']),
        'update_gettime'    => gettime()
    ], " `id` = '" . $row['id'] . "' ");
    if ($isUpdate) {
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){location.href=`' . base_url_admin('withdraw') . '`;}</script>');
    }
    die('<script type="text/javascript">if(!alert("Lưu thất bại!")){location.href=`' . base_url_admin('withdraw') . '`;}</script>');
}
?>


<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="modal-header">
    <h5 class="modal-title" id="CharginModalTitle">Chỉnh sửa đơn rút tiền #<?=$row['trans_id'];?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="modalContent" class="modal-body">
    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab-chinh-sua-item-tab" data-toggle="pill" href="#tab-chinh-sua-item"
                role="tab" aria-controls="tab-chinh-sua-item" aria-selected="true">CHỈNH SỬA ĐƠN HÀNG</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-lich-su-nhan-hoa-hong-tab" data-toggle="pill" href="#tab-lich-su-nhan-hoa-hong"
                role="tab" aria-controls="tab-lich-su-nhan-hoa-hong" aria-selected="false">LỊCH SỬ NHẬN HOA HỒNG</a>
        </li>
    </ul>
    <div class="tab-content" id="custom-content-below-tabContent" style="padding-top: 25px">
        <div class="tab-pane fade active show" id="tab-chinh-sua-item" role="tabpanel"
            aria-labelledby="tab-chinh-sua-item-tab">
            <form method="POST" action="<?= BASE_URL('ajaxs/admin/modal/withdraw-ref.php?id=' . $row['id']); ?>"
                accept-charset="UTF-8">
                <div class="form-group">
                    <label for="exampleInputEmail1">Ngân hàng</label>
                    <input class="form-control" type="text" value="<?= $row['bank']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Số tài khoản</label>
                    <input class="form-control" type="text" value="<?= $row['stk']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chủ tài khoản</label>
                    <input class="form-control" type="text" value="<?= $row['name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Số tiền rút</label>
                    <input class="form-control" type="text" value="<?= format_currency($row['amount']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Trạng thái</label>
                    <select class="form-control" name="status" required>
                        <option <?= $row['status'] == 1 ? 'selected' : ''; ?> value="1">Hoàn tất</option>
                        <option <?= $row['status'] == 0 ? 'selected' : ''; ?> value="0">Chờ xử lý</option>
                        <option <?= $row['status'] == 2 ? 'selected' : ''; ?> value="2">Huỷ (hoàn tiền)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Lý do</label>
                    <textarea class="form-control" rows="4" placeholder="Nhập lý do huỷ đơn rút nếu có" name="reason"><?=$row['reason'];?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="btnSave" class="btn btn-primary btn-block">LƯU THAY ĐỔI</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-block">HUỶ
                        THAY ĐỔI</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab-lich-su-nhan-hoa-hong" role="tabpanel"
            aria-labelledby="tab-lich-su-nhan-hoa-hong">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Hoa hồng trước</th>
                            <th>Hoa hồng thay đổi</th>
                            <th>Hoa hồng hiện tại</th>
                            <th>Thời gian</th>
                            <th>Nội dung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `log_ref` WHERE `user_id` = '".$row['user_id']."' ORDER BY id DESC  ") as $log_ref) {?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><b style="color: green;"><?=format_currency($log_ref['sotientruoc']);?></b>
                            </td>
                            <td><b style="color:red;"><?=format_currency($log_ref['sotienthaydoi']);?></b>
                            </td>
                            <td><b style="color: blue;"><?=format_currency($log_ref['sotienhientai']);?></b>
                            </td>
                            <td><i><?=$log_ref['create_gettime'];?></i></td>
                            <td><i><?=$log_ref['reason'];?></i></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#datatable').DataTable();
});
</script>


<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?= BASE_URL("ajaxs/admin/update.php"); ?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeProductAPI',
            id: id,
            price: $("#price" + id).val(),
            cost: $("#cost" + id).val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            location.reload();
        }
    });
}


function RemoveRowProduct(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Sản Phẩm",
        message: "Bạn có chắc chắn muốn xóa sản phẩm ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?= BASE_URL("ajaxs/admin/removeProduct.php"); ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>
<script type="text/javascript">
function RemoveRowCategory(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Chuyên Mục",
        message: "Bạn có chắc chắn muốn xóa chuyên mục ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?= BASE_URL("ajaxs/admin/removeCategory.php"); ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>



<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "Đã sao chép vào bộ nhớ tạm",
        timer: 5000
    });
}
</script>