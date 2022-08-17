<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Lịch sử order buff sub speed').' | '.$CMSNT->site('title'),
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
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <a type="button" href="<?=base_url('client/buffsub-speed');?>"
                                    class="btn btn-outline-primary btn-block mt-2"><i
                                        class="fas fa-cart-plus mr-1"></i><?=__('Tạo Tiến Trình');?></a>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <button type="button" class="btn btn-primary btn-block mt-2"><i
                                        class="fas fa-history mr-1"></i><?=__('Danh Sách Order');?></butt>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-hover mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('TransId');?></th>
                                        <th><?=__('ID seeding');?></th>
                                        <th><?=__('Server');?></th>
                                        <th><?=__('Số lượng');?></th>
                                        <th><?=__('Đã chạy');?></th>
                                        <th><?=__('Tổng tiền');?></th>
                                        <th><?=__('Thời gian');?></th>
                                        <th><?=__('Trạng thái');?></th>
                                        <th><?=__('Ghi chú');?></th>
                                        <th><?=__('Thao tác');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `order_autofb` WHERE `type` = 'buffsub-speed' AND `user_id` = '".$getUser['id']."' ORDER BY id DESC LIMIT 1000  ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['trans_id'];?></td>
                                        <td><a target="_blank" href="https://www.facebook.com/<?=$row['uid'];?>"><?=$row['uid'];?></a></td>
                                        <td><?=__(getRowRealtime("rate_autofb", $row['id_rate_autofb'], 'name_loaiseeding'));?></td>
                                        <td><b style="color:blue;"><?=format_cash($row['quantity']);?></b></td>
                                        <td><b style="color:green;"><?=format_cash($row['count_success']);?></b></td>
                                        <td><b style="color:red;"><?=format_currency($row['payment']);?></b></td>
                                        <td><i><?=$row['create_gettime'];?></i></td>
                                        <td><?=display_autofb($row['status']);?></td>
                                        <td><textarea rows="1" class="form-control" readonly><?=$row['note'];?></textarea></td>
                                        <td> 
                                        <?php if($row['status'] == 0):?>
                                            <button type="button" onclick="RemoveRow(`<?=$row['id'];?>`, `<?=$getUser['token'];?>`)" name="btnRemove<?=$row['id'];?>" data-toggle="tooltip" data-placement="top" title="<?=__('Dừng chạy');?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        <?php endif?>
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

<script>
function RemoveRow(id, token) {
    if (confirm('<?=__('Bạn sẽ không được hoàn lại tiền khi huỷ đơn hàng này, bạn có muốn tiếp tục huỷ không ?');?>') == true) {
        $('btnRemove'+id).html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled',
            true);
        $.ajax({
            url: "<?=BASE_URL("ajaxs/client/removeService.php");?>",
            method: "POST",
            dataType: "JSON",
            data: {
                id: id,
                token: token,
                type: 'buff_sub',
                app: 'facebook_buff'
            },
            success: function(respone) {
                $('btnRemove'+id).html('<i class="fas fa-trash-alt"></i>')
                    .prop('disabled', false);
                if (respone.status == 'success') {
                    cuteToast({
                        type: "success",
                        message: respone.msg,
                        timer: 5000
                    });
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
                $('btnRemove'+id).html('<i class="fas fa-trash-alt"></i>')
                    .prop('disabled', false);
                cuteToast({
                    type: "error",
                    message: '<?=__('Vui lòng liên hệ Developer');?>',
                    timer: 5000
                });
            }
        });
    }
}
</script>



<div id="autofb"></div>
<script>
$.ajaxSetup({
    cache: true
});
setInterval(function() {
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffsub-speed');?>');
}, 3000);
</script>