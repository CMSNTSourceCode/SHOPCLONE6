<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Tăng like, follow, comment mạng xã hội').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
.form-control{
    border: 1px solid '.$CMSNT->site('theme_color').';
}
</style>
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch("state", $(this).prop("checked"));
      })
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
';

require_once(__DIR__.'/../../../models/is_user.php');

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <button type="button" class="btn btn-primary btn-block mt-2"><i
                                            class="fas fa-cart-plus mr-1"></i><?=__('Tạo Tiến Trình');?></button>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <a type="button" href="<?=base_url('client/history-service');?>"
                                        class="btn btn-outline-primary btn-block mt-2"><i
                                            class="fas fa-history mr-1"></i><?=__('Danh Sách Order');?></a>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div id="msg_dang_chuyen_doi_sang_uid" style="display:none;">
                                        <div class="alert bg-white alert-primary" role="alert">
                                            <i class="fa fa-spinner fa-spin mr-1"></i><?=__('Vui lòng chờ...');?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Chọn dịch vụ bạn cần:');?></label>
                                        <div class="col-lg-8 fv-row">
                                            <select class="form-control select2bs4" onchange="loadService()" id="category">
                                                <option value="">-- <?=__('Chọn dịch vụ');?> --</option>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `category_service` WHERE `display` = 1 ") as $category):?>
                                                <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Chọn 1 trong các máy chủ sau:');?></label>
                                        <div class="col-lg-8 fv-row">
                                            <select class="form-control select2bs4" onchange="totalPayment()" id="service">
                                                <option value="">-- <?=__('Vui lòng chọn dịch vụ trước');?> --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="show_note">
                                        <div class="col-sm-12 col-lg-4">
                                         
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <div class="alert alert-warning" role="alert">
                                                <div class="iq-alert-text">
                                                    <span id="load_note"><br><br></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><?=__('Link đến trang (bài) cần tăng tương tác:');?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <input name="url" id="url"
                                                placeholder="<?=__('Link đến trang (bài) cần tăng tương tác (Bao gồm https://)');?>"
                                                type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="show_comment">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><?=__('Viết Bình luận (1 comment mỗi dòng):');?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <textarea class="form-control" placeholder="Nên lưu nháp bình luận đã nhập ra ngoài để đề phòng đơn hàng bị lỗi hoặc có thể sử dụng lại lần sau" onkeyup="totalPayment()" id="comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="show_amount">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><?=__('Số lượng tương tác cần mua:');?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <input id="amount" onkeyup="totalPayment()" type="number" class="form-control" value="1"><br>
                                            <p id="min_max"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="show_comment_username">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><?=__('Tên của người bình luận:');?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <input id="comment_username" placeholder="Ví dụ: kiennguyen6868" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="show_mentionUsernames">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><?=__('Nhập nội dung các bình luận (1 mỗi dòng):');?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <textarea class="form-control" placeholder="<?=__('Chúng tôi sẽ lựa chọn ngẫu nhiên các comments từ danh sách bạn đã nhập để nhận xét vào các bài đăng của bạn trong tháng');?>" id="mentionUsernames"></textarea>
                                        </div>
                                    </div>
                                    <div class="alert bg-white alert-info" role="alert">
                                        <div class="card-body">
                                            <input type="hidden" id="token"
                                                value="<?=isset($getUser['token']) ? $getUser['token'] : '';?>"
                                                readonly>
                                            <center>
                                                <h5 class="mb-2"><?=__('Thanh Toán:');?> <b id="total"
                                                        style="color: red;"><?=format_currency(0);?></b> </h5>
                                            </center>
                                        </div>
                                    </div>
                                    <center>
                                    <button type="button" id="btnOrderService"
                                        class="btn btn-primary mt-2"><i
                                            class="fas fa-credit-card mr-1"></i><?=__('TẠO TIẾN TRÌNH');?></button>
                                            </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require_once(__DIR__.'/footer.php');?>

<script>
function loadService(){
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/loadForm.php');?>",
        method: "POST",
        data: {
            category: $("#category").find(':selected').val(),
            type: 'loadService'
        },
        success: function(response) {
            $("#service").html(response);
        }
    });
}



$("#show_note").hide();
$("#show_comment").hide();
$("#show_amount").show();
$("#show_comment_username").hide();
$("#show_mentionUsernames").hide();

function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    var amount = $("#amount").val();
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalPayment.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            service: $("#service").find(':selected').val(),
            amount: $("#amount").val(),
            comment: $("#comment").val(),
            token: $("#token").val(),
            store: 'order-service'
        },
        success: function(respone) {
            $("#total").html(respone.total);
            $("#load_note").html(respone.msg.toString());
            $("#min_max").html(respone.min_max.toString());
            $("#show_note").show();
            $("#show_comment").hide();
            $("#show_amount").show();
            $("#show_comment_username").hide();
            $("#show_mentionUsernames").hide();
            if(respone.msg == ''){
                $("#show_note").hide();
            }
            if (respone.type == 'Custom Comments') {
                $("#show_comment").show();
                $("#show_amount").hide();
            }
            else if(respone.type == 'Comment Likes'){
                $("#show_comment_username").show();
            }
            else if(respone.type == 'Mentions'){
                $("#show_mentionUsernames").show();
            }
            else if(respone.type == 'Package'){
                $("#show_amount").hide();
            }
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể tính kết quả thanh toán',
                timer: 5000
            });
        }
    });
}

$("#btnOrderService").on("click", function() {
        Swal.fire({
            title: '<?=__('Xác nhận thanh toán !');?>',
            text: '<?=__('Đơn hàng sẽ được gửi đi và không thể huỷ nếu bạn nhấn Thanh Toán');?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?=__('Thanh Toán');?>',
            cancelButtonText: '<?=__('Đóng');?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btnOrderService').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>')
                    .prop('disabled', true);
                $.ajax({
                    url: "<?=BASE_URL('ajaxs/client/orderService.php');?>",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        token: $('#token').val(),
                        url: $('#url').val(),
                        service: $("#service").find(':selected').val(),
                        comment: $('#comment').val(),
                        comment_username: $('#comment_username').val(),
                        mentionUsernames: $('#mentionUsernames').val(),
                        amount: $('#amount').val()
                    },
                    success: function(respone) {
                        if (respone.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '<?=__('Thành công !');?>',
                                text: respone.msg,
                                showDenyButton: true,
                                confirmButtonText: '<?=__('Mua thêm');?>',
                                denyButtonText: `<?=__('Xem lịch sử đơn hàng');?>`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                } else if (result.isDenied) {
                                    window.location.href =
                                        '<?=base_url('client/history-service');?>';
                                }
                            });
                        } else {
                            Swal.fire('<?=__('Thất bại !');?>', respone.msg, 'error');
                        }
                        $('#btnOrderService').html('<?=__('Tạo Tiến Trình');?>').prop('disabled',
                            false);
                    }
                })
            }
        })

    });

    
</script>