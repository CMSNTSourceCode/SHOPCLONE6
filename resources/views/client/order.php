<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Chi tiết đơn hàng').' | '.$CMSNT->site('title'),
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_user.php');
if (isset($_GET['trans_id'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `orders` WHERE `trans_id` = '".check_string($_GET['trans_id'])."' AND `buyer` = '".$getUser['id']."' ")) {
        redirect(base_url('client/orders'));
    }
} else {
    redirect(base_url('client/orders'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Chi tiết đơn hàng');?> #<?=$row['trans_id'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="copyALL" rows="10" class="form-control" readonly><?php $i=0; foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `trans_id` = '".$row['trans_id']."' ORDER BY id DESC ") as $taikhoan) {
    echo $taikhoan['account'].PHP_EOL;
}?></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=__('Đóng');?></button>
                <button type="button" onclick="copy()" data-clipboard-target="#copyALL"
                    class="btn btn-primary copy"><?=__('Sao Chép');?></button>
            </div>
        </div>
    </div>
</div>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 text-left">
                <div class="mb-3">
                    <a href="<?=base_url('client/orders');?>" type="button" class="btn btn-danger btn-sm"><i
                            class="fas fa-arrow-left mr-1"></i><?=__('Quay Lại');?></a>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                <div class="mb-3">
                    <?php if($row['product_id'] != 0):?>
                    <button class="btn btn-info btn-sm btn-icon-left m-b-10"
                        onclick="downloadFile(`<?=$row['trans_id'];?>`, `<?=$getUser['token'];?>`)" type="button"><i
                            class="fas fa-cloud-download-alt mr-1"></i><?=__('Tải Về');?></button>
                    <button class="btn btn-primary btn-sm btn-icon-left m-b-10" data-toggle="modal"
                        data-target="#exampleModal" type="button"><i
                            class="fas fa-copy mr-1"></i><?=__('Sao Chép Tất Cả');?></button>
                    <?php endif?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Chi tiết đơn hàng');?> #<?=$_GET['trans_id'];?></h4>
                        </div>
                    </div>
                    <?php if($row['product_id'] != 0):?>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-hover mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Thông tin tài nguyên');?></th>
                                        <th width="20%"><?=__('Thao tác');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `trans_id` = '".$row['trans_id']."' ORDER BY id DESC ") as $taikhoan) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><textarea rows="1" class="form-control" id="coypy<?=$taikhoan['id'];?>"
                                                readonly><?=$taikhoan['account'];?></textarea></td>
                                        <td>
                                            <?php
                                            $file_backup = base_url('assets/storage/backup/'.explode("|", $taikhoan['account'])[0].'.zip');
                                            if (file_exists($file_backup)):?>
                                            <a type="button" target="_blank"
                                                href="<?=$file_backup;?>"
                                                class="btn btn-primary btn-sm"><i
                                                    class="fas fa-file-download mr-1"></i><?=__('Download Backup');?></a>
                                            <?php endif?>
                                            <button type="button" onclick="copy()"
                                                data-clipboard-target="#coypy<?=$taikhoan['id'];?>"
                                                class="btn btn-danger btn-sm copy"><i
                                                    class="fas fa-copy mr-1"></i><?=__('Sao chép');?></button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php elseif($row['document_id'] != 0):?>
                    <div class="card-body">
                        <h2 class="text-center"><?=getRowRealtime("documents", $row['document_id'], 'name');?></h2>
                        <div class="float-right">
                            <i><?=__('Tác giả');?>: Admin</i><br>
                            <i><?=__('Cập nhật');?>:
                                <?=getRowRealtime("documents", $row['document_id'], 'update_date');?></i>
                        </div>
                        <br><br>
                        <?=getRowRealtime("documents", $row['document_id'], 'content');?>
                    </div>
                    <?php endif?>
                </div>
            </div>
            <?php if($CMSNT->site('display_rating') == 1):?>
            <div class="col-lg-12">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <h3 class="card-title align-items-start flex-column">
                            <?php if($row['product_id'] != 0):?>
                            <span class="card-label"><?=__('Đánh giá sản phẩm');?> <i style="font-size: 20px;">'
                                    <?=getRowRealtime("products", $row['product_id'], 'name');?>'</i></span>
                            <?php elseif($row['document_id'] != 0):?>
                            <span class="card-label"><?=__('Đánh giá sản phẩm');?> <i style="font-size: 20px;">'
                                    <?=getRowRealtime("documents", $row['document_id'], 'name');?>'</i></span>
                            <?php endif ?>
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
                            <div class="col-sm-4">
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
                            <div class="col-sm-4 text-center">
                                <h4 class="mt-4 mb-3">
                                    <?=$row['pay'] >= $CMSNT->site('min_rating') ? __('Bạn có thể đánh giá đơn hàng này') : __('Đơn hàng lớn hơn').' '.format_currency($CMSNT->site('min_rating')).' '.__('mới có thể đánh giá');?>
                                </h4>
                                <button type="button" name="add_review" id="add_review"
                                    <?=$row['pay'] >= $CMSNT->site('min_rating') ? '' : 'disabled';?>
                                    class="btn btn-sm btn-primary"><i
                                        class="fas fa-meh-rolling-eyes mr-1"></i><?=__('Đánh giá ngay');?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5" id="review_content"></div>
            </div>
            <?php endif?>
        </div>
    </div>
</div>






<?php if($CMSNT->site('display_rating') == 1):?>
<div id="review_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=__('Gửi Đánh Giá');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mt-2 mb-4">
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                </h4>
                <div class="form-group">
                    <?php if($row['product_id'] != 0):?>
                    <input id="product_id" type="hidden" value="<?=$row['product_id'];?>" readonly>
                    <?php elseif($row['document_id'] != 0):?>
                    <input id="document_id" type="hidden" value="<?=$row['document_id'];?>" readonly>    
                    <?php endif?>
                    <input id="order_id" type="hidden" value="<?=$row['id'];?>" readonly>
                    <input id="token" type="hidden" value="<?=$getUser['token'];?>" readonly>
                    <textarea name="user_review" id="user_review" class="form-control"
                        placeholder="<?=__('Nhập nội dung cần đánh giá');?>"></textarea>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="button" class="btn btn-primary" id="save_review"><?=__('Xác Nhận');?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>


<?php require_once(__DIR__.'/footer.php');?>

<script type="text/javascript">
function downloadTXT(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}

function downloadFile(transid, token) {
    cuteAlert({
        type: "question",
        title: "<?=__('Xác nhận tải về đơn hàng');?> #" + transid,
        message: "<?=__('Bạn có chắc chắn muốn tải về hàng này không');?>",
        confirmText: "<?=__('Đồng Ý');?>",
        cancelText: "<?=__('Hủy');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/client/downloadOrder.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    transid: transid,
                    token: token
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        downloadTXT(respone.filename, respone.accounts);
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
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>


<?php if($CMSNT->site('display_rating') == 1):?>
    
<script>
var rating_data = 0;
$('#add_review').click(function() {
    $('#review_modal').modal('show');
});
$(document).on('mouseenter', '.submit_star', function() {
    var rating = $(this).data('rating');
    reset_background();
    for (var count = 1; count <= rating; count++) {
        $('#submit_star_' + count).addClass('text-warning');
    }
});

function reset_background() {
    for (var count = 1; count <= 5; count++) {

        $('#submit_star_' + count).addClass('star-light');

        $('#submit_star_' + count).removeClass('text-warning');
    }
}
$(document).on('mouseleave', '.submit_star', function() {
    reset_background();
    for (var count = 1; count <= rating_data; count++) {
        $('#submit_star_' + count).removeClass('star-light');
        $('#submit_star_' + count).addClass('text-warning');
    }
});
$(document).on('click', '.submit_star', function() {
    rating_data = $(this).data('rating');
});
$('#save_review').click(function() {
    var user_review = $('#user_review').val();
    if (user_review == '') {
        alert("<?=__('Vui lòng nhập review');?>");
        return false;
    } else {
        $('#save_review').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop(
            'disabled',
            true);
        $.ajax({
            url: "<?=BASE_URL('ajaxs/client/rating.php');?>",
            method: "POST",
            dataType: "JSON",
            data: {
                rating_data: rating_data,
                token: $('#token').val(),
                order_id: $('#order_id').val(),
                product_id: $('#product_id').val(),
                document_id: $('#document_id').val(),
                user_review: user_review
            },
            success: function(respone) {
                if (respone.status == 'success') {
                    cuteToast({
                        type: "success",
                        message: respone.msg,
                        timer: 5000
                    });
                    load_rating_data();
                } else {
                    cuteToast({
                        type: "error",
                        message: respone.msg,
                        timer: 5000
                    });
                }
                $('#review_modal').modal('hide');
            }
        })
        $('#save_review').html('<?=__('Xác Nhận');?>').prop('disabled', false);
    }
});
load_rating_data();

function load_rating_data() {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/rating.php');?>",
        method: "POST",
        data: {
            action: 'load_data',
            product_id: <?=$row['product_id'];?>
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

                    html += '<div class="col-sm-12">';
                    html += '<div class="card">';
                    html += '<div class="card-header"><div><h4>' + data.review_data[count].user_name +
                        '</h4></div>';
                    html += '<div class="text-right">';
                    for (var star = 1; star <= 5; star++) {
                        var class_name = '';

                        if (data.review_data[count].rating >= star) {
                            class_name = 'text-warning';
                        } else {
                            class_name = 'star-light';
                        }

                        html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                    }
                    html += '</div></div>';
                    html += '<br /><div class="card-body">';

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
<?php endif?>

<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
</script>