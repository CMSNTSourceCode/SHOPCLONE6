<?php
define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
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
        require_once(__DIR__.'/../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../models/is_user.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {?>

<div class="row">
    <?php
    if ($_POST['id'] == 0) {
        $listProduct = $CMSNT->get_list("SELECT * FROM `documents` WHERE `status` = 1 ORDER BY `stt` ASC ");
    } else {
        $listProduct = $CMSNT->get_list("SELECT * FROM `documents` WHERE `category_id` = '".check_string($_POST['id'])."' AND `status` = 1 ORDER BY `stt` ASC ");
    }
    if ($listProduct){ ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-color-heading">
                <tr>
                    <th><?=__('Danh sách TUT/Trick');?></th>
                    <th><?=__('Chuyên mục');?></th>
                    <th><?=__('Giá');?></th>
                    <th><?=__('Ngày đăng');?></th>
                    <th><?=__('Cập nhật');?></th>
                    <th><?=__('Thao tác');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listProduct as $product) {?>
                <tr>
                    <td width="40%"><img class="mr-1" src="<?=base_url(getRowRealtime("document_categories", $product['category_id'], 'image'));?>" width="25px"><?=__($product['name']);?></td>
                    <td><span class="badge badge-dark"><?=getRowRealtime("document_categories", $product['category_id'], 'name');?></span></td>
                    <td><b style="color: red;"><?=format_currency($product['price']);?></b></td>
                    <td><i><?=$product['create_date'];?></i></td>
                    <td><i><?=$product['update_date'];?></i></td>
                    <td>
                        <?php if (isset($_SESSION['login'])):?>
                            <?php if($CMSNT->get_row("SELECT * FROM `orders` WHERE `buyer` = '".$getUser['id']."' AND `document_id` = '".$product['id']."' ")):?>
                                <a href="<?=base_url('client/order/'.$CMSNT->get_row("SELECT * FROM `orders` WHERE `buyer` = '".$getUser['id']."' AND `document_id` = '".$product['id']."' ")['trans_id']);?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-eye mr-1"></i><?=__('XEM');?></a>
                            <?php else:?>
                                <button onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)" class="btn btn-primary btn-sm"><i class="fa-solid fa-cart-shopping mr-1"></i><?=__('MUA NGAY');?></button>
                            <?php endif?>
                        <?php else:?>
                            <button onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)" class="btn btn-primary btn-sm"><i class="fa-solid fa-cart-shopping mr-1"></i><?=__('MUA NGAY');?></button>
                        <?php endif?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>


    <?php  } else {?>
    <div class="col-sm-12 text-center">
        <div class="iq-maintenance">
            <img src="<?=base_url('public/datum');?>/assets/images/error/maintenance.png" class="img-fluid" alt="">
            <h3 class="mt-4 mb-2"><?=__('Sản phẩm không tồn tại');?></h3>
        </div>
    </div>
    <?php }?>
</div>


<?php
}?>