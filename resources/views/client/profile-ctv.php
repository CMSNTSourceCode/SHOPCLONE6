<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thông tin đại lý | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<style>
.text-white {
    color: #fff!important;
}
.pb-2, .py-2 {
    padding-bottom: 0.5rem!important;
}
.pt-2, .py-2 {
    padding-top: 0.5rem!important;
}
.rounded-circle {
    border-radius: 50%!important;
}
.bg-danger {
    background-color: #dc3545!important;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
div {
    display: block;
}
.bg-warning {
    background-color: #ffc107!important;
}
.progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    background-color: #007bff;
    transition: width .6s ease;
}
.progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: 0.25rem;
}
.progress-label-left {
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}
.progress-label-right {
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}
</style>
';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_user.php');
if (isset($_GET['username'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."' AND `ctv` = 1 ")) {
        redirect(base_url(''));
    }
} else {
    redirect(base_url(''));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content d-flex flex-column flex-column-fluid">
    <div class="d-flex flex-column-fluid">
        <div class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-lg-12">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label">Sản phẩm của đại lý <?=$row['username'];?><span
                                        class="svg-icon svg-icon-1 svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                fill="#00A3FF"></path>
                                            <path class="permanent"
                                                d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                fill="white"></path>
                                        </svg>
                                    </span></span>
                            </h3>
                            <div class="table-responsive">
                                <table id="datatable" class="table align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light">
                                            <th class="ps-4 min-w-400px rounded-start">Sản phẩm</th>
                                            <th class="min-w-100px">Quốc gia</th>
                                            <th class="min-w-100px">Hiện có</th>
                                            <th class="min-w-100px">Giá</th>
                                            <th class="min-w-200px text-end rounded-end"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($CMSNT->get_list(" SELECT * FROM `products` WHERE `status` = 1 AND `user_id` = '".$row['id']."'  ") as $product) {?>
                                        <tr>
                                            <td>
                                                <b type="button"
                                                    onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>)"
                                                    style="font-size: 14px;"><?=$product['name'];?></b>
                                                <span
                                                    class="text-muted fw-bold text-muted d-block fs-7"><?=$product['content'];?></span>
                                            </td>
                                            <td>
                                                <?=display_flag($product['flag']);?>
                                            </td>
                                            <td>
                                                <b
                                                    style="color: blue;"><?=format_cash($CMSNT->num_rows("SELECT * FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' "));?></b>
                                            </td>
                                            <td>
                                                <b style="color: red;"><?=format_currency($product['price']);?></b>
                                            </td>
                                            <td class="text-end">
                                                <button type="button"
                                                    onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>)"
                                                    class="btn btn-primary btn-sm px-4">Mua</button>
                                            </td>
                                        </tr>

                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label">Uy tín của đại lý <?=$row['username'];?><span
                                        class="svg-icon svg-icon-1 svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                fill="#00A3FF"></path>
                                            <path class="permanent"
                                                d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                fill="white"></path>
                                        </svg>
                                    </span></span>
                            </h3>
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                    <h1 class="text-warning mt-4 mb-4">
                                        <b><span id="average_rating">0.0</span> / 5</b>
                                    </h1>
                                    <div class="mb-3">
                                        <i class="fas fa-star star-light mr-1 main_star"></i>
                                        <i class="fas fa-star star-light mr-1 main_star"></i>
                                        <i class="fas fa-star star-light mr-1 main_star"></i>
                                        <i class="fas fa-star star-light mr-1 main_star"></i>
                                        <i class="fas fa-star star-light mr-1 main_star"></i>
                                    </div>
                                    <h3><span id="total_review">0</span> Review</h3>
                                </div>
                                <div class="col-sm-8">
                                    <p>
                                    <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i>
                                    </div>

                                    <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i>
                                    </div>

                                    <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i>
                                    </div>

                                    <div class="progress-label-right">(<span id="total_three_star_review">0</span>)
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i>
                                    </div>

                                    <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i>
                                    </div>

                                    <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                                    </div>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-5" id="review_content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <div class="mb-10 text-center">
                    <h1 class="mb-3">Thanh Toán</h1>
                    <div class="text-muted fw-bold fs-5">Vui lòng nhập số lượng cần mua</div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row">
                    <input type="number" class="form-control form-control-solid" onchange="totalPayment()"
                        onkeyup="totalPayment()" placeholder="Nhập số lượng cần mua" id="amount" />
                    <input type="hidden" value="" readonly class="form-control" id="modal-id">
                    <input type="hidden" value="" readonly class="form-control" id="price">
                    <input class="form-control" type="hidden" id="token" value="<?=$getUser['token'];?>">
                </div>
                <div class="mb-10 text-center" style="font-size: 15px;">Tổng tiền cần thanh toán: <b id="total"
                        style="color:red;">0</b></div>
                <div class="text-center">
                    <button type="submit" id="btnBuy" onclick="buyProduct()" class="btn btn-primary">Thanh
                        Toán</span></button>
                    <button type="button" data-dismiss="modal" class="btn btn-light me-3">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once(__DIR__.'/footer.php');?>
