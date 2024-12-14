<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp tiền qua Perfect Money').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_perfectmoney') != 1) {
    redirect(base_url(''));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');


if ($CMSNT->num_rows("SELECT * FROM `payment_pm` WHERE `user_id` = '".$getUser['id']."' AND `status` = 0 ") > 0) {
    $payment_id = $CMSNT->get_row("SELECT * FROM `payment_pm` WHERE `user_id` = '".$getUser['id']."' AND `status` = 0 ")['payment_id'];
} else {
    $payment_id = random('QWERTYUIOPASDFGHJKLZXCVBNM', 4).'_'.time();
    $CMSNT->insert("payment_pm", [
        'user_id'       => $getUser['id'],
        'payment_id'    => $payment_id,
        'amount'        => 0,
        'create_date'   => gettime(),
        'create_time'   => time(),
        'update_date'   => gettime(),
        'update_time'   => time(),
        'status'        => 0
    ]);
}
$params = [
    'API_URL'               => 'https://perfectmoney.is/api/step1.asp',
    'PAYMENT_ID'            => $payment_id, // mã giao dịch không trùng lặp để lưu lên hệ thống
    'PAYEE_ACCOUNT'         => $CMSNT->site('PAYEE_ACCOUNT_PM'), // mã tài khoản Perfect Money
    'PAYMENT_UNITS'         => $CMSNT->site('PAYMENT_UNITS_PM'), // đơn vị tiền tệ,
    'PAYEE_NAME'            => $getUser['username'], // tên người thanh toán
    'PAYMENT_URL'           => base_url('client/perfectmoney'), // URL của hoá đơn
    'NOPAYMENT_URL'         => base_url('client/perfectmoney'), // URL của hoá đơn
    'STATUS_URL'            => base_url('api/confirm-pm.php'), // Webhook callback
    'SUGGESTED_MEMO'        => 'Payment - '.$CMSNT->site('title')
];
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert bg-white alert-primary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?=$CMSNT->site('perfectmoney_notice');?></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <form method="POST" action="<?=$params['API_URL']?>" target="_blank">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="https://perfectmoney.com/img/logo3.png" />
                            </div>
                            <input type="hidden" name="SUGGESTED_MEMO" value="<?=$params['SUGGESTED_MEMO']?>">
                            <input type="hidden" name="PAYMENT_ID" value="<?=$params['PAYMENT_ID']?>" />
                            <input type="hidden" name="PAYEE_ACCOUNT" value="<?=$params['PAYEE_ACCOUNT']?>" />
                            <input type="hidden" name="PAYMENT_UNITS" value="<?=$params['PAYMENT_UNITS']?>" />
                            <input type="hidden" name="PAYEE_NAME" value="<?=$params['PAYEE_NAME']?>" />
                            <input type="hidden" name="PAYMENT_URL" value="<?=$params['PAYMENT_URL']?>" />
                            <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK" />
                            <input type="hidden" name="NOPAYMENT_URL" value="<?=$params['NOPAYMENT_URL']?>" />
                            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK" />
                            <input type="hidden" name="STATUS_URL" value="<?=$params['STATUS_URL']?>" />
                            <div class="form-group">
                                <label for="amount">Nhập số tiền: (USD)</label>
                                <input type="number" name="PAYMENT_AMOUNT" id="amount"
                                    placeholder="<?=__('Nhập số tiền cần nạp bằng USD');?>" class="form-control"
                                    value="1" aria-describedby="helpId" required>
                            </div>
                            <div class="card-footer text-center">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="createPmCheckout">
                                        <i class="fas fa-paper-plane mr-1"></i><?=__('Thực Hiện');?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử nạp Prefect Money');?></h4>
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
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `payment_pm` WHERE `user_id` = '".$getUser['id']."' AND `status` = 1 ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['payment_id'];?></b></td>
                                        <td><b style="color: red;">$<?=format_cash($row['amount']);?></b></td>
                                        <td><b style="color: green;"><?=format_currency($row['price']);?></b></td>
                                        <td>
                                            <p
                                                class="mb-0 text-success font-weight-bold d-flex justify-content-start align-items-center">
                                                <?=__('Thành công');?></p>
                                        </td>
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






<?php require_once(__DIR__.'/footer.php');?>