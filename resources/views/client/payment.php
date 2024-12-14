<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thanh toán hoá đơn | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '';
$body['footer'] = '';

if (!isset($_GET['invoice'])) {
    redirect(base_url(''));
}
if (!$row = $CMSNT->get_row("SELECT * FROM `invoices` WHERE `trans_id` = '".check_string($_GET['invoice'])."' ")) {
    redirect(base_url(''));
}
$info_payment = $CMSNT->get_row("SELECT * FROM `banks` WHERE `short_name` = '".$row['payment_method']."' ");
?>



<!DOCTYPE html>

<head id="j_idt2">
</head>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- CMSNT.CO | Version <?=$config['version'];?> -->

<head id="CMSNTCO">
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <title><?=__('Thanh toán hoá đơn');?></title>
    <meta name="description" content="Cổng thanh toán CMSNT.CO" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="robots" content="all,follow" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?=BASE_URL('public/faces');?>/javax.faces.resource/material/css/bootstrap.min.css" />
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" />
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?=BASE_URL('public/faces');?>/javax.faces.resource/material/css/style.default.css"
        id="theme-stylesheet" />
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet"
        href="<?=BASE_URL('public/faces');?>/javax.faces.resource/material/css/style-version=1.0.css" />
    <link rel="stylesheet" href="<?=BASE_URL('public/faces');?>/javax.faces.resource/material/css/qr-code.css" />
    <link rel="stylesheet" href="<?=BASE_URL('public/faces');?>/javax.faces.resource/material/css/qr-code-tablet.css" />
    <!-- Font Awesome CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Cute Alert -->
    <link class="main-stylesheet" href="<?=BASE_URL('public/');?>cute-alert/style.css" rel="stylesheet" type="text/css">
    <script src="<?=BASE_URL('public/');?>cute-alert/cute-alert.js"></script>
    <!-- jQuery -->
    <script src="<?=base_url('public/js/jquery-3.6.0.js');?>"></script>
    <style type="text/css">
    .container-fluid {
        width: 40% !important;
        min-width: 750px !important;
    }

    .info-box {
        min-height: 600px;
    }

    .entry {
        border-bottom: 1px solid #424242;
    }

    .left {
        background-color: #262626;
    }

    .receipt {
        border-bottom: 1px solid #424242
    }
    </style>
</head>

