<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp tiền qua PayPal').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_paypal') != 1) {
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
                    <div class="card-header d-flex justify-content-between pb-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0"><?=__('Nạp tiền qua PayPal');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Nhập số tiền cần nạp');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="number" id="amount" class="form-control" name="amount"
                                        placeholder="<?=__('Nhập số tiền cần nạp bằng USD');?>" required />
                                    <input type="hidden" id="token" value="<?=$getUser['token'];?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <script
                            src="https://www.paypal.com/sdk/js?client-id=<?=$CMSNT->site('clientId_paypal');?>&currency=USD">
                        </script>

                        <div id="paypal-button-container"></div>
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
                        <?=$CMSNT->site('paypal_notice');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử nạp PayPal');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Mã giao dịch');?></th>
                                        <th><?=__('Số tiền nạp');?></th>
                                        <th><?=__('Thực nhận');?></th>
                                        <th><?=__('Trạng thái');?></th>
                                        <th><?=__('Thời gian');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `payment_paypal` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['trans_id'];?></b></td>
                                        <td><b style="color: red;">$<?=format_cash($row['amount']);?></b></td>
                                        <td><b style="color: green;"><?=format_currency($row['price']);?></b></td>
                                        <td>
                                            <p
                                                class="mb-0 text-success font-weight-bold d-flex justify-content-start align-items-center">
                                                <?=__('Thành công');?></p>
                                        </td>
                                        <td><?=$row['create_date'];?></td>
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


<script>
(function($) {
    paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: $('#amount')
                            .val() // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                    }
                }]
            });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                $.ajax({
                    url: '<?=BASE_URL('ajaxs/client/confirm-paypal.php');?>',
                    method: 'POST',
                    data: {
                        act: 'confirm',
                        token: '<?=$getUser['token'];?>',
                        order: orderData
                    },
                    success: function(response) {
                        const result = JSON.parse(response)
                        if (result.status == 'success') {
                            cuteToast({
                                type: "success",
                                message: result.msg,
                                timer: 5000
                            });
                            setTimeout("location.href = '';", 2000);
                        } else {
                            cuteToast({
                                type: "error",
                                message: result.msg,
                                timer: 5000
                            });
                        }
                    }
                })
            });
        }
    }).render('#paypal-button-container');
})(jQuery)
</script>




<?php require_once(__DIR__.'/footer.php');?>