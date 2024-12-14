<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Lịch sử thuê số').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
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
            <div class="col-sm-12 col-lg-6">
                <a type="button" href="<?=base_url('client/otp-order');?>"
                    class="btn btn-outline-primary btn-block mt-2"><i
                        class="fas fa-cart-plus mr-1"></i><?=__('Thuê số tuỳ chọn');?></a>
            </div>
            <div class="col-sm-12 col-lg-6 mb-5">
                <button type="button" class="btn btn-primary btn-block mt-2"><i
                        class="fas fa-history mr-1"></i><?=__('Lịch sử thuê số');?></butt>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử thuê số');?></h4>
                        </div>
                        <p style="font-size:15px;float:right;"><label class="checkbox-inline"><input type="checkbox"
                                    id="UpdateHistory" class="custom-control-inpu" value=""> Tự động cập nhật kết quả
                                mỗi 3s</label></p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" id="loadHistoryOTP">
                            <table class="table data-table table-hover mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Tên ứng dụng');?></th>
                                        <th><?=__('Số điện thoại');?></th>
                                        <th><?=__('Code');?></th>
                                        <th><?=__('Tin nhắn');?></th>
                                        <th><?=__('Trạng thái');?></th>
                                        <th><?=__('Phí');?></th>
                                        <th><?=__('Thời gian');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `otp_history` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><b><?=$row['app'];?></b></td>
                                        <td><span id="copySDT<?=$row['id'];?>"><?=$row['number'];?></span> <button
                                                onclick="copy()" data-clipboard-target="#copySDT<?=$row['id'];?>"
                                                class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
                                        </td>
                                        <td><span id="copyCODE<?=$row['id'];?>"><?=$row['code'];?></span>
                                            <?php if($row['code'] != ''):?><button onclick="copy()"
                                                data-clipboard-target="#copyCODE<?=$row['id'];?>"
                                                class="copy btn btn-primary btn-sm"><i
                                                    class="fas fa-copy"></i></button><?php endif?></td>
                                        <td><?=$row['sms'];?></td>
                                        <td><?=display_otp_service($row['status']);?></td>
                                        <td><b style="color: red;"><?=format_currency($row['price']);?></b></td>
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



<?php require_once(__DIR__.'/footer.php');?>






<div id="autoload"></div>
<script>
$.ajaxSetup({
    cache: true
});
setInterval(function() {
    $('#autoload').load('<?=base_url('cron/service-otp/history.php');?>');
}, 6000);
</script>

<script type="text/javascript">
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
$("#UpdateHistory").on('change', function() {
    if (document.getElementById('UpdateHistory').checked == true) {
        <?php if(isset($getUser)):?>
        function loadHistoryOTP() {
            $.ajax({
                url: "<?=BASE_URL('ajaxs/client/loadHistoryOTP.php');?>",
                type: "POST",
                dateType: "text",
                data: {
                    token: '<?=$getUser['token'];?>'
                },
                success: function(result) {
                    $('#loadHistoryOTP').html(result);
                }
            });
        }
        var refreshIntervalId = setInterval(function() {
            $('#loadHistoryOTP').load(loadHistoryOTP());
        }, 3000);
        <?php endif?>
    } else{
        location.reload();
    }
});
</script>