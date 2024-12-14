<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Squadco Nigeria Recharge').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('squadco_status') != 1) {
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
                            <b><?=mb_strtoupper(__('Squadco Nigeria Recharge'), 'UTF-8');?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img width="100%"
                                    src="https://tobidigital.com/wp-content/uploads/2022/06/SquadCo-By-GTCO-logo-png-transparent.png" />
                            </div>
                            <div class="form-group">
                                <label
                                    for="amount"><?=__('Enter the deposit amount: ('.$CMSNT->site('squadco_currency_code').')');?></label>
                                <input type="number" id="amount"
                                    placeholder="<?=__('Please enter the amount to deposit');?>" class="form-control"
                                    required>
                                <input type="hidden" id="email" value="<?=$getUser['email'];?>" />
                                <input type="hidden" id="currency_code"
                                    value="<?=$CMSNT->site('squadco_currency_code');?>" />
                                <input type="hidden" id="transaction_ref" value="<?=uniqid();;?>" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="form-group">
                            <button type="button" onclick="SquadPay()" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-1"></i><?=__('Submit');?>
                            </button>
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
                        <?=$CMSNT->site('squadco_notice');?>
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
                                        <th><?=__('Price');?></th>
                                        <th><?=__('Create date');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `payment_squadco` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['transaction_ref'];?></b></td>
                                        <td><b><?=$row['amount'];?></b></td>
                                        <td><b><?=format_currency($row['price']);?></b></td>
                                        <td><?=$row['create_gettime'];?></td>
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


<script src="https://checkout.squadco.com/widget/squad.min.js"></script>

<script>
function SquadPay() {

    const squadInstance = new squad({
        onClose: () => console.log("Widget closed"),
        onLoad: () => console.log("Widget loaded successfully"),
        onSuccess: () => console.log(`Linked successfully`),
        key: "<?=$CMSNT->site('squadco_Public_Key');?>",
        //Change key (test_pk_sample-public-key-1) to the key on your Squad Dashboard
        email: document.getElementById("email").value,
        transaction_ref: document.getElementById("transaction_ref").value,
        currency_code: document.getElementById("currency_code").value,
        amount: document.getElementById("amount").value * 100
    });
    squadInstance.setup();
    squadInstance.open();

}
</script>



<?php require_once(__DIR__.'/footer.php');?>