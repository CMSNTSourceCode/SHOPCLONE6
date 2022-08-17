


<?php if($CMSNT->site('display_box_shop') == 1){?>
<div class="col-sm-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <i><?=__('Gợi ý sản phẩm cho bạn');?>:</i>
            <ol class="row">
                <?php foreach($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ORDER BY RAND() LIMIT 6 ") as $product):?>
                <?php
                $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                if($CMSNT->site('hide_product_empty') == 1){
                    if($conlai == 0){
                        continue;
                    }
                }
                ?>
                <li class="col-lg-6"><a href="javascript:void(0);"
                        onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)"
                        type="button"><b><?=__($product['name']);?></b> -
                        <b style="color: red;"><?=format_currency($product['price']);?></b></a></li>
                <?php endforeach?>
            </ol>
        </div>
    </div>
</div>
<?php }?>
<?php if($CMSNT->site('display_show_product') == 1):?>
<div class="col-lg-12">
    <div class="card">
    <div class="card-header d-flex justify-content-between" style="background: <?=$CMSNT->site('theme_color');?>;">
            <div class="header-title">
                <h5 class="card-title" style="color:white;"><?=mb_strtoupper(__('MUA TÀI KHOẢN'), 'UTF-8');?>
                </h5>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab-fill" onclick="showProduct(0)" data-toggle="pill"
                        href="#pills-home-fill" role="tab" aria-controls="pills-home" aria-selected="true"><i
                            class="fas fa-shopping-cart mr-1"></i><?=mb_strtoupper(__('TẤT CẢ SẢN PHẨM'), 'UTF-8');?></a>
                </li>
                <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $category) {?>
                <li class="nav-item">
                    <a class="nav-link" id="pills-home-tab-fill" onclick="showProduct(<?=$category['id'];?>)"
                        data-toggle="pill" href="#pills-home-fill" role="tab" aria-controls="pills-home"
                        aria-selected="true"><img src="<?=base_url($category['image']);?>" width="25px" />
                        <?=mb_strtoupper(__($category['name']), 'UTF-8');?></a>
                </li>
                <?php }?>
            </ul>
            <div class="tab-content" id="pills-tabContent-1">
                <div class="tab-pane fade show active" id="pills-home-fill" role="tabpanel"
                    aria-labelledby="pills-home-tab-fill">
                    <div id="showProduct">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center border-top-table p-3">
            <a type="button" href="<?=base_url('client/orders');?>" class="btn btn-secondary btn-sm"><i
                    class="fas fa-cart-arrow-down mr-1"></i><?=__('Lịch Sử Mua Hàng');?></a>
        </div>
    </div>
</div>
<script>
showProduct(0);

