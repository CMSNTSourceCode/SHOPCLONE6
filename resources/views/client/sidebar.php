<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>

<style>
.iq-sidebar {
    background: linear-gradient(<?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color2'); ?>);
}

.change-mode .custom-switch.custom-switch-icon label.custom-control-label:after {
    top: 0;
    left: 0;
    width: 35px;
    height: 30px;
    border-radius: 5px 0 0 5px;
    background-color: <?=$CMSNT->site('theme_color');
    ?>;
    border-color: <?=$CMSNT->site('theme_color');
    ?>;
    z-index: 0;
}
</style>

<body class="color-light ">
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <div class="wrapper">
        <div class="iq-sidebar sidebar-default">

            <div class="iq-sidebar-logo d-flex align-items-end justify-content-between">
                <a href="<?=base_url('');?>" class="header-logo">
                    <img src="<?=base_url($CMSNT->site('logo_dark'));?>" class="img-fluid rounded-normal light-logo"
                        alt="logo">
                    <img src="<?=base_url($CMSNT->site('logo_dark'));?>"
                        class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
                    <!-- <span><?=$CMSNT->site('menu_title');?></span> -->
                </a>
                <div class="side-menu-bt-sidebar-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

            </div>



            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">

                    <ul id="iq-sidebar-toggle" class="side-menu">
                        <li class="sidebar-layout">
                            <a href="#" class="svg-icon dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><?=__('Select Language:');?>
                                <span class="ml-2">
                                    <b><?=$CMSNT->get_row("SELECT * FROM `languages` WHERE `lang` = '".getLanguage()."' ")['lang'];?></b>

                                </span>

                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <div class="card shadow-none m-0 border-0">
                                    <div class=" p-0 ">
                                        <ul class="dropdown-menu-1 list-group list-group-flush">
                                            <?php foreach ($CMSNT->get_list("SELECT * FROM `languages` WHERE `status` = 1 ") as $lang) {?>
                                            <li onclick="changeLanguage(<?=$lang['id'];?>)"
                                                class="dropdown-item-1 list-group-item px-2"><a class="p-0" href="#"
                                                    style="color: #8f9fbc;"><img src="<?=BASE_URL($lang['icon']);?>"
                                                        alt="img-flaf" class="img-fluid mr-2"
                                                        style="width: 30px;height: 20px;min-width: 15px;" /><?=$lang['lang'];?></a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="sidebar-layout">
                            <a href="#" class="svg-icon dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><?=__('Select Currency:');?>
                                <span
                                    class="ml-2"><b><?=getRowRealtime('currencies', getCurrency(), 'code');?></b></span>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <div class="card shadow-none m-0 border-0">
                                    <div class=" p-0 ">
                                        <ul class="dropdown-menu-1 list-group list-group-flush">
                                            <?php foreach ($CMSNT->get_list("SELECT * FROM `currencies` WHERE `display` = 1 ") as $currency) {?>
                                            <li onclick="changeCurrency(<?=$currency['id'];?>)"
                                                class="dropdown-item-1 list-group-item px-2"><a class="p-0" href="#"
                                                    style="color: #8f9fbc;"><?=$currency['code'];?> </a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold"><?=__('Số dư');?> <span
                                    style="color: yellow;"><?=format_currency(isset($getUser['money']) ? $getUser['money'] : 0);?></span>
                                - <?=__('Giảm');?>: <span
                                    style="color: red;"><?=isset($getUser['chietkhau']) ? $getUser['chietkhau'] : 0;?>%</span>
                            </span>
                        </li>
                        <li class="<?=active_sidebar_client(['']);?> sidebar-layout">
                            <a href="<?=base_url('');?>" class="svg-icon">
                                <i class="fas fa-home"></i>
                                <span class="ml-2"><?=__('Trang Chủ');?></span>
                            </a>
                        </li>
                        <!-- <li class="<?=active_sidebar_client(['home']);?> sidebar-layout">
                            <a href="<?=base_url('client/home');?>" class="svg-icon ">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ml-2"><?=__('Mua Tài Khoản');?></span>
                            </a>
                        </li> -->
                        <li class="sidebar-layout">
                            <a href="#menuSanPham" class="svg-icon collapsed" data-toggle="collapse"
                                aria-expanded="false">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ml-2"><?=__('Mua Tài Khoản');?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon iq-arrow-right arrow-active"
                                    width="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <ul id="menuSanPham" class="submenu collapse" data-parent="#iq-sidebar-toggle">
                                <?php foreach($CMSNT->get_list(" SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $menucategory):?>
                                <li class=" sidebar-layout <?=$menucategory['id'] == $categoryINT ? 'active' : '';?>">
                                    <a href="<?=base_url('?action=home&category='.$menucategory['id']);?>"
                                        class="svg-icon">
                                        <img width="25px" src="<?=base_url($menucategory['image']);?>"
                                            class="mr-2"><span class=""><?=__($menucategory['name']);?></span>
                                    </a>
                                </li>
                                <?php endforeach?>
                            </ul>
                        </li>
                        <?php if($CMSNT->site('status_store_document') == 1):?>
                        <li class="<?=active_sidebar_client(['shop-document']);?> sidebar-layout">
                            <a href="<?=base_url('client/shop-document');?>" class="svg-icon ">
                                <i class="fas fa-book"></i>
                                <span class="ml-2"><?=__('Mua Tài Liệu');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_ban_xu_ttc') == 1 && checkAddon(11522) == true):?>
                        <li class="<?=active_sidebar_client(['mua-xu-ttc', 'lich-su-mua-xu-ttc']);?> sidebar-layout">
                            <a href="<?=base_url('client/mua-xu-ttc');?>" class="svg-icon ">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ml-2"><?=__('XU TTC CHUYỂN');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_ban_xu_tds') == 1 && checkAddon(11522) == true):?>
                        <li class="<?=active_sidebar_client(['mua-xu-tds', 'lich-su-mua-xu-tds']);?> sidebar-layout">
                            <a href="<?=base_url('client/mua-xu-tds');?>" class="svg-icon ">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ml-2"><?=__('XU TDS CHUYỂN');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_store_fanpage') == 1):?>
                        <li
                            class="<?=active_sidebar_client(['store-fanpage', 'store-fanpage-orders']);?> sidebar-layout">
                            <a href="<?=base_url('client/store-fanpage');?>" class="svg-icon ">
                                <i class="fab fa-facebook-square"></i>
                                <span class="ml-2"><?=__('Mua Fanpage/Group');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_buff_like_sub') == 1):?>
                        <li class="<?=active_sidebar_client(['order-service', 'history-service']);?> sidebar-layout">
                            <a href="<?=base_url('client/order-service');?>" class="svg-icon ">
                                <i class="fab fa-facebook"></i>
                                <span class="ml-2"><?=__('Dịch Vụ Tăng like');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_thuesim') == 1):?>
                        <li class="<?=active_sidebar_client(['otp-order', 'otp-history']);?> sidebar-layout">
                            <a href="<?=base_url('client/otp-order');?>" class="svg-icon ">
                                <i class="fa-solid fa-sim-card"></i>
                                <span class="ml-2"><?=__('Thuê OTP');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <li class="<?=active_sidebar_client(['orders']);?> sidebar-layout">
                            <a href="<?=base_url('client/orders');?>" class="svg-icon ">
                                <i class="fas fa-history"></i>
                                <span class="ml-2"><?=__('Lịch Sử Mua Hàng');?></span>
                            </a>
                        </li>
                        <?php if(checkAddon(4) == true):?>
                        <?php if($CMSNT->site('stt_topnap') == 1):?>
                        <li class="<?=active_sidebar_client(['top-money']);?> sidebar-layout">
                            <a href="<?=base_url('client/top-money');?>" class="svg-icon ">
                                <i class="fas fa-trophy"></i>
                                <span class="ml-2"><?=__('Bảng Xếp Hạng');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php endif?>
                        <?php if($CMSNT->site('status_ref') == 1):?>
                        <li class="<?=active_sidebar_client(['affiliates']);?> sidebar-layout">
                            <a href="<?=base_url('client/affiliates');?>" class="svg-icon ">
                                <i class="fas fa-handshake"></i>
                                <span class="ml-2"><?=__('Tiếp Thị Liên Kết');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('stt_create_website') == 1):?>
                        <li class="<?=active_sidebar_client(['create-website']);?> sidebar-layout">
                            <a href="<?=base_url('client/create-website');?>" class="svg-icon ">
                                <i class="fas fa-handshake"></i>
                                <span class="ml-2"><?=__('Tạo Website Con');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1 AND `position` = 1 ORDER BY `id` DESC ") as $menu):?>
                        <?php 
                            if($menu['content'] == ''){
                                $href_menu = $menu['href'];
                            }else{
                                $href_menu = base_url('page/'.$menu['slug']);
                            }
                            $active_menu = '';
                            if(isset($_GET['slug']) && $_GET['slug'] == $menu['slug']){
                                $active_menu = 'active';
                            }
                        ?>
                        <li class="<?=$active_menu;?> sidebar-layout">
                            <a <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?> href="<?=$href_menu;?>"
                                class="svg-icon ">
                                <?=$menu['icon'];?>
                                <span class="ml-2"><?=__($menu['name']);?></span>
                            </a>
                        </li>
                        <?php endforeach?>
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold"><?=__('Nạp Tiền');?></span></span>
                        </li>
                        <?php if($CMSNT->site('status_bank') == 1):?>
                        <li class="<?=active_sidebar_client(['recharge']);?> sidebar-layout">
                            <a href="<?=base_url('client/recharge');?>" class="svg-icon ">
                                <i class="fas fa-university"></i>
                                <span class="ml-2"><?=__('Ngân Hàng');?></span>
                            </a>
                        </li>
                        <?php if($CMSNT->site('sv1_autobank') == 1):?>
                        <li class="<?=active_sidebar_client(['invoices']);?> sidebar-layout">
                            <a href="<?=base_url('client/invoices');?>" class="svg-icon ">
                                <i class="fas fa-file-invoice"></i>
                                <span class="ml-2"><?=__('Hoá Đơn');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php endif?>
                        <?php if($CMSNT->site('status_toyyibpay') == 1):?>
                        <li class="<?=active_sidebar_client(['toyyibpay']);?> sidebar-layout">
                            <a href="<?=base_url('client/toyyibpay');?>" class="svg-icon ">
                                <i class="fas fa-university"></i>
                                <span class="ml-2"><?=__('Toyyibpay');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('flutterwave_status') == 1):?>
                        <li class="<?=active_sidebar_client(['flutterwave']);?> sidebar-layout">
                            <a href="<?=base_url('client/flutterwave');?>" class="svg-icon ">
                                <i class="fas fa-university"></i>
                                <span class="ml-2"><?=__('Flutterwave Nigeria');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('squadco_status') == 1):?>
                        <li class="<?=active_sidebar_client(['recharge-squadco']);?> sidebar-layout">
                            <a href="<?=base_url('client/recharge-squadco');?>" class="svg-icon ">
                                <i class="fas fa-university"></i>
                                <span class="ml-2"><?=__('Squadco Nigeria');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if ($CMSNT->site('status_paypal') == 1) {?>
                        <li class="<?=active_sidebar_client(['paypal']);?> sidebar-layout">
                            <a href="<?=base_url('client/paypal');?>" class="svg-icon ">
                                <i class="fab fa-paypal"></i>
                                <span class="ml-2"><?=__('PayPal');?></span>
                            </a>
                        </li>
                        <?php }?>
                        <?php if ($CMSNT->site('status_perfectmoney') == 1) {?>
                        <li class="<?=active_sidebar_client(['perfectmoney']);?> sidebar-layout">
                            <a href="<?=base_url('client/perfectmoney');?>" class="svg-icon ">
                                <i class="fas fa-money-bill"></i>
                                <span class="ml-2"><?=__('Perfect Money');?></span>
                            </a>
                        </li>
                        <?php }?>
                        <?php if ($CMSNT->site('status_crypto') == 1) {?>
                        <li class="<?=active_sidebar_client(['crypto']);?> sidebar-layout">
                            <a href="<?=base_url('index.php?action=crypto');?>" class="svg-icon ">
                                <i class="fa-brands fa-bitcoin"></i>
                                <span class="ml-2"><?=__('Crypto');?></span>
                            </a>
                        </li>
                        <?php }?>
                        <?php if ($CMSNT->site('status_napthe') == 1) {?>
                        <li class="<?=active_sidebar_client(['nap-the']);?> sidebar-layout">
                            <a href="<?=base_url('client/nap-the');?>" class="svg-icon ">
                                <i class="fas fa-sd-card"></i>
                                <span class="ml-2"><?=__('Nạp Thẻ');?></span>
                            </a>
                        </li>
                        <?php }?>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1 AND `position` = 2 ORDER BY `id` DESC ") as $menu):?>
                        <?php 
                            if($menu['content'] == ''){
                                $href_menu = $menu['href'];
                            }else{
                                $href_menu = base_url('page/'.$menu['slug']);
                            }
                            $active_menu = '';
                            if(isset($_GET['slug']) && $_GET['slug'] == $menu['slug']){
                                $active_menu = 'active';
                            }
                        ?>
                        <li class="<?=$active_menu;?> sidebar-layout">
                            <a <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?> href="<?=$href_menu;?>"
                                class="svg-icon ">
                                <?=$menu['icon'];?>
                                <span class="ml-2"><?=__($menu['name']);?></span>
                            </a>
                        </li>
                        <?php endforeach?>
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold"><?=__('Khác');?></span></span>
                        </li>
                        <?php if($CMSNT->site('display_blog') == 1):?>
                        <li class="<?=active_sidebar_client(['blogs', 'blog']);?> sidebar-layout">
                            <a href="<?=base_url('client/blogs');?>" class="svg-icon ">
                                <i class="fa-brands fa-blogger"></i>
                                <span class="ml-2"><?=__('Bài Viết');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('display_tool') == 1):?>
                        <li class="sidebar-layout">
                            <a href="#app1" class="svg-icon collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="fas fa-toolbox"></i>
                                <span class="ml-2"><?=__('Công Cụ');?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon iq-arrow-right arrow-active"
                                    width="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <ul id="app1"
                                class="submenu collapse <?=show_sidebar_client(['tool-check-live-fb', 'ephotor', 'batchwatermark', 'icon-facebook']);?>"
                                data-parent="#iq-sidebar-toggle">
                                <li class=" sidebar-layout <?=active_sidebar_client(['tool-check-live-fb']);?>">
                                    <a href="<?=base_url('client/tool-check-live-fb');?>" class="svg-icon">
                                        <i class="fab fa-facebook-f"></i><span
                                            class=""><?=__('Check Live Facebook');?></span>
                                    </a>
                                </li>
                                <li class=" sidebar-layout <?=active_sidebar_client(['ephotor']);?>">
                                    <a href="<?=base_url('client/ephotor');?>" class="svg-icon">
                                        <i class="fas fa-images"></i><span class=""><?=__('ePhotor');?></span>
                                    </a>
                                </li>
                                <li class=" sidebar-layout <?=active_sidebar_client(['batchwatermark']);?>">
                                    <a href="<?=base_url('client/batchwatermark');?>" class="svg-icon">
                                        <i class="fas fa-image"></i><span class=""><?=__('Chèn Watermark');?></span>
                                    </a>
                                </li>
                                <li class=" sidebar-layout <?=active_sidebar_client(['icon-facebook']);?>">
                                    <a href="<?=base_url('client/icon-facebook');?>" class="svg-icon">
                                        <i class="fas fa-smile-wink"></i><span class=""><?=__('Icon Facebook');?></span>
                                    </a>
                                </li>
                                <li class=" sidebar-layout <?=active_sidebar_client(['random-face']);?>">
                                    <a href="<?=base_url('client/random-face');?>" class="svg-icon">
                                        <i class="fas fa-flushed"></i><span
                                            class=""><?=__('Khuôn Mặt Ngẫu Nhiên');?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('display_question') == 1):?>
                        <li class="<?=active_sidebar_client(['faq']);?> sidebar-layout">
                            <a href="<?=base_url('client/faq');?>" class="svg-icon ">
                                <i class="far fa-question-circle"></i>
                                <span class="ml-2"><?=__('FAQ');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('display_api') == 1):?>
                        <li class="<?=active_sidebar_client(['api']);?> sidebar-layout">
                            <a target="_blank" href="https://documenter.getpostman.com/view/9826758/TzzANcVu"
                                class="svg-icon ">
                                <i class="far fa-file-code"></i>
                                <span class="ml-2"><?=__('Tài Liệu API');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('display_contact') == 1):?>
                        <li class="<?=active_sidebar_client(['contact']);?> sidebar-layout">
                            <a href="<?=base_url('client/contact');?>" class="svg-icon ">
                                <i class="fas fa-address-book"></i>
                                <span class="ml-2"><?=__('Liên Hệ');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1 AND `position` = 3 ORDER BY `id` DESC ") as $menu):?>
                        <?php 
                            if($menu['content'] == ''){
                                $href_menu = $menu['href'];
                            }else{
                                $href_menu = base_url('page/'.$menu['slug']);
                            }
                            $active_menu = '';
                            if(isset($_GET['slug']) && $_GET['slug'] == $menu['slug']){
                                $active_menu = 'active';
                            }
                        ?>
                        <li class="<?=$active_menu;?> sidebar-layout">
                            <a <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?> href="<?=$href_menu;?>"
                                class="svg-icon ">
                                <?=$menu['icon'];?>
                                <span class="ml-2"><?=__($menu['name']);?></span>
                            </a>
                        </li>
                        <?php endforeach?>
                    </ul>
                </nav>
                <div class="pt-5 pb-5"></div>
            </div>
        </div>
        <?php require_once(__DIR__.'/nav.php');?>