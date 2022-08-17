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
                    <img src="<?=base_url($CMSNT->site('favicon'));?>" class="img-fluid rounded-normal light-logo"
                        alt="logo">
                    <img src="<?=base_url($CMSNT->site('favicon'));?>"
                        class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
                    <span><?=$CMSNT->site('menu_title');?></span>
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
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold"><?=__('Số dư');?> <span
                                    style="color: yellow;"><?=format_currency(isset($getUser['money']) ? $getUser['money'] : 0);?></span></span>
                        </li>
                        <li class="<?=active_sidebar_client(['']);?> sidebar-layout">
                            <a href="<?=base_url('');?>" class="svg-icon">
                                <i class="fas fa-home"></i>
                                <span class="ml-2"><?=__('Bảng Điều Khiển');?></span>
                            </a>
                        </li>
                        <li class="<?=active_sidebar_client(['home/shop-account']);?> sidebar-layout">
                            <a href="<?=base_url('client/home/shop-account');?>" class="svg-icon ">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="ml-2"><?=__('Mua Tài Khoản');?></span>
                            </a>
                        </li>
                        <li class="<?=active_sidebar_client(['home/shop-document']);?> sidebar-layout">
                            <a href="<?=base_url('client/home/shop-document');?>" class="svg-icon ">
                                <i class="fas fa-book"></i>
                                <span class="ml-2"><?=__('Mua Tài Liệu');?></span>
                            </a>
                        </li>
                        <?php if($CMSNT->site('status_store_fanpage') == 1):?>
                        <li class="<?=active_sidebar_client(['store-fanpage', 'store-fanpage-orders']);?> sidebar-layout">
                            <a href="<?=base_url('client/store-fanpage');?>" class="svg-icon ">
                                <i class="fab fa-facebook-square"></i>
                                <span class="ml-2"><?=__('Mua Fanpage/Group');?></span>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if($CMSNT->site('status_buff_like_sub') == 1):?>
                        <li class="sidebar-layout">
                            <a href="#app3" class="svg-icon collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="fas fa-thumbs-up"></i>
                                <span class="ml-2"><?=__('Mua Tương Tác');?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon iq-arrow-right arrow-active"
                                    width="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <ul id="app3" class="<?=show_sidebar_client([
                                'buffsub-sale', 'buffsub-sale-history', 
                                'buffsub-speed', 'buffsub-speed-history',
                                'buffsub-slow', 'buffsub-slow-history',
                                'bufflikefanpagesale', 'bufflikefanpagesale-history',
                                'bufflikefanpage', 'bufflikefanpage-history',
                                'buffsubfanpage', 'buffsubfanpage-history',
                                'bufflikecommentsharelike', 'bufflikecommentsharelike-history',
                                'bufflikecommentshareshare', 'bufflikecommentshareshare-history',
                                'buffviewstory', 'buffviewstory-history',
                                'buffgroup', 'buffgroup-history'
                                ]);?> submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                                <li class="sidebar-layout">
                                    <a href="#form1" class="svg-icon collapsed" data-toggle="collapse"
                                        aria-expanded="false">
                                        <i class="fab fa-facebook-square"></i>
                                        <span class="">Facebook</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="svg-icon iq-arrow-right arrow-active" width="15" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <ul id="form1" class="<?=show_sidebar_client([
                                        'buffsub-sale', 'buffsub-sale-history', 
                                        'buffsub-speed', 'buffsub-speed-history', 
                                        'buffsub-slow', 'buffsub-slow-history',
                                        'bufflikefanpagesale', 'bufflikefanpagesale-history',
                                        'bufflikefanpage', 'bufflikefanpage-history',
                                        'buffsubfanpage', 'buffsubfanpage-history',
                                        'bufflikecommentsharelike', 'bufflikecommentsharelike-history',
                                        'bufflikecommentshareshare', 'bufflikecommentshareshare-history',
                                        'buffviewstory', 'buffviewstory-history',
                                        'buffgroup', 'buffgroup-history'
                                    ]);?> submenu collapse" data-parent="#app3" style="">
                                        <li
                                            class="<?=active_sidebar_client(['buffsub-sale', 'buffsub-sale-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffsub-sale');?>" class="svg-icon">
                                                <i class="fas fa-rss"></i>
                                                <span class=""><?=__('BUFF SUB SALE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['buffsub-speed', 'buffsub-speed-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffsub-speed');?>" class="svg-icon">
                                                <i class="fas fa-rss"></i>
                                                <span class=""><?=__('BUFF SUB SPEED');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['buffsub-slow', 'buffsub-slow-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffsub-slow');?>" class="svg-icon">
                                                <i class="fas fa-rss"></i>
                                                <span class=""><?=__('BUFF SUB ĐỀ XUẤT');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['buffsubfanpage', 'buffsubfanpage-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffsubfanpage');?>" class="svg-icon">
                                                <i class="fas fa-rss"></i>
                                                <span class=""><?=__('BUFF SUB PAGE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['bufflikefanpage', 'bufflikefanpage-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/bufflikefanpage');?>" class="svg-icon">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span class=""><?=__('BUFF LIKE PAGE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['bufflikefanpagesale', 'bufflikefanpagesale-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/bufflikefanpagesale');?>" class="svg-icon">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span class=""><?=__('BUFF LIKE PAGE SALE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['bufflikecommentsharelike', 'bufflikecommentsharelike-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/bufflikecommentsharelike');?>" class="svg-icon">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span class=""><?=__('BUFF LIKE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['bufflikecommentshareshare', 'bufflikecommentshareshare-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/bufflikecommentshareshare');?>" class="svg-icon">
                                                <i class="fas fa-share"></i>
                                                <span class=""><?=__('BUFF SHARE PROFILE');?></span>
                                            </a>
                                        </li>
                                        <li
                                            class="<?=active_sidebar_client(['buffviewstory', 'buffviewstory-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffviewstory');?>" class="svg-icon">
                                                <i class="fas fa-eye"></i>
                                                <span class=""><?=__('BUFF VIEW STORY');?></span>
                                            </a>
                                        </li>
                                        <!-- <li
                                            class="<?=active_sidebar_client(['buffgroup', 'buffgroup-history']);?> sidebar-layout">
                                            <a href="<?=base_url('client/buffgroup');?>" class="svg-icon">
                                            <i class="fas fa-users"></i>
                                                <span class=""><?=__('BUFF MEMBER GROUP');?></span>
                                            </a>
                                        </li> -->
                                    </ul>
                                </li>
                            </ul>
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
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold"><?=__('Nạp Tiền');?></span></span>
                        </li>
                        <li class="<?=active_sidebar_client(['recharge']);?> sidebar-layout">
                            <a href="<?=base_url('client/recharge');?>" class="svg-icon ">
                                <i class="fas fa-university"></i>
                                <span class="ml-2"><?=__('Ngân Hàng');?></span>
                            </a>
                        </li>
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
                            <a href="<?=base_url('client/crypto');?>" class="svg-icon ">
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
                        <li class="<?=active_sidebar_client(['invoices']);?> sidebar-layout">
                            <a href="<?=base_url('client/invoices');?>" class="svg-icon ">
                                <i class="fas fa-file-invoice"></i>
                                <span class="ml-2"><?=__('Hoá Đơn');?></span>
                            </a>
                        </li>
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
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1 ORDER BY `id` DESC ") as $menu) {?>
                        <li class="sidebar-layout">
                            <a <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?> href="<?=$menu['href'];?>"
                                class="svg-icon ">
                                <?=$menu['icon'];?>
                                <span class="ml-2"><?=__($menu['name']);?></span>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </nav>
                <div class="pt-5 pb-5"></div>
            </div>
        </div>
        <?php require_once(__DIR__.'/nav.php');?>