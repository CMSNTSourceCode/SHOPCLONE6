<?php
define("IN_SITE", true);
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
<div class="row">
    <?php
    if ($_POST['id'] == 0) {
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ORDER BY `stt` ASC ");
    } else {
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `category_id` = '".check_string($_POST['id'])."' AND `status` = 1 ORDER BY `stt` ASC ");
    }



    if ($listProduct) {
        // Show Type Box
        if ($CMSNT->site('type_showProduct') == 1) {
            foreach ($listProduct as $product) {
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
                    <b class="text-center"><img class="mr-1" src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>" width="25px"><?=__($product['name']);?> <?=$product['preview'] != null ? '<a href="'.base_url($product['preview']).'" target="_blank"><i class="fas fa-search"></i></a>' : '';?></b>
                    <p style="font-size: 13px;">--><?=__($product['content']);?></p>
                </div>
                <div class="col-md-7">
                    <br>
                    <span class="btn mb-1 btn-sm btn-outline-danger">
                        <i class="far fa-money-bill-alt mr-1"></i><?=__('Giá');?>:
                        <b><?=format_currency($product['price']);?></b>
                    </span> 
                    <?php if($CMSNT->site('display_country') == 1):?>
                    <span class="btn mb-1 btn-sm btn-outline-warning">
                        <i class="fas fa-flag mr-1"></i><?=__('Quốc gia');?>: <?=getFlag($product['flag']);?>
                    </span>
                    <?php endif?>
                    <br>
                    <?php if ($CMSNT->site('display_sold') == 1) {?>
                    <span class="btn mb-1 btn-sm btn-outline-success">
                        <i class="fas fa-cart-arrow-down mr-1"></i><?=__('Đã bán');?>: <b><?=format_cash($product['sold']);?></b>
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


    <?php
            }
        }
        // Show Type LIST
        elseif ($CMSNT->site('type_showProduct') == 2) { ?>



    <div class="col-sm-12 col-md-12 col-lg-12 mt-12 mt-md-3 p-0">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-color-heading">
                    <tr>
                        <th></th>
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
                    <?php foreach ($listProduct as $product) {?>
                    <?php
                    $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                    if($CMSNT->site('hide_product_empty') == 1){
                        if($conlai == 0){
                            continue;
                        }
                    }?>
                    <tr>
                        <td>
                            <img class="mr-2 py-1 mb-2" src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>" width="30px"><?=__($product['name']);?>
                            <p style="font-size: 13px;"><i class="fas fa-angle-right mr-1"></i><i><?=__($product['content']);?></i></p>
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
                                <i class="fas fa-luggage-cart mr-1"></i><?=__('Còn lại');?>: 
                                <b><?=format_cash($conlai);?></b>
                            </span></td>
                        <?php if ($CMSNT->site('display_sold') == 1) {?>
                        <td class="text-center"><span class="btn mb-1 btn-sm btn-outline-success">
                                <i class="fas fa-cart-arrow-down mr-1"></i><?=__('Đã bán');?>: <b><?=format_cash($product['sold']);?></b>
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



    <?php
        }
    } else {?>



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