function showProduct(id) {
    $("#showProduct").html('<center><img src="<?=base_url($CMSNT->site('gif_loading'));?>" width="100px" /></center>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/showProduct.php");?>",
        method: "POST",
        data: {
            id: id
        },
        success: function(data) {
            $("#showProduct").html(data);
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
<?php elseif($CMSNT->site('display_show_product') == 2):?>

<?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $category):?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header card-product d-flex justify-content-between"
            style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
            <div class="header-title">
                <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>" width="30px"
                        class="mr-2" /><?=$category['name'];?></h5>
            </div>
        </div>
        <?php 
        // Show Type Box
        if ($CMSNT->site('type_showProduct') == 1):?>
        <div class="card-body">
            <div class="row">
                <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                <?php
                $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                if($CMSNT->site('hide_product_empty') == 1){
                    if($conlai == 0){
                        continue;
                    }
                }
                ?>
                <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mt-md-3">
                    <div class="basic-drop-shadow p-3 shadow-showcase">
                        <!--
            <div class="ribbon-wrapper ribbon-lg">
                <div class="ribbon bg-danger">
                    Sale 20%
                </div>
            </div>-->
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
                                    <i class="far fa-money-bill-alt mr-1"></i><?=__('Giá');?>:
                                    <b><?=format_currency($product['price']);?></b>
                                </span> <span class="btn mb-1 btn-sm btn-outline-warning">
                                    <i class="fas fa-flag mr-1"></i><?=__('Quốc gia');?>: <img
                                        src="https://flagcdn.com/24x18/<?=$product['flag'];?>.png">
                                </span><br>
                                <?php if ($CMSNT->site('display_sold') == 1) {?>
                                <span class="btn mb-1 btn-sm btn-outline-success">
                                    <i class="fas fa-cart-arrow-down mr-1"></i><?=__('Đã bán');?>:
                                    <b><?=format_cash($product['sold']);?></b>
                                </span>
                                <?php }?>
                                <span class="btn mb-1 btn-sm btn-outline-info">
                                    <i class="fas fa-luggage-cart mr-1"></i><?=__('Hiện có');?>:
                                    <b><?=format_cash($conlai);?></b>
                                </span><br>
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
        <?php elseif($CMSNT->site('type_showProduct') == 2):?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-color-heading">
                        <tr>
                            <th><?=__('Tên sản phẩm');?></th>
                            <?php if($CMSNT->site('display_rating') == 1):?>
                            <th class="text-center" width="10%"><?=__('Đánh giá');?></th>
                            <?php endif?>
                            <?php if($CMSNT->site('display_country') == 1):?>
                            <th class="text-center" width="10%"><?=__('Quốc gia');?></th>
                            <?php endif?>
                            <?php if($CMSNT->site('display_preview') == 1):?>
                            <th class="text-center" width="10%"><?=__('Xem trước');?></th>
                            <?php endif?>
                            <th class="text-center" width="10%"><?=__('Hiện có');?></th>
                            <?php if ($CMSNT->site('display_sold') == 1) {?>
                            <th class="text-center" width="10%"><?=__('Đã bán');?></th>
                            <?php }?>
                            <th class="text-center" width="10%"><?=__('Giá');?></th>
                            <th class="text-center" width="10%"><?=__('Thao tác');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product) {?>
                        <?php
                        $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                        if($CMSNT->site('hide_product_empty') == 1){
                            if($conlai == 0){
                                continue;
                            }
                        }
                        ?>
                        <tr>
                            <td>
                                <img class="mr-1 py-1"
                                    src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>"
                                    width="25px"><span style="font-weight: bold;"><?=__($product['name']);?></span>
                                <p style="font-size: 13px;"><i
                                        class="fas fa-angle-right mr-1"></i><i><?=__($product['content']);?></i></p>
                            </td>
                            <?php if($CMSNT->site('display_rating') == 1):?>
                            <td>
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
                            </td>
                            <?php endif?>
                            <?php if($CMSNT->site('display_country') == 1):?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-warning">
                                    <?=getFlag($product['flag']);?>
                                    </span>
                            </td>
                            <?php endif?>
                            <?php if($CMSNT->site('display_preview') == 1):?>
                            <td class="text-center">
                            <?php if($product['preview'] != null):?>
                            <div class="thumbnail_zoom">
                                 <img src="<?=base_url($product['preview']);?>" class="img_thumbnail_zoom" alt="image preview">
                            </div>
                            <?php endif?>
                            </td>
                            <?php endif?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-info">
                                    <i class="fas fa-luggage-cart mr-1"></i>
                                    <b><?=format_cash($conlai);?></b>
                                </span></td>
                            <?php if ($CMSNT->site('display_sold') == 1) {?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-success">
                                    <i class="fas fa-cart-arrow-down mr-1"></i><?=__('Đã bán');?>:
                                    <b><?=format_cash($product['sold']);?></b>
                                </span></td>
                            <?php }?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-danger">
                                    <i class="far fa-money-bill-alt mr-1"></i>
                                    <b><?=format_currency($product['price']);?></b>
                                </span></td>
                            <td class="text-center">
                                <?php if($conlai == 0){?>
                                <button class="btn btn-block btn-sm btn-secondary" disabled>
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
        <?php endif?>
    </div>
</div>
<?php endforeach?>

<?php elseif($CMSNT->site('display_show_product') == 3):?>

<?php if(checkAddon(1) == true):?>
<?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $category):?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body p-0">
            <div>
                <table class="table table-striped mb-0">
                    <thead class="table-color-heading card-product">
                        <tr>
                            <th><img src="<?=base_url($category['image']);?>" width="30px"
                                    class="mr-2" /><?=mb_strtoupper($category['name'], 'UTF-8');?></th>
                            <?php if($CMSNT->site('display_rating') == 1):?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-star mr-1"></i><?=mb_strtoupper(__('Đánh giá'), 'UTF-8');?></th>
                            <?php endif?>
                            <?php if($CMSNT->site('display_country') == 1):?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-globe-africa mr-1"></i><?=mb_strtoupper(__('Quốc gia'), 'UTF-8');?>
                            </th>
                            <?php endif?>
                            <?php if($CMSNT->site('display_preview') == 1):?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-globe-africa mr-1"></i><?=mb_strtoupper(__('Xem trước'), 'UTF-8');?>
                            </th>
                            <?php endif?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-warehouse mr-1"></i><?=mb_strtoupper(__('Hiện có'), 'UTF-8');?></th>
                            <?php if ($CMSNT->site('display_sold') == 1) {?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-cart-arrow-down mr-1"></i><?=mb_strtoupper(__('Đã bán'), 'UTF-8');?>
                            </th>
                            <?php }?>
                            <th class="text-center" width="10%"><i
                                    class="fas fa-money-bill-alt mr-1"></i><?=mb_strtoupper(__('Giá'), 'UTF-8');?></th>
                            <th class="text-center" width="10%"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product) {?>
                        <?php
                        $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                        if($CMSNT->site('hide_product_empty') == 1){
                            if($conlai == 0){
                                continue;
                            }
                        }
                        ?>
                        <tr>
                            <td>
                                <img class="mr-1 py-1"
                                    src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>"
                                    width="25px"><span style="font-weight: bold;"><?=__($product['name']);?></span>
                                <?=$product['preview'] != null ? '<a href="'.base_url($product['preview']).'" target="_blank"><i class="fas fa-search"></i></a>' : '';?>
                                <p style="font-size: 13px;"><i
                                        class="fas fa-angle-right mr-1"></i><i><?=__($product['content']);?></i></p>
                            </td>
                            <?php if($CMSNT->site('display_rating') == 1):?>
                            <td>
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
                            </td>
                            <?php endif?>
                            <?php if($CMSNT->site('display_country') == 1):?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-warning">
                                    <?=getFlag($product['flag']);?>
                                </span></td>
                            <?php endif?>
                            <?php if($CMSNT->site('preview') == 1):?>
                            <td class="text-center">
                                <?php if($product['preview'] != null):?>
                                <div class="thumbnail_zoom">
                                    <img src="<?=base_url($product['preview']);?>" class="img_thumbnail_zoom" alt="image preview">
                                </div>
                                <?php endif?>
                            </td>
                            <?php endif?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-info">
                                    <i class="fas fa-luggage-cart mr-1"></i>
                                    <b><?=format_cash($conlai);?></b>
                                </span></td>
                            <?php if ($CMSNT->site('display_sold') == 1) {?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-success">
                                    <i class="fas fa-cart-arrow-down mr-1"></i><?=__('Đã bán');?>:
                                    <b><?=format_cash($product['sold']);?></b>
                                </span></td>
                            <?php }?>
                            <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-danger">
                                    <i class="far fa-money-bill-alt mr-1"></i>
                                    <b><?=format_currency($product['price']);?></b>
                                </span></td>
                            <td class="text-center">
                                <?php if($conlai == 0){?>
                                <button class="btn btn-block btn-sm btn-secondary" disabled>
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
    </div>
</div>
<?php endforeach?>
<?php else:?>
<div class="col-lg-12">
    <div class="alert alert-danger" role="alert">
        <div class="iq-alert-text">Bạn chưa kích hoạt Addon này!</div>
    </div>
</div>
<?php endif?>
<?php elseif($CMSNT->site('display_show_product') == 4):?>
<?php if(checkAddon(3) == true):?>
<style>
.custom-block {
    padding: 0;
}
.custom-block .custom-control-label2:hover {
    color: #403E10;
    box-shadow: <?=$CMSNT->site('theme_color');?> -1px 1px, <?=$CMSNT->site('theme_color');?> -2px 2px, <?=$CMSNT->site('theme_color');?> -3px 3px, <?=$CMSNT->site('theme_color');?> -4px 4px, <?=$CMSNT->site('theme_color');?> -5px 5px, <?=$CMSNT->site('theme_color');?> -6px 6px;
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
    border: 2px solid <?=$CMSNT->site('theme_color');?>;
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
    border: 1px solid <?=$CMSNT->site('theme_color');?>;
}
.custom-control-primary.custom-block .custom-block-indicator,
.custom-control-primary.custom-radio .custom-control-input:checked~.custom-control-label2:before {
    background-color: #0665d0;
}
.font-w700 {
    font-weight: 700 !important;
}
</style>
<?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $category):?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header card-product d-flex justify-content-between"
            style="background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);">
            <div class="header-title">
                <h5 class="card-title" style="color:white;"><img src="<?=base_url($category['image']);?>" width="30px"
                        class="mr-2" /><?=$category['name'];?></h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 AND `category_id` = '".$category['id']."' ORDER BY `stt` ASC ") as $product):?>
                <?php
                $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                if($CMSNT->site('hide_product_empty') == 1){
                    if($conlai == 0){
                        continue;
                    }
                }
                ?>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                    <div class="custom-control custom-block custom-control-primary" onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                        <div class="custom-control-label2 p-2">
                            <span class="d-flex align-items-center">
                                <div class="item item-circle bg-black-5 text-primary-light" style="min-width: 60px;">
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
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="<?=__($product['content']);?>"></i>
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


<?php else:?>
<div class="col-lg-12">
    <div class="alert alert-danger" role="alert">
        <div class="iq-alert-text">Bạn chưa kích hoạt Addon này!</div>
    </div>
</div>
<?php endif?>
<?php endif?>



<div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" style="background-image:url('<?=base_url($CMSNT->site('bg_card'));?>');">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Thanh toán đơn hàng');?></h5>
                <button type="button" class="close" style="color: red;" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label><?=__('Tên sản phẩm');?>:</label>
                    <input type="text" class="form-control" id="name" readonly />
                </div>
                <div class="form-group mb-3">
                    <label><?=__('Số lượng cần mua');?>:</label>
                    <input type="number" class="form-control form-control-solid" onchange="totalPayment()"
                        onkeyup="totalPayment()" placeholder="<?=__('Nhập số lượng cần mua');?>" id="amount" />
                    <input type="hidden" value="" readonly class="form-control" id="modal-id">
                    <input type="hidden" value="" readonly class="form-control" id="price">
                    <input class="form-control" type="hidden" id="token" value="<?=isset($getUser) ? $getUser['token'] : '';?>">
                </div>
                <div class="form-group mb-3" id="showDiscountCode">
                    <label><?=__('Mã giảm giá');?>:</label>
                    <input type="text" class="form-control" onchange="totalPayment()" onkeyup="totalPayment()"
                        placeholder="<?=__('Nhập mã giảm giá của bạn');?>" id="coupon" />
                </div>
                <div class="mb-3 text-right"><button id="btnshowDiscountCode" onclick="showDiscountCode()"
                        class="btn btn-danger btn-sm"><?=__('Nhập mã giảm giá');?></button></div>
                <div class="mb-3 text-center" style="font-size: 20px;"><?=__('Tổng tiền cần thanh toán');?>: <b
                        id="total" style="color:red;">0</b></div>
                <div class="text-center mb-3">
                    <button type="submit" id="btnBuy" onclick="buyProduct()" class="btn btn-primary btn-block"><i
                            class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
            coupon: $("#coupon").val(),
            amount: amount
        },
        success: function(data) {
            $('#btnBuy').html('<i class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?>').prop(
                'disabled', false);
            if (data.status == 'success') {
                cuteToast({
                    type: "success",
                    message: data.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('client/orders');?>';", 1000);
            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    data.msg,
                    'error'
                );
            }
        },
        error: function() {
            $('#btnBuy').html('<i class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?>').prop(
                'disabled', false);
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }
    });
}
</script>
<script type="text/javascript">
function modalBuy(id, price, name) {
    $("#modal-id").val(id);
    $("#price").val(price);
    $("#name").val(name);
    $("#amount").val('');
    $("#modalBuy").modal();
}

document.getElementById('showDiscountCode').style.display = 'none';

function showDiscountCode() {
    if (document.getElementById('showDiscountCode').style.display == 'none') {
        document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-dark";
        $('#btnshowDiscountCode').html('<?=__('Huỷ mã giảm giá');?>');
        document.getElementById('showDiscountCode').style.display = 'block';
    } else {
        document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-danger";
        $('#btnshowDiscountCode').html('<?=__('Nhập mã giảm giá');?>');
        document.getElementById('showDiscountCode').style.display = 'none';
        document.getElementById('coupon').value = '';
        totalPayment();
    }
}

function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalPayment.php");?>",
        method: "POST",
        data: {
            id: $("#modal-id").val(),
            amount: $("#amount").val(),
            coupon: $("#coupon").val(),
            token: $("#token").val(),
            store: 'accounts'
        },
        success: function(data) {
            $("#total").html(data);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể tính kết quả thanh toán',
                timer: 5000
            });
        }
    });
    //$("#total").html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
}
</script>