<script>
load_rating_data();
function load_rating_data() {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/rating.php');?>",
        method: "POST",
        data: {
            profile_ctv: 'profile_ctv',
            user_id: <?=$row['id'];?>
        },
        dataType: "JSON",
        success: function(data) {
            $('#average_rating').text(data.average_rating);
            $('#total_review').text(data.total_review);
            var count_star = 0;
            $('.main_star').each(function() {
                count_star++;
                if (Math.ceil(data.average_rating) >= count_star) {
                    $(this).addClass('text-warning');
                    $(this).addClass('star-light');
                }
            });

            $('#total_five_star_review').text(data.five_star_review);

            $('#total_four_star_review').text(data.four_star_review);

            $('#total_three_star_review').text(data.three_star_review);

            $('#total_two_star_review').text(data.two_star_review);

            $('#total_one_star_review').text(data.one_star_review);

            $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');

            $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');

            $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 +
                '%');

            $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');

            $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');

            if (data.review_data.length > 0) {
                var html = '';

                for (var count = 0; count < data.review_data.length; count++) {
                    html += '<div class="row mb-3">';
                    html +=
                        '<div class="col-sm-1"><div class="rounded-circle bg-danger text-white pt-6 pb-6"><h3 class="text-center">' +
                        data.review_data[count].user_name.charAt(0) + '</h3></div></div>';
                    html += '<div class="col-sm-11">';
                    html += '<div class="card">';
                    html += '<div class="card-header"><h5>Khách hàng <b>' + data.review_data[count]
                        .user_name + '</b> đánh giá về sản phẩm <b>' + data.review_data[count]
                        .product_name + '</b></h5></div>';
                    html += '<div class="card-body">';
                    for (var star = 1; star <= 5; star++) {
                        var class_name = '';

                        if (data.review_data[count].rating >= star) {
                            class_name = 'text-warning';
                        } else {
                            class_name = 'star-light';
                        }

                        html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                    }

                    html += '<br />';

                    html += data.review_data[count].review;

                    html += '</div>';

                    html += '<div class="card-footer text-right">' + data.review_data[count].datetime +
                        '</div>';

                    html += '</div>';

                    html += '</div>';

                    html += '</div>';
                }

                $('#review_content').html(html);
            }
        }
    })
}
</script>
<script type="text/javascript">
function modalBuy(id, price) {
    $("#modal-id").val(id);
    $("#price").val(price);
    $("#modalBuy").modal();
}

function totalPayment() {
    var price = $("#price").val();
    var amount = $("#amount").val();
    var total = 0;
    total = amount * price;
    $("#total").html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
}

function buyProduct() {
    var id = $("#modal-id").val();
    var amount = $("#amount").val();
    var token = $("#token").val();
    $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/buyProduct.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: token,
            id: id,
            amount: amount
        },
        success: function(data) {
            $('#btnBuy').html('Thanh Toán').prop('disabled', false);
            if (data.status == 'success') {
                cuteToast({
                    type: "success",
                    message: data.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('client/orders');?>';", 1000);
            } else {
                cuteToast({
                    type: "error",
                    message: data.msg,
                    timer: 5000
                });
            }
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }
    });
}
</script>