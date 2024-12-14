<?php
define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {?>

<style>
.ribbon-wrapper.ribbon-lg .ribbon {
    right: 0;
    top: 26px;
    width: 150px;
}

.ribbon-wrapper .ribbon {
    box-shadow: 0 0 3px rgb(0 0 0 / 30%);
    font-size: .8rem;
    line-height: 100%;
    padding: 0.375rem 0;
    position: relative;
    right: -2px;
    text-align: center;
    text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
    text-transform: uppercase;
    top: 10px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    width: 90px;
}

.ribbon-wrapper.ribbon-lg {
    height: 120px;
    width: 120px;
}

.ribbon-wrapper {
    height: 70px;
    overflow: hidden;
    position: absolute;
    right: 12px;
    top: -2px;
    width: 70px;
    z-index: 10;
}
</style>
<style>
.ribbon-wrapper.ribbon-lg .ribbon {
    right: 0;
    top: 26px;
    width: 150px;
}

.ribbon-wrapper .ribbon {
    box-shadow: 0 0 3px rgb(0 0 0 / 30%);
    font-size: .8rem;
    line-height: 100%;
    padding: 0.375rem 0;
    position: relative;
    right: -2px;
    text-align: center;
    text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
    text-transform: uppercase;
    top: 10px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    width: 90px;
}

.ribbon-wrapper.ribbon-lg {
    height: 120px;
    width: 120px;
}

.ribbon-wrapper {
    height: 70px;
    overflow: hidden;
    position: absolute;
    right: 12px;
    top: -2px;
    width: 70px;
    z-index: 10;
}
</style>
<style>
.thumbnail-mobile {
    width: 32px;
    height: 24px;
    overflow: hidden;
    border: 1px solid #e5e5e5;
}

.thumbnail-mobile img {
    width: 100%;
    height: 100%;
    transition-duration: 0.1s;
}

.thumbnail-mobile img:hover {
    position: absolute;
    width: 350px;
    height: 210px;
    right: -20px;
    border: 3px solid #00ac15;
    border-radius: 9px;
    z-index: 1000;
}
</style>

<div class="row">
    <?php
    $where = '';
    if ($_POST['id'] == 0) {
        $where = '';
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ORDER BY `stt` ASC ");
    } else {
        $where = " AND `id` =  '".check_string($_POST['id'])."' ";
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `category_id` = '".check_string($_POST['id'])."' AND `status` = 1 ORDER BY `stt` ASC  ");
    }
    if ($listProduct) {  
?>





    <?php // LIST ?>
    <?php if($CMSNT->site('type_showProduct') == 2):?>
    <style>
    /* CSS cho các thiết bị có chiều rộng màn hình nhỏ hơn hoặc bằng 600px */
    @media only screen and (max-width: 600px) {
        .hidemobile {
            display: none;
        }
    }
    </style>

    <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 $where ORDER BY `stt` ASC ") as $category):?>
    <div class="col-sm-12 col-md-12 col-lg-12 mt-12 mt-md-3 p-0 ">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-color-heading" style="background:<?=$CMSNT->site('theme_color');?>;color:white;">
                    <tr>
                        <th><img src="<?=base_url($category['image']);?>" width="30px"
                                class="mr-2" /><?=__($category['name']);?></th>
                        <!-- <?php if($CMSNT->site('display_rating') == 1):?>
                        <th class="text-center hidemobile" width="10%"><?=__('Đánh giá');?></th>
                        <?php endif?> -->
                        <?php if($CMSNT->site('display_country') == 1):?>
                        <th class="text-center hidemobile" width="10%"><?=__('Quốc gia');?></th>
                        <?php endif?>
                        <?php if($CMSNT->site('display_preview') == 1):?>
                        <th class="text-center hidemobile" width="10%"><?=__('Xem trước');?></th>
                        <?php endif?>
                        <th class="text-center hidemobile" width="10%"><?=__('Hiện có');?></th>
                        <?php if ($CMSNT->site('display_sold') == 1) {?>
                        <th class="text-center hidemobile" width="10%"><?=__('Đã bán');?></th>
                        <?php }?>
                        <th class="text-center hidemobile" width="10%"><?=__('Giá');?></th>
                        <th class="text-center hidemobile" width="10%"><?=__('Thao tác');?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product) {?>
                    <?php
                    $conlai = $product['id_connect_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                    if($CMSNT->site('hide_product_empty') == 1){
                        if($conlai == 0){
                            continue;
                        }
                    }?>

                    <tr>
                        <td>
                            <div class="col-product-name">
                                <img class="mr-1 py-1 d-none-600"
                                    src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>">
                                <div class="name-product">
                                    <h3><?=__($product['name']);?></h3>
                                    <div class="content-mota">
                                        <?=__($product['content']);?>
                                    </div>
                                    <div class="d-none-more-than-601">
                                        <div class="col-md-12 p-0 mt-2">
                                            <span class="btn mb-1 btn-sm btn-outline-danger">
                                                <i class="far fa-money-bill-alt mr-1"></i>
                                                <b><?=format_currency($product['price']);?></b>
                                            </span>
                                            <span class="btn mb-1 btn-sm btn-outline-info">
                                                <?=__('Còn lại:');?>
                                                <b><?=format_cash($conlai);?></b>
                                            </span>
                                            <?php if ($CMSNT->site('display_sold') == 1):?>
                                            <span class="btn mb-1 btn-sm btn-outline-info">
                                                <?=__('Đã bán:');?>
                                                <b><?=format_cash($product['sold']);?></b>
                                            </span>
                                            <?php endif?>
                                            <?php if($CMSNT->site('display_country') == 1):?>
                                            <span class="btn mb-1 btn-sm btn-outline-warning p-0">
                                                <?=getFlag($product['flag']);?>
                                            </span>
                                            <?php endif?>
                                            <?php if($CMSNT->site('display_preview') == 1 && $product['preview'] != ''):?>
                                            <span class="btn mb-1 btn-sm btn-outline-success">
                                                <div class="thumbnail-mobile">
                                                    <img src="<?=base_url($product['preview']);?>">
                                                </div>
                                            </span>
                                            <?php endif?>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            <?php if($conlai == 0){?>
                                            <button class="btn btn-block btn-sm btn-secondary" disabled="">
                                                <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                                            </button>
                                            <?php }else{?>
                                            <button class="btn btn-block btn-sm btn-primary"
                                                onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                                                <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                                            </button>
                                            <?php }?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php if($CMSNT->site('display_country') == 1):?>
                        <td class="text-center d-none-600">
                            <?=getFlag($product['flag']);?>
                        </td>
                        <?php endif?>
                        <?php if($CMSNT->site('display_preview') == 1):?>
                        <td class="text-center d-none-1100">
                            <?php if($product['preview'] != ''):?>
                            <span class="btn mb-1 btn-sm btn-outline-success">
                                <div class="thumbnail">
                                    <img src="<?=base_url($product['preview']);?>">
                                </div>
                            </span>
                            <?php endif?>
                        </td>
                        <?php endif?>
                        <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-info">
                                <?=__('Còn lại:');?>
                                <b><?=format_cash($conlai);?></b>
                            </span></td>
                        <?php if ($CMSNT->site('display_sold') == 1):?>
                        <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-info">
                                <?=__('Đã bán:');?>
                                <b><?=format_cash($product['sold']);?></b>
                            </span></td>
                        <?php endif?>
                        <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-danger">
                                <i class="far fa-money-bill-alt mr-1"></i>
                                <b><?=format_currency($product['price']);?></b>
                            </span>
                        </td>
                        <td class="text-center d-none-600">
                            <?php if($conlai == 0){?>
                            <button class="btn btn-block btn-sm btn-secondary" disabled="">
                                <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                            </button>
                            <?php }else{?>
                            <button class="btn btn-block btn-sm btn-primary"
                                onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                                <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                            </button>
                            <?php }?>
                        </td>
                    </tr>

                    <?php }?>


                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach?>
    <?php endif?>





    <?php // BOX 1 ?>
    <?php if($CMSNT->site('type_showProduct') == 1):?>
    <?php
    // BOX 1
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 $where ORDER BY `stt` ASC ") as $category):?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-product d-flex justify-content-between" id="<?= $category['id']; ?>"
                style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
                <div class="header-title">
                    <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>"
                            width="30px" class="mr-2" /><?=__($category['name']);?></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                    <?php
    $conlai = $product['id_connect_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    if($CMSNT->site('hide_product_empty') == 1){
        if($conlai == 0){
            continue;
        }
    }
    ?>
                    <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mt-md-3">
                        <div class="basic-drop-shadow p-3 shadow-showcase">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <p><img class="mr-1"
                                            src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>"
                                            width="25px"><b><?=__($product['name']);?></b>
                                        <?=$product['preview'] != null ? '<a href="'.base_url($product['preview']).'" target="_blank"><i class="fas fa-search"></i></a>' : '';?>
                                    </p>
                                    <p style="font-size: 12px;"><i
                                            class="fas fa-angle-right mr-1"></i><i><?=__($product['content']);?></i></p>
                                </div>
                                <div class="col-md-7">
                                    <span class="btn mb-1 btn-sm btn-outline-danger">
                                        <?=__('Giá:');?>
                                        <b><?=format_currency($product['price']);?></b>
                                    </span>
                                    <span class="btn mb-1 btn-sm btn-outline-info">
                                        <?=__('Còn lại:');?>
                                        <b><?=format_cash($conlai);?></b>
                                    </span>
                                    <?php if ($CMSNT->site('display_sold') == 1):?>
                                    <span class="btn mb-1 btn-sm btn-outline-success">
                                        <?=__('Đã bán:');?>
                                        <b><?=format_cash($product['sold']);?></b>
                                    </span>
                                    <?php endif?>
                                    <?php if($CMSNT->site('display_country') == 1):?>
                                    <span class="btn mb-1 btn-sm btn-outline-warning">
                                        <?=__('Quốc gia:');?>
                                        <?=getFlag($product['flag']);?>
                                    </span>
                                    <?php endif?>
                                    <?php if($CMSNT->site('display_preview') == 1 && $product['preview'] != ''):?>
                                    <span class="btn mb-1 btn-sm btn-outline-success">
                                        <div class="thumbnail-mobile">
                                            <img src="<?=base_url($product['preview']);?>">
                                        </div>
                                    </span>
                                    <?php endif?>
                                </div>
                                <div class="col-md-5">
                                    <?php if($CMSNT->site('display_rating') == 1):?>
                                    <div class="mb-2"></div>
                                    <?php
                        // tổng rating
                        $total_review = $CMSNT->get_row("SELECT COUNT(id) FROM `reviews` WHERE `product_id` = '".$product['id']."' ")['COUNT(id)'];
                        // tổng số sao
                        $total_user_rating = $CMSNT->get_row("SELECT SUM(`rating`) FROM `reviews` WHERE `product_id` = '".$product['id']."' ")['SUM(`rating`)'];
                        // không có review thì 0 sao
                        if ($total_review == 0) {
                            $average_rating = 5;
                        } else {
                            // tính trung bình số sao
                            $average_rating = number_format($total_user_rating / $total_review, 1);
                        }
                        ?>
                                    <div class="text-center">
                                        <i
                                            class="fas fa-star <?=$average_rating >= 1 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                        <i
                                            class="fas fa-star <?=$average_rating >= 2 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                        <i
                                            class="fas fa-star <?=$average_rating >= 3 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                        <i
                                            class="fas fa-star <?=$average_rating >= 4 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                        <i
                                            class="fas fa-star <?=$average_rating >= 5 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                    </div>
                                    <?php endif?>
                                    <div class="mb-4"></div>
                                    <?php if($conlai == 0){?>
                                    <button class="btn btn-block btn-secondary" disabled>
                                        <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                                    </button>
                                    <?php }else{?>
                                    <button class="btn btn-block btn-primary"
                                        onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)">
                                        <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                                    </button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach?>
    <?php endif?>


    <?php if($CMSNT->site('type_showProduct') == 'BOX2'):?>
    <style>
    .custom-block {
        padding: 0;
    }

    .custom-block .custom-control-label2:hover {
        color: #403E10;
        box-shadow: <?=$CMSNT->site('theme_color');
        ?>-1px 1px,
        <?=$CMSNT->site('theme_color');
        ?>-2px 2px,
        <?=$CMSNT->site('theme_color');
        ?>-3px 3px,
        <?=$CMSNT->site('theme_color');
        ?>-4px 4px,
        <?=$CMSNT->site('theme_color');
        ?>-5px 5px,
        <?=$CMSNT->site('theme_color');
        ?>-6px 6px;
        transform: translate3d(6px, -6px, 0);
        transition-delay: 0s;
        transition-duration: 0.4s;
        transition-property: all;
        transition-timing-function: line;
    }

    .custom-control {
        position: relative;
        display: block;
        min-height: 1.5rem;
    }

    .custom-block .custom-control-label2 {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid <?=$CMSNT->site('theme_color');
        ?>;
        border-radius: 0.2rem;
        cursor: pointer;
    }

    .p-2 {
        padding: 0.5rem !important;
    }

    .custom-control-label2 {
        position: relative;
        margin-bottom: 0;
        vertical-align: top;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ml-2,
    .mx-2 {
        margin-left: 0.5rem !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .font-size-sm {
        font-size: .875rem !important;
    }

    .d-block {
        display: block !important;
    }

    .font-size-sm {
        font-size: .875rem !important;
    }

    .bg-black-5 {
        background-color: rgba(0, 0, 0, .05) !important;
    }

    .item {
        display: -webkit-box;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        width: 4rem;
        height: 4rem;
        -webkit-transition: opacity .25s ease-out, -webkit-transform .25s ease-out;
        transition: opacity .25s ease-out, -webkit-transform .25s ease-out;
        transition: opacity .25s ease-out, transform .25s ease-out;
        transition: opacity .25s ease-out, transform .25s ease-out, -webkit-transform .25s ease-out;
    }

    .item.item-circle {
        border-radius: 50%;
        border: 1px solid <?=$CMSNT->site('theme_color');
        ?>;
    }

    .custom-control-primary.custom-block .custom-block-indicator,
    .custom-control-primary.custom-radio .custom-control-input:checked~.custom-control-label2:before {
        background-color: #0665d0;
    }

    .font-w700 {
        font-weight: 700 !important;
    }
    </style>
    <?php
    // BOX 2 
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 $where ORDER BY `stt` ASC ") as $category):?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-product d-flex justify-content-between" id="<?= $category['id']; ?>"
                style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
                <div class="header-title">
                    <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>"
                            width="30px" class="mr-2" /><?=__($category['name']);?></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                    <?php
    $conlai = $product['id_connect_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    if($CMSNT->site('hide_product_empty') == 1){
        if($conlai == 0){
            continue;
        }
    }
    ?>
                    <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mt-md-3">
                        <div class="custom-control custom-block custom-control-primary"
                            onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                            <div class="custom-control-label2 p-2">
                                <span class="d-flex align-items-center">
                                    <div class="item item-circle bg-black-5 text-primary-light"
                                        style="min-width: 60px;">
                                        <?php if($conlai == 0):?>
                                        <span class="text-danger text-center font-weight-bolder"
                                            style="font-size: 9px;"><?=__('SOLD OUT');?></span>
                                        <?php else:?>
                                        <span class="text-primary text-center font-weight-bolder"
                                            style="font-size: 14px;"><?=format_cash($conlai);?></span>
                                        <?php endif?>
                                    </div>
                                    <span class="text-truncate ml-2">
                                        <span class="font-w700"><span
                                                style="font-weight: bold;"><?=$product['preview'] != null ? '<a href="'.base_url($product['preview']).'" target="_blank"><i style="position:absolute;right:5px;bottom:10px;" class="fas fa-search"></i></a>' : '';?><?=__($product['name']);?></span></span>
                                        <br><span
                                            class="d-block font-size-sm text-muted"><?=__($product['content']);?></span>
                                        <i style="position:absolute;right:5px;bottom:10px;"
                                            class="fa fa-question-circle text-muted js-tooltip-enabled"
                                            onmouseover="info(`<?=__($product['content']);?>`)"></i>
                                        <span class="d-block font-size-sm text-muted"><i class="font-w400"
                                                style="font-size: 0.77rem;"><del><?=format_currency($product['price'] + $product['price'] * 10 / 100);?></del></i>
                                            <strong class="text-danger">»
                                                <?=format_currency($product['price']);?></strong></span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach?>
    <script>
    function info(content) {
        Swal.fire('<?= __('Thông tin'); ?>',
            content);
    }

    function hideModal() {
        $("#myModal").hide();
    }
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("closeModal")[0];
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
    <?php endif?>


    <?php if($CMSNT->site('type_showProduct') == 'BOX3'):?>
    <style>
    .list-category {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .content-heading {
            margin-bottom: 1.5rem;
            padding-top: 2.5rem;
        }
    }

    .content-heading {
        margin-bottom: 0.875rem;
        padding-top: 2rem;
        padding-bottom: 0.5rem;
        font-size: 1.125rem;
        font-weight: 500;
        line-height: 1.75;
        border-bottom: 1px solid #e4e7ed;
    }

    @media (min-width: 768px) {
        .content-heading {
            margin-bottom: 1.5rem;
            padding-top: 2.5rem;
        }
    }

    .content-heading {
        margin-bottom: 0.875rem;
        padding-top: 2rem;
        padding-bottom: 0.5rem;
        font-size: 1.125rem;
        font-weight: 500;
        line-height: 1.75;
        border-bottom: 1px solid #e4e7ed;
    }

    .block.block-rounded>.block-content:last-child {
        border-bottom-right-radius: 0.875rem 1rem;
        border-bottom-left-radius: 0.875rem 1rem;
    }

    .block-content.block-content-full {
        padding-bottom: 1.625rem;
    }

    .block-content.block-content-full {
        padding-bottom: 1.625rem;
    }

    .block-content {
        transition: opacity .2s ease-out;
        width: 100%;
        margin: 0 auto;
        padding: 1.625rem 1.625rem 1px;
        overflow-x: visible;
    }

    .block-content {
        transition: opacity .2s ease-out;
        width: 100%;
        margin: 0 auto;
        padding: 1.625rem 1.625rem 1px;
        overflow-x: visible;
    }

    .action:hover {
        transform: scale(1.1);

    }

    .fw-semibold {
        font-weight: 400 !important;
    }

    .fs-3 {
        font-size: calc(1.275rem + .3vw) !important;
    }

    .hvr-underline-from-center {
        display: inline-block;
        vertical-align: middle;
        -webkit-transform: perspective(1px) translateZ(0);
        transform: perspective(1px) translateZ(0);
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    @media (min-width: 1200px) {
        .fs-3 {
            font-size: 1.5rem !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        .fs-3 {
            font-size: calc(1.275rem + .3vw) !important;
        }
    }

    @media (min-width: 1200px) {
        .fs-3 {
            font-size: 1.5rem !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        .fs-3 {
            font-size: calc(1.275rem + .3vw) !important;
        }

        .col-xl-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }
    }

    .table td,
    .table th {
        vertical-align: middle;
        border: 0px #6d93bd5e solid;
    }
    </style>
    <?php
    // BOX 3
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 $where ORDER BY `stt` ASC ") as $category):?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-product d-flex justify-content-between" id="<?= $category['id']; ?>"
                style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
                <div class="header-title">
                    <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>"
                            width="30px" class="mr-2" /><?=__($category['name']);?></h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                    <?php
    $conlai = $product['id_connect_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    if($CMSNT->site('hide_product_empty') == 1){
        if($conlai == 0){
            continue;
        }
    }
    ?>


                    <div class="col-lg-6 col-xl-4">
                        <a class="card action" style="border: 2px solid #e9ecef;">
                            <div class="block-content block-content-full" style="padding: 0;">

                                <table class="table table-borderless table-vcenter">
                                    <tbody>
                                        <tr>
                                            <td class="text-center" style="width: 20%;">
                                                <div class="fs-3 fw-semibold"
                                                    style="background: <?=$CMSNT->site('theme_color');?>;color: white;font-size:1px; border-radius: 100%;width: 5rem;height: 5rem;display: flex;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;justify-content: center;text-align: center;margin: 0 auto;">
                                                    <?=$conlai > 0 ? format_cash($conlai) : '<img style="width: 120%;" src="'.base_url().'resources/images/sold.png">' ?>
                                                </div>
                                            </td>
                                            <td class="fs-sm text-muted">

                                                <div class="text-muted my-1" style="font-size:17px;">
                                                    <?= __($product['name']); ?></div>
                                                <div class="text-muted my-1"><span
                                                        class="d-block font-size-sm text-muted">
                                                        <strong style="font-size:11px"
                                                            class="text-secondary"><del><?= format_currency($product['price'] + $product['price'] * 10 / 100); ?></del></strong>
                                                        <strong class="text-danger" style="font-size:14px">»
                                                            <?= format_currency($product['price']); ?></strong></span>
                                                </div>
                                                <div class="fs-sm">
                                                    <a class="btn btn-sm btn-outline-secondary"
                                                        href="javascript:void(0)"
                                                        onclick="info(`<?= $product['content']; ?>`)">
                                                        <i class="fa fa-circle-info opacity-50 me-1"></i>
                                                        <?=__('Thông tin');?></a>
                                                    <a class="btn btn-sm btn-outline-primary" href="javascript:void(0)"
                                                        onclick="modalBuy(<?= $product['id']; ?>, <?= $product['price']; ?>, `<?= __($product['name']); ?>`)">
                                                        <i class="fa fa-cart-shopping opacity-50 me-1"></i>
                                                        <?=__('MUA NGAY');?>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <script>
    function info(content) {
        Swal.fire('<?= __('Thông tin'); ?>',
            content);
    }

    function hideModal() {
        $("#myModal").hide();
    }
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("closeModal")[0];
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
    <?php endif?>


    <?php if($CMSNT->site('type_showProduct') == 'BOX4'):?>
    <style>
    .row.row2 {
        margin-top: calc(-.5 * var(--bs-gutter-x));
        margin-bottom: calc(-.5 * var(--bs-gutter-x));
    }

    .product {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px 0 rgb(0 0 0 / 10%);
        overflow: hidden;
        border: 1px solid var(--bs-border-color)
    }

    .product .product-head {
        display: flex;
        border-bottom: 1px solid var(--bs-border-color);
        padding: 15px;
        background: #f5f5f5
    }

    .product .product-head img {
        height: 40px
    }

    .product .product-head h4 {
        width: calc(100% - 40px);
        padding: 0 20px;
        font-size: 16px;
        font-weight: 700;
        margin: 0
    }

    .product .product-body {
        border-bottom: 1px solid #e1ecf8;
        padding: 15px;
        min-height: 186px
    }

    .product .product-body p {
        margin-bottom: 10px;
        font-size: 14px
    }

    .product .product-body p i {
        color: #558b2f;
        vertical-align: bottom;
        margin-right: 10px
    }

    .product .product-footer {
        padding: 15px;
        border-bottom: 1px solid #e1ecf8
    }

    .product .product-footer strong {
        display: block;
        font-size: 12px;
        margin-bottom: 5px
    }

    .product .product-footer img {
        height: 20px
    }

    .product .product-footer .border-end {
        border-right: 1px solid #e1ecf8 !important
    }

    .product .product-buttons-box4 {
        padding: 15px
    }

    .product .price {
        text-align: right
    }

    .product .price strong {
        font-size: 18px;
        color: #f5b907;
        margin: 0
    }

    .product .price span {
        text-decoration: line-through;
        font-size: 14px;
        color: #c2c2c2;
        font-weight: 500
    }

    .buy-btn {
        background: linear-gradient(135deg, <?=$CMSNT->site('theme_color'); ?> 0, <?=$CMSNT->site('theme_color2'); ?> 100%);
        border: 0;
        color: #fff !important;
        box-shadow: 0 0 15px 0 rgb(0 0 0 / 10%);
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        font-weight: 600
    }



    .dark .product .product-head {
        background: #324253;
    }

    .dark .product {
        background: #181818;
    }

    .dark .border,
    .dark .border-bottom {
        border-color: #ffffff !important;

    }

    .dark .product-buttons-box4 {
        border-color: #ffffff !important;
        color: #ffffff;
    }

    .dark .text-dark {
        color: #ffffff !important;
    }
    </style>
    <?php
    // BOX 4
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 $where ORDER BY `stt` ASC ") as $category):?>
    <div class="col-lg-12 mb-3">
        <div>
            <div class="card">
                <div class="card-header card-product d-flex justify-content-between" id="<?= $category['id']; ?>"
                    style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
                    <div class="header-title">
                        <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>"
                                width="30px" class="mr-2" /><?=__($category['name']);?></h5>
                    </div>
                </div>
            </div>
            <div>
                <div class="row row2">
                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                    <?php
    $conlai = $product['id_connect_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    if($CMSNT->site('hide_product_empty') == 1){
        if($conlai == 0){
            continue;
        }
    }
    ?>
                    <div class="prod-item col-sm-6 col-md-4 col-xl-3 mb-3"
                        data-title="Tri Ân Khách Hàng  Via XMDT Live Ads">
                        <div class="product">
                            <div class="product-head">
                                <img src="<?=base_url($category['image']);?>" />
                                <h4><?=__($product['name']);?> </h4>
                            </div>
                            <div class="product-body">
                                <?php foreach(explode(PHP_EOL, $product['content']) as $bf2):?>
                                <p><i class="fa-solid fa-circle-check"></i> <?=$bf2;?></p>
                                <?php endforeach?>
                            </div>

                            <div class="product-footer">
                                <div class="row">
                                    <div class="col-4 text-center border-end">
                                        <strong><?=__('Quốc gia');?></strong>
                                        <?=getFlag($product['flag']);?>
                                    </div>
                                    <div class="col-4 text-center border-end">
                                        <strong><?=__('Hiện có');?></strong>
                                        <span class="badge badge-primary rounded-pill"><?=format_cash($conlai);?></span>
                                    </div>
                                    <div class="col-4">
                                        <div class="price">
                                            <span><?=format_currency($product['price'] + $product['price'] * 10 / 100);?></span>
                                            <strong><?=format_currency($product['price']);?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons-box4">
                                <a href="javascript:void(0)"
                                    onclick="openModalPreview(`<?=base_url($product['preview']);?>`, `<?=__($product['name']);?>`)"
                                    class="preview-product text-dark text-decoration-none p-2 border d-flex align-items-center justify-content-center"
                                    style="border-radius: 10px">
                                    <i class="fa-solid fa-image mr-1"></i>
                                    <?=__('Hình ảnh mô tả');?>
                                </a>
                                <?php if($conlai == 0){?>
                                <button type="button" disabled class="btn buy-btn">
                                    <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?></button>
                                <?php }else{?>
                                <button type="button"
                                    onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)"
                                    class="btn buy-btn"><i class="fa-solid fa-cart-shopping"></i>
                                    <?=__('MUA NGAY');?></button>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>

    <!-- Modal -->
    <div id="myModalPreview" class="modal fade">
        <div class="modal-dialog modal-xl modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlePreview"></h5>
                    <button type="button" class="close" style="color: red;" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-window-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="imgpreviewbody">

                </div>
            </div>
        </div>
    </div>

    <script>
    function openModalPreview(img, name) {
        $("#titlePreview").html(name);
        if (img == '<?=base_url();?>') {
            $("#imgpreviewbody").html('<?=__("Sản phẩm này không có ảnh xem trước");?>');
        } else {
            $("#imgpreviewbody").html('<img src="' + img + '" width="100%"/> ');
        }
        $("#myModalPreview").modal();
    }
    </script>






    <?php endif?>


    <?php  } else {?>
    <div class="col-sm-12 text-center">
        <div class="iq-maintenance">
            <img src="<?=base_url('public/datum');?>/assets/images/error/maintenance.png" class="img-fluid" alt="">
            <h3 class="mt-4 mb-2"><?=__('Sản phẩm không tồn tại');?></h3>
        </div>
    </div>



    <?php
    }?>
</div>


<?php
}?>