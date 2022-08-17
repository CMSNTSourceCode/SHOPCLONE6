<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Crypto').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_crypto') != 1) {
    redirect(base_url(''));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');

 
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <b><?=mb_strtoupper(__('Nạp tiền qua Crypto'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="https://www.celticlab.com/img/sm-crypto-explorer.png" />
                        </div>
                        <div class="form-group">
                            <label for="amount"><?=__('Nhập số tiền: (USD)');?></label>
                            <input type="hidden" id="token" class="form-control" value="<?=$getUser['token'];?>" />
                            <input type="number" id="amount" placeholder="<?=__('Nhập số tiền cần nạp bằng USD');?>"
                                class="form-control" value="10" aria-describedby="helpId" required>
                        </div>
                        <div class="card-footer text-center">
                            <div class="form-group">
                                <button type="button" id="btnSubmit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-1"></i><?=__('Thực Hiện');?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <b><?=mb_strtoupper(__('Lưu Ý'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <?=$CMSNT->site('notice_crypto');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <b><?=mb_strtoupper(__('Lịch sử nạp Crypto'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Order Id');?></th>
                                        <th><?=__('Description');?></th>
                                        <th><?=__('Amount');?></th>
                                        <th><?=__('Status');?></th>
                                        <th><?=__('Create date');?></th>
                                        <th><?=__('Update date');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `nowpayments` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a href="https://nowpayments.io/payment/?iid=<?=$row['invoice_id'];?>" target="_blank"><?=$row['order_id'];?></a></td>
                                        <td><b><?=$row['order_description'];?></b></td>
                                        <td><b style="color: red;">$<?=format_cash($row['price_amount']);?></b></td>
                                        <td>
                                            <?=display_status_crypto($row['payment_status']);?>
                                        </td>
                                        <td><?=$row['created_at'];?></td>
                                        <td><?=$row['updated_at'];?></td>
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





<script type="text/javascript">
$("#btnSubmit").on("click", function() {
    $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/crypto.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: $('#token').val(),
            amount: $('#amount').val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                window.open(respone.invoice_url, "_blank");
                Swal.fire({
                    title: '<?=__('Thành công');?>',
                    icon: 'success',
                    text: respone.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    respone.msg,
                    'error'
                );
            }
            $('#btnSubmit').html('<i class="fas fa-paper-plane mr-1"></i><?=__('Thực Hiện');?>')
                .prop('disabled', false);
        }
    })
});
</script>


<?php require_once(__DIR__.'/footer.php');?>