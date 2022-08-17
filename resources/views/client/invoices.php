<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Hoá Dơn').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

 ';
$body['footer'] = '

 ';

require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert bg-white alert-warning" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?=__('Mỗi hoá đơn chỉ tồn tại trong '.timeAgo2($CMSNT->site('invoice_expiration')).' tính từ thời gian tạo, vui lòng thực hiện thanh toán sau khi tạo hoá đơn.');?></div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Hoá đơn');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Mã giao dịch');?></th>
                                        <th><?=__('Phương thức thanh toán');?></th>
                                        <th><?=__('Số lượng');?></th>
                                        <th><?=__('Thanh toán');?></th>
                                        <th><?=__('Trạng thái');?></th>
                                        <th><?=__('Thời gian');?></th>
                                        <th><?=__('Thao tác');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `invoices` WHERE `user_id` = '".$getUser['id']."' AND `type` = 'deposit_money' AND `fake` = 0 ORDER BY `id` DESC LIMIT 1000 ") as $inv) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a href="<?=base_url('client/payment/'.$inv['trans_id']);?>"><i
                                                    class="fas fa-file-alt"></i>
                                                <?=$inv['trans_id'];?></a></td>
                                        <td><b style="font-size:15px;"><?=$inv['payment_method'];?></b></td>
                                        <td><b style="color: red;"><?=format_currency($inv['amount']);?></b></td>
                                        <td><b style="color: green;"><?=format_cash($inv['pay']);?>đ</b></td>
                                        <td><?=display_invoice($inv['status']);?></td>
                                        <td><?=$inv['create_date'];?></td>
                                        <td>
                                            <a class="" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="<?=__('Chi tiết hoá đơn');?>"
                                                href="<?=base_url('client/payment/'.$inv['trans_id']);?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4"
                                                    width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
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


<?php require_once(__DIR__.'/footer.php');?>