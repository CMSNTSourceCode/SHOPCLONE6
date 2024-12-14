<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Flutterwave Nigeria Recharge').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('flutterwave_status') != 1) {
    redirect(base_url(''));
}
if ($CMSNT->num_rows("SELECT * FROM `payment_flutterwave` WHERE `user_id` = '".$getUser['id']."' AND `status` = 'pending' ") > 0) {
    $tx_ref = $CMSNT->get_row("SELECT * FROM `payment_flutterwave` WHERE `user_id` = '".$getUser['id']."' AND `status` = 'pending' ")['tx_ref'];
} else {
    $tx_ref = md5(random('QWERTYUIOPASDFGHJKLZXCVBNM', 4).'_'.time());
    $CMSNT->insert("payment_flutterwave", [
        'user_id'       => $getUser['id'],
        'tx_ref'        => $tx_ref,
        'amount'        => 0,
        'currency'      => 'NGN',
        'create_gettime'   => gettime(),
        'update_gettime'   => gettime(),
        'status'        => 'pending'
    ]);
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
                            <b><?=mb_strtoupper(__('Flutterwave Nigeria Recharge'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img width="100%"
                                src="https://cdn.punchng.com/wp-content/uploads/2022/09/22131354/Flutterwave.jpg" />
                        </div>
                        <form method="POST" action="https://checkout.flutterwave.com/v3/hosted/pay">
                            <input type="hidden" name="public_key" value="<?=$CMSNT->site('flutterwave_publicKey');?>" />
                            <input type="hidden" name="customer[email]" value="<?=$getUser['email'];?>" />
                            <input type="hidden" name="customer[name]" value="<?=$getUser['username'];?>" />
                            <input type="hidden" name="tx_ref" value="<?=$tx_ref;?>" />
                            <div class="form-group">
                                <label for="amount"><?=__('Enter the deposit amount: (NGN)');?></label>
                                <input type="number" name="amount" placeholder="<?=__('Please enter the amount to deposit');?>" class="form-control" required>
                            </div>
                            <input type="hidden" name="currency" value="NGN" />
                            <input type="hidden" name="meta[token]" value="<?=$tx_ref;?>" />
                            <input type="hidden" name="redirect_url" value="<?=base_url('client/flutterwave');?>" />
                            <div class="form-group">
                                <button type="submit" id="start-payment-button" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-1"></i><?=__('Submit');?>
                                </button>
                            </div>
                        </form>
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
                        <?=$CMSNT->site('flutterwave_notice');?>
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
                                        <th><?=__('TransID');?></th>
                                        <th><?=__('Amount');?></th>
                                        <th><?=__('Create date');?></th>
                                        <th><?=__('Update date');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `payment_flutterwave` WHERE `user_id` = '".$getUser['id']."' AND `status` = 'success' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['tx_ref'];?></b></td>
                                        <td><b><?=$row['amount'];?> NGN</b></td>
                                        <td><?=$row['create_gettime'];?></td>
                                        <td><?=$row['update_gettime'];?></td>
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
        url: "<?=BASE_URL('ajaxs/client/flutterwave.php');?>",
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