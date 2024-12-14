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

 
$sotin1trang = 10;
if(isset($_GET['page'])){
    $page = check_string(intval($_GET['page']));
}
else{
    $page = 1;
}
$from = ($page - 1) * $sotin1trang;
$where = " `user_id` = '".$getUser['id']."'  ";
$trans_id = '';
$amount = '';
$status = '';

if(!empty($_GET['status'])){
    $status = check_string($_GET['status']);
    $where .= ' AND `status` = "'.$status.'" ';
}
if(!empty($_GET['trans_id'])){
    $trans_id = check_string($_GET['trans_id']);
    $where .= ' AND `trans_id` LIKE "%'.$trans_id.'%" ';
}
if(!empty($_GET['amount'])){
    $amount = check_string($_GET['amount']);
    $where .= ' AND `amount` = '.$amount.' ';
}


$listDatatable = $CMSNT->get_list(" SELECT * FROM `crypto_invoice` WHERE $where ORDER BY `id` DESC LIMIT $from,$sotin1trang ");
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
                            <img width="100%" src="https://www.celticlab.com/img/sm-crypto-explorer.png" />
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
                        <form action="<?=base_url('index.php');?>"
                            class="row row-cols-lg-auto g-3 align-items-center mb-3" name="formSearch" method="GET">
                            <input type="hidden" name="action" value="crypto">
                            <div class="col-lg col-md-4 col-6">
                                <input class="form-control mb-2" value="<?=$trans_id;?>" name="trans_id"
                                    placeholder="<?=__('Search trans id');?>">
                            </div>
                            <div class="col-lg col-md-4 col-6">
                                <input class="form-control mb-2" value="<?=$amount;?>" name="amount"
                                    placeholder="<?=__('Search amount sent');?>">
                            </div>
                            <div class="col-lg col-md-4 col-6">
                                <select class="form-control mb-2" name="status">
                                    <option value=""><?=__('Search by status');?></option>
                                    <option <?=$status == 'waiting' ? 'selected' : '';?> value="waiting">
                                        <?=__('Waiting');?></option>
                                    <option <?=$status == 'expired' ? 'selected' : '';?> value="expired">
                                        <?=__('Expired');?></option>
                                    <option <?=$status == 'completed' ? 'selected' : '';?> value="completed">
                                        <?=__('Completed');?></option>
                                </select>
                            </div>
                            <div class="col-lg col-md-6 col-12 mb-2">
                                <button type="submit" name="submit" value="filter"
                                    class="btn btn-hero btn-sm btn-primary"><i class="fa fa-search"></i>
                                    <?=__('Search');?>
                                </button>
                                <a class="btn btn-hero btn-sm btn-danger"
                                    href="<?=base_url('index.php?action=crypto');?>"><i
                                        class="fa fa-trash"></i>
                                    <?=__('Clear filter');?>
                                </a>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-borderless table-bordered table-striped table-vcenter fs-sm">
                                <thead>
                                    <tr>
                                        <th><?=__('Trans ID');?></th>
                                        <th><?=__('Amount Sent');?></th>
                                        <th><?=__('Status');?></th>
                                        <th><?=__('Create date');?></th>
                                        <th><?=__('Update date');?></th>
                                        <th><?=__('Action');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listDatatable as $row2) {?>
                                    <tr>
                                        <td><a target="_blank"
                                                href="<?=$row2['url_payment'];?>"><?=$row2['trans_id'];?></a>
                                        </td>
                                        <td><b style="color: red;"><?=$row2['amount'];?></b> <b
                                                style="color:green;">USDT</b>
                                        </td>
                                        <td><?=display_invoice($row2['status']);?></td>
                                        <td><?=$row2['create_gettime'];?></td>
                                        <td><?=$row2['update_gettime'];?></td>
                                        <td class="text-center fs-base">
                                            <a type="button" target="_blank" href="<?=$row2['url_payment'];?>"
                                                class="btn btn-hero btn-success btn-sm  3">
                                                <i class="fa-sharp fa-solid fa-money-bill"></i> <?=__('Pay now');?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">

                            </div>
                            <div class="col-sm-12 col-md-7">
                                <?php
                                $total = $CMSNT->num_rows(" SELECT * FROM `crypto_invoice` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(base_url("index.php?action=crypto&trans_id=$trans_id&amount=$amount&status=$status&"), $from, $total, $sotin1trang) . '</center>';}?>
                            </div>
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
                window.open(respone.url, "_blank");
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