<body>
    <div class="spinner" id="spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div id="page" style="display: none;">
        <nav class="navbar navbar-default hidden-xs">
            <div class="container-fluid" style="padding: 1px;padding: 1px;width: 45%;min-width: 800px;">
                <div class="navbar-header" style="position: relative">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-right" style="padding-right: 0px;">
                        <img src="<?=BASE_URL('public/faces');?>/javax.faces.resource/images/hotline.svg"
                            alt="logo-security" width="35" />
                        <span><?=$CMSNT->site('hotline');?></span>
                        <img src="<?=BASE_URL('public/faces');?>/javax.faces.resource/images/email.svg"
                            alt="logo-security" width="35" />
                        <a href="mailto:<?=$CMSNT->site('email');?>"><span><?=$CMSNT->site('email');?></span></a>
                    </div>
                </div>
            </div>

        </nav>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 left">
                    <div class="info-box">
                        <div class="receipt">
                            <img src="<?=base_url($CMSNT->site('logo_dark'));?>" width="100%" />
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-university" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Ngân hàng');?></span>
                                <br />
                                <span
                                    style="padding-left: 25px;word-break: keep-all;"><?=$info_payment['short_name'];?></span>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Số tài khoản');?></span>
                                <br />
                                <b id="copyStk"
                                    style="padding-left: 25px;word-break: keep-all;color:greenyellow;"><?=$info_payment['accountNumber'];?></b>
                                <i onclick="copy()" data-clipboard-target="#copyStk" class="fas fa-copy copy"></i>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-user" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Chủ tài khoản');?></span>
                                <br />
                                <span
                                    style="padding-left: 25px;word-break: keep-all;"><?=$info_payment['accountName'];?></span>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-money" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Số tiền cần thanh toán');?></span>
                                <br />
                                <b style="padding-left: 25px;color:aqua;"><?=format_currency($row['pay']);?></b>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-comment" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Nội dung chuyển khoản');?></span>
                                <br />
                                <b id="copyNoiDung"
                                    style="padding-left: 25px;word-break: keep-all;color:yellow;"><?=$row['trans_id'];?></b>
                                <i onclick="copy()" data-clipboard-target="#copyNoiDung" class="fas fa-copy copy"></i>
                            </p>
                        </div>
                        <div class="entry">
                            <p><i class="fa fa-barcode" aria-hidden="true"></i>
                                <span style="padding-left: 5px;"><?=__('Trạng thái');?> 
                                </span>
                                <br />
                                <i class="fa fa-spinner fa-spin"></i><span id="status_payment" style="padding-left: 25px;word-break: break-all;"><?=__('Đang tìm dữ liệu...');?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 right">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="message" id="loginForm">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="qr-code">
                                                <?php // Thanh toán MOMO
                                                if ($row['payment_method'] == 'MOMO') { ?>
                                                <div class="payment-cta">
                                                    <div>
                                                        <h1><?=__('Quét mã QR để thanh toán');?></h1>
                                                    </div>
                                                    <a><?=__('Sử dụng <b> App MoMo </b> hoặc ứng dụng camera hỗ trợ QR code để quét mã');?></a>
                                                </div>
                                                <?=file_get_contents("https://api.web2m.com/api/qrmomo.php?amount=".$row['pay']."&phone=".$info_payment['accountNumber']."&noidung=".$row['trans_id']);?>
                                                <h3 class="text-center"><?=__('Nội dung chuyển tiền');?> <b
                                                        style="color: blue;"><?=$row['trans_id'];?></b></h3>
                                                <h4><?=__('Vui lòng nhập đúng nội dung chuyển tiền');?></h4>

                                                <?php } elseif ($row['payment_method'] == 'THESIEURE') { ?>

                                                <img src="https://thesieure.com/storage/userfiles/images/logo_thesieurecom.png"
                                                    class="mb-5">
                                                <h3 class="text-center">Thực hiện chuyển quỹ vào ví có số điện thoại là
                                                    <b><?=$info_payment['accountNumber'];?></b>
                                                </h3>
                                                <h3 class="text-center"><?=__('Số tiền cần chuyển là');?> <b
                                                        style="color: red;"><?=format_currency($row['pay']);?></b></h3>
                                                <h3 class="text-center"><?=__('Nội dung chuyển tiền');?> <b
                                                        style="color: blue;"><?=$row['trans_id'];?></b></h3>
                                                <h4 class="text-center"><?=__('Hệ thống tự động xử lý giao dịch khi thực hiện chuyển tiền thành công');?></h4>


                                                <?php } elseif ($row['payment_method'] == 'Zalo Pay' ||
                                                $row['payment_method'] == 'Kasikorn Bank' || 
                                                $row['payment_method'] == 'Siam Commercial Bank' || 
                                                $row['payment_method'] == 'MOMO' || 
                                                $row['payment_method'] == 'THESIEURE' || 
                                                $row['payment_method'] == 'Zalo Pay' || 
                                                $row['payment_method'] == 'Bank of Ayudthya' || 
                                                $row['payment_method'] == 'Krungthai Bank' || 
                                                $row['payment_method'] == 'Bangkok Bank' ||
                                                $row['payment_method'] == 'Wing Bank' ||
                                                $row['payment_method'] == 'ABA Bank' ||
                                                $row['payment_method'] == 'State Bank of India' ||
                                                $row['payment_method'] == 'HDFC Bank' ||
                                                $row['payment_method'] == 'ICICI Bank' ||
                                                $row['payment_method'] == 'Thanachart Bank' ||
                                                $row['payment_method'] == 'Maybank' ||
                                                $row['payment_method'] == 'CIMB Clicks Malaysia' ||
                                                $row['payment_method'] == 'United Bank for Africa (UBA)' ||
                                                $row['payment_method'] == 'Wise.com' ||
                                                $row['payment_method'] == 'Binance' ||
                                                $row['payment_method'] == 'Bitcoin' ||
                                                $row['payment_method'] == 'USDT' ||
                                                $row['payment_method'] == 'Payoneer'
                                                ) { ?>
                                                <h3 class="text-center"><?=__('Số tiền cần chuyển là');?> <b
                                                        style="color: red;"><?=format_currency($row['pay']);?></b></h3>

                                                <h3 class="text-center"><?=__('Nội dung chuyển tiền');?> <b
                                                        style="color: blue;"><?=$row['trans_id'];?></b></h3>
                                                <h4><?=__('Vui lòng nhập đúng nội dung chuyển tiền');?></h4>
                                                <?php } else { ?>

                                                    
                                                <div class="payment-cta">
                                                    <div>
                                                        <h1><?=__('Quét mã QR để thanh toán');?></h1>
                                                    </div>
                                                    <a><?=__('Sử dụng <b> App Internet Banking </b> hoặc ứng dụng camera hỗ trợ QR code để quét mã');?></a>
                                                </div>
                                                <img src="https://api.vietqr.io/<?=$row['payment_method'];?>/<?=$info_payment['accountNumber'];?>/<?=$row['pay'];?>/<?=$row['trans_id'];?>/vietqr_net_2.jpg?accountName=<?=$info_payment['accountName'];?>"
                                                    width="100%" />

                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid hidden-xs">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="copyrights text-center">
                        <p style="color: #737373;   font-size: 11pt; font-weight: bold;">
                            <br />
                            <?=__('Vui lòng thanh toán vào thông tin tài khoản trên để hệ thống xử lý hoá đơn tự động.');?>
                        </p>
                        <a href="<?=base_url('client/invoices');?>">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            <span><?=__('Quay lại');?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=BASE_URL('public/faces');?>/javax.faces.resource/adyen/js/tracking-version=1.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?=BASE_URL('public/faces');?>/javax.faces.resource/adyen/js/tether.min.js"></script>
    <script src="<?=BASE_URL('public/faces');?>/javax.faces.resource/adyen/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL('public/faces');?>/javax.faces.resource/adyen/js/m2.js"></script>
    <script type="text/javascript" src="<?=BASE_URL('public/faces');?>/javax.faces.resource/js/momo.js"></script>
    <script type="text/javascript" src="<?=BASE_URL('public/faces');?>/javax.faces.resource/js/ws.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#page').show();
        $('#spinner').hide();
        $("img.lazy").show().lazyload();
    });
    </script>
    <script type="text/javascript">
    function getStatusInvoice() {
        $.ajax({
            url: "<?=BASE_URL('ajaxs/client/status-invoice.php');?>",
            type: "GET",
            dataType: "JSON",
            data: {
                trans_id: "<?=$row['trans_id'];?>"
            },
            success: function(result) {
                if (result.return == 1) {
                    setTimeout("location.href = '<?=BASE_URL('client/invoices');?>';", 1000);
                }
                $('#status_payment').html(result.status);
            }
        });
    }
    setInterval(function() {
        $('#status_payment').load(getStatusInvoice());
    }, 5000);
    new ClipboardJS(".copy");

    function copy() {
        cuteToast({
            type: "success",
            message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
            timer: 5000
        });
    }
    </script>
</body>

</html>