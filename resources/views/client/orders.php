<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Lịch sử đơn hàng').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '
 ';
$body['footer'] = '
 ';
require_once(__DIR__.'/../../../models/is_user.php');
if($CMSNT->site('status_is_change_password') == 1){
    if(isset($getUser) && $getUser['change_password'] == 0){
        redirect(base_url('client/is-change-password'));
    }
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert bg-white alert-primary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?=$CMSNT->site('orders_notice');?></div>
                </div>
            </div>
            <div class="col-lg-6 text-left">
                <div class="mb-3">
                    <a href="<?=$_SERVER['HTTP_REFERER'];?>" type="button" class="btn btn-danger btn-sm"><i
                            class="fas fa-arrow-left mr-1"></i><?=__('Quay Lại');?></a>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                <!-- <div class="mb-3">
                    <button class="btn btn-primary btn-sm btn-icon-left m-b-10" data-toggle="modal"
                        data-target="#modal-default" type="button"><i
                            class="fas fa-cloud-download-alt mr-1"></i><?=__('Tải Về File Backup VIA');?></button>
                </div> -->
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử mua hàng');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-hover mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Mã giao dịch');?></th>
                                        <th><?=__('Sản phẩm');?></th>
                                        <th><?=__('Số lượng');?></th>
                                        <th><?=__('Thanh toán');?></th>
                                        <th><?=__('Thời gian');?></th>
                                        <th><?=__('Thao tác');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `orders` WHERE `fake` = 0 AND `buyer` = '".$getUser['id']."' AND `display` = 1  ORDER BY id DESC  ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['trans_id'];?></td>
                                        <?php if($row['product_id'] != 0){?>
                                            <td><b><?=$row['name'] == NULL ? getRowRealtime("products", $row['product_id'], 'name') : $row['name'];?></b></td>
                                        <?php }?>
                                        <?php if($row['document_id'] != 0){?>
                                            <td><b><?=$row['name'] == NULL ? getRowRealtime("documents", $row['document_id'], 'name') : $row['name'];?></b></td>
                                        <?php }?>
                                        <td><b style="color:blue;"><?=format_cash($row['amount']);?></b></td>
                                        <td><b style="color:red;"><?=format_currency($row['pay']);?></b></td>
                                        <td><i><?=$row['create_date'];?></i></td>
                                        <td><a type="button" href="<?=base_url('client/order/'.$row['trans_id']);?>"
                                                class="btn btn-primary btn-sm"><?=__('Xem Thêm');?></a>
                                            <?php if($row['product_id'] != 0):?>
                                            <button type="button" onclick="downloadFile(`<?=$row['trans_id'];?>`, `<?=$getUser['token'];?>`)"
                                                class="btn btn-danger btn-sm"><?=__('Tải Về');?></button>
                                            <?php endif?>
                                            <button type="button"
                                                onclick="RemoveRow(<?=$row['id'];?>, `<?=$getUser['token'];?>`, `<?=$row['trans_id'];?>`)"
                                                class="btn btn-warning btn-sm"><?=__('Xoá');?></button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=__('Tải Về File Backup VIA');?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?=__('UID VIA');?></label>
                        <input type="text" id="uid_via" class="form-control"
                            placeholder="<?=__('Nhập UID VIA cần tải về file backup');?>">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?=__('Đóng');?></button>
                    <button type="button" onclick="downloadBackup()" class="btn btn-primary"><?=__('Tải Về');?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php require_once(__DIR__.'/footer.php');?>
<script type="text/javascript">
function downloadFile(transid, token) {
    cuteAlert({
        type: "question",
        title: "<?=__('Xác nhận tải về đơn hàng');?> #" + transid,
        message: "<?=__('Bạn có chắc chắn muốn tải về hàng này không');?>",
        confirmText: "<?=__('Đồng Ý');?>",
        cancelText: "<?=__('Hủy');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/client/downloadOrder.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    transid: transid,
                    token: token
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        downloadTXT(respone.filename, respone.accounts);
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
function downloadBackup() {
    if ($("#uid_via").val() == '') {
        return cuteAlert({
            type: "error",
            title: "Error",
            message: "<?=__('Vui lòng nhập UID cần tải');?>",
            buttonText: "Okay"
        });
    }
    window.open('<?=base_url('assets/storage/backup/');?>' + $("#uid_via").val() + '.zip', '_blank').focus();
}
function RemoveRow(id, token, transid) {
    cuteAlert({
        type: "question",
        title: "<?=__('Xác nhận xoá đơn hàng');?> #" + transid,
        message: "<?=__('Bạn có chắc chắn muốn xóa đơn hàng này không ?');?>",
        confirmText: "<?=__('Đồng Ý');?>",
        cancelText: "<?=__('Hủy');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/client/removeOrder.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    token: token
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

            });
        }
    })
}
function downloadTXT(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}
</script>