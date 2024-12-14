<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Automatic Recharge').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_toyyibpay') != 1) {
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
                            <b><?=mb_strtoupper(__('Automatic top-up with Toyyibpay'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img width="100%" src="https://jatimas.com.my/wp-content/uploads/2020/12/payment-toyyibpay.png" />
                        </div>
                        <div class="form-group">
                            <label for="amount"><?=__('Enter the deposit amount: (RM)');?></label>
                            <input type="hidden" id="token" class="form-control" value="<?=$getUser['token'];?>" />
                            <input type="number" id="amount" placeholder="<?=__('The amount is in 1 = RM1');?>"
                                class="form-control"  aria-describedby="helpId" required>
                        </div>
                        <div class="card-footer text-center">
                            <div class="form-group">
                                <button type="button" id="btnSubmit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-1"></i><?=__('Submit');?>
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
                            <b><?=mb_strtoupper(__('NOTIFICATION'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <?=$CMSNT->site('notice_toyyibpay');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <b><?=mb_strtoupper(__('DEPOSIT HISTORY'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Bill Code');?></th>
                                        <th><?=__('Name');?></th>
                                        <th><?=__('Amount');?></th>
                                        <th><?=__('Status');?></th>
                                        <th><?=__('Create date');?></th>
                                        <th><?=__('Update date');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `toyyibpay_transactions` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a href="https://toyyibpay.com/<?=$row['BillCode'];?>" target="_blank"><?=$row['BillCode'];?></a></td>
                                        <td><b><?=$row['billName'];?></b></td>
                                        <td>RM <b><?=$row['amount'];?></b></td>
                                        <td>
                                            <?=display_status_toyyibpay($row['status']);?>
                                        </td>
                                        <td><?=$row['create_date'];?></td>
                                        <td><?=$row['update_date'];?></td>
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
    $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Please wait...");?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/toyyibpay.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: $('#token').val(),
            amount: $('#amount').val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                window.open(respone.invoice_url, "_blank");
            } else {
                Swal.fire(
                    '<?=__('Error');?>',
                    respone.msg,
                    'error'
                );
            }
            $('#btnSubmit').html('<i class="fas fa-paper-plane mr-1"></i><?=__('Submit');?>')
                .prop('disabled', false);
        }
    })
});
</script>


<?php require_once(__DIR__.'/footer.php');?>