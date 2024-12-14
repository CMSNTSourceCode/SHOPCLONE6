<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Công Cụ Check Live Facebook').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
';
$body['footer'] = '

';

if($CMSNT->site('sign_view_product') == 0){
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
        if (!$getUser) {
            header("location: ".BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__.'/../../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../../models/is_user.php');
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"
                        style="background: <?=$CMSNT->site('theme_color');?>;">
                        <div class="header-title">
                            <h5 class="card-title" style="color:white;"><?=__('CHECK LIVE UID');?></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="thongbao"></div>
                        <div class="form-horizontal"  >
                            <div id='loading_box' style='display:none;'>
                                <center><img src='https://i.imgur.com/qaIBNyQ.gif' /></center>
                            </div>
                            <div id='form_box'>
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" style='text-align:left'><?=__('Nhập Danh Sách UID');?>:</label>
                                    <div class="col-sm-12">
                                        <textarea style='height:150px;white-space:pre;overflow-wrap:normal;'
                                            class="form-control" id='fb_ids'
                                            placeholder="<?=__('Mỗi dòng 1 UID, có thể nhập full định dạng như: UID|PASS|...');?>"
                                            value=''></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <span onClick='check_live_account()'
                                            class="btn btn-warning btn_control_box btn-block"><?=__('Bắt Đầu');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label text-success" style='text-align:left'>Nick Live
                                    <span class='badge badge-success px-3' style="background-color:#4caf50;"><span
                                            id='total_live'>0</span> / <span id='total_fb_id1'>0</span></span></label>
                                <div class="col-sm-12">
                                    <textarea style='height:150px;white-space:pre;overflow-wrap:normal;'
                                        class="form-control mb-3" id='live_fb_ids'></textarea>
                                        <button onclick="copy()" data-clipboard-target="#live_fb_ids" 
                                        class='btn btn-info btn-sm btn-block copy'>COPY</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label text-error" style='text-align:left'>Nick Die <span
                                        class='badge badge-danger px-3' style="background-color:#f44336;"><span
                                            id='total_die'>0</span> / <span id='total_fb_id2'>0</span></span></label>
                                <div class="col-sm-12">
                                    <textarea style='height:150px;white-space:pre;overflow-wrap:normal;'
                                        class="form-control mb-3" id='die_fb_ids'></textarea>
                                        <button onclick="copy()" data-clipboard-target="#die_fb_ids" 
                                        class='btn btn-info btn-sm btn-block copy'>COPY</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script language='javascript'>
new ClipboardJS(".copy");
function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}

function check_live_account() {
    $('#live_fb_ids').val('');
    $('#die_fb_ids').val('');
    $('#total_live').html('0');
    $('#total_die').html('0');
    $('#total_fb_id1').html('0');
    $('#total_fb_id2').html('0');
    if ($("#fb_ids").val()) {
        var fb_ids = [];
        var list_duplicate = {};
        var cur_fb_ids = $("#fb_ids").val();
        var temp_fb_ids = cur_fb_ids.toString().split("\n");
        for (var i = 0; i < temp_fb_ids.length; i++) {
            if (temp_fb_ids[i] && temp_fb_ids[i].toString().trim()) {
                if (!list_duplicate[temp_fb_ids[i].toString().trim()]) {
                    fb_ids.push(temp_fb_ids[i].toString().trim());
                    list_duplicate[temp_fb_ids[i].toString().trim()] = 1;
                }
            }
        }
        $("#loading_box").show();
        $('#total_fb_id1').html(fb_ids.length);
        $('#total_fb_id2').html(fb_ids.length);
        check_live_nick(fb_ids, 0, function() {
            $("#loading_box").hide();
        });
    }
}

function check_live_nick(fb_ids, counter, callback) {
    if (counter < fb_ids.length) {
        var limit = 10;
        var done = 0;
        var call = 0;
        var list_done = [];
        var next_limit = counter + limit;
        next_limit = next_limit > fb_ids.length ? fb_ids.length : next_limit;
        for (var i = counter; i < next_limit; i++) {
            call++;
            check_live_one_nick(fb_ids[i], function(response) {
                list_done.push(response);
                done++;
                if (done >= call) {
                    check_live_nick(fb_ids, next_limit, callback);
                }
            });
        }
    } else {
        callback();
    }
}

function check_live_one_nick(fb_id, callback) {
    $.get("<?=BASE_URL('ajaxs/client/check-live-fb.php?uid=');?>" + fb_id, function(data, status) {
        if (data == 'LIVE') {
            $("#total_live").html(parseInt($("#total_live").html()) + 1);
            if ($("#live_fb_ids").val()) {
                $("#live_fb_ids").val($("#live_fb_ids").val() + "\n" + fb_id);
            } else {
                $("#live_fb_ids").val(fb_id);
            }
        } else {
            $("#total_die").html(parseInt($("#total_die").html()) + 1);
            if ($("#die_fb_ids").val()) {
                $("#die_fb_ids").val($("#die_fb_ids").val() + "\n" + fb_id);
            } else {
                $("#die_fb_ids").val(fb_id);
            }
        }
        callback();
    });
}
</script>
<?php require_once(__DIR__.'/footer.php');?>