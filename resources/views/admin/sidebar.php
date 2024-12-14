<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php require_once(__DIR__.'/nav.php');?>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?=base_url('admin/');?>" class="brand-link">
               <center> <img width="100%" src="<?=base_url('assets/img/logo_dark.png');?>" alt="CMSNT.CO"></center>
            </a>
            <div class="sidebar">
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('admin/home');?>"
                                class="nav-link <?=active_sidebar(['home', '']);?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('admin/security');?>"
                                class="nav-link <?=active_sidebar(['security']);?>">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>
                                    Bảo mật
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('admin/ip-black');?>"
                                class="nav-link <?=active_sidebar(['ip-black']);?>">
                                <i class="nav-icon fa-solid fa-lock"></i> 
                                <p>
                                    IP Black
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('admin/addons');?>"
                                class="nav-link <?=active_sidebar(['addons']);?>">
                                <i class="nav-icon fas fa-puzzle-piece"></i>
                                <p>
                                    Addons
                                </p>
                            </a>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['product-add', 'account-view', 'connect-api-edit', 
                        'product-list', 'connect-api', 'connect-api-add', 'product-edit', 'accounts', 'product-order','category-list','category-edit','category-add', 'backup-list', 'account-sold'
                        ]);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Bán Tài Khoản
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/category-list');?>"
                                        class="nav-link <?=active_sidebar(['category-list', 'category-add', 'category-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Chuyên mục</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/product-list');?>"
                                        class="nav-link <?=active_sidebar(['product-list','product-edit','accounts','product-add', 'account-sold', 'account-view']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('index.php?module=admin&action=product-order');?>"
                                        class="nav-link <?=active_sidebar(['product-order']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/backup-list');?>"
                                        class="nav-link <?=active_sidebar(['backup-list']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>File backup</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/connect-api');?>"
                                        class="nav-link <?=active_sidebar(['connect-api', 'connect-api-add', 'connect-api-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kết nối API</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['document-add',
                        'document-list', 'document-edit', 'document-order',
                        'category-document-list', 'category-document-add', 
                        'category-document-edit'
                        ]);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Bán Tài Liệu (TUT)
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/category-document-list');?>"
                                        class="nav-link <?=active_sidebar(['category-document-list','category-document-edit','category-document-add']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Chuyên mục TUT</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/document-list');?>"
                                        class="nav-link <?=active_sidebar(['document-list','document-edit','document-add']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách TUT</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/document-order');?>"
                                        class="nav-link <?=active_sidebar(['document-order']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng mua TUT</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['config-rate-service', 'service-order']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-thumbs-up"></i>
                                <p>
                                    Bán Tương Tác
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/service-order');?>"
                                        class="nav-link <?=active_sidebar(['service-order']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('config-rate-service');?>"
                                        class="nav-link <?=active_sidebar(['config-rate-service']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['otp-config', 'otp-history']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-sim-card"></i>
                                <p>
                                    Thuê SIM
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/otp-history');?>"
                                        class="nav-link <?=active_sidebar(['otp-history']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('otp-config');?>"
                                        class="nav-link <?=active_sidebar(['otp-config']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['store-fanpage', 'store-fanpage-edit', 'store-fanpage-config', 'store-fanpage-orders']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fab fa-facebook-square"></i>
                                <p>
                                    Bán Fanpage/Group
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('store-fanpage');?>"
                                        class="nav-link <?=active_sidebar(['store-fanpage', 'store-fanpage-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quản lý sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/store-fanpage-orders');?>"
                                        class="nav-link <?=active_sidebar(['store-fanpage-orders']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/store-fanpage-config');?>"
                                        class="nav-link <?=active_sidebar(['store-fanpage-config']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['xu-add','xu-list', 'xu-edit', 'xu-config', 'xu-order']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Bán Xu
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('xu-list');?>"
                                        class="nav-link <?=active_sidebar(['xu-list', 'xu-add', 'xu-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quản lý xu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('xu-order');?>"
                                        class="nav-link <?=active_sidebar(['xu-order']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng mua xu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/xu-config');?>"
                                        class="nav-link <?=active_sidebar(['xu-config']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--
                        <li class="nav-item <?=menuopen_sidebar(['service-add',
                        'services', 'service-edit', 'service-order', 'service-order-edit']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fab fa-shopify"></i>
                                <p>
                                    Dịch Vụ Khác
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/service-add');?>"
                                        class="nav-link <?=active_sidebar(['service-add']);?>">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        <p>Thêm dịch vụ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/services');?>"
                                        class="nav-link <?=active_sidebar(['services','service-edit']);?>">
                                        <i class="fas fa-shopping-cart nav-icon"></i>
                                        <p>Danh sách dịch vụ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/service-order');?>"
                                        class="nav-link <?=active_sidebar(['service-order','service-order-edit']);?>">
                                        <i class="fas fa-chart-area nav-icon"></i>
                                        <p>Đơn hàng dịch vụ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>-->
                        <li class="nav-item <?=menuopen_sidebar(['flutterwave','crypto','sv2-autobank', 'logs', 'dong-tien', 'nap-the', 'paypal', 'spin-history', 'perfectmoney']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Lịch Sử
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('index.php?module=admin&action=logs');?>"
                                        class="nav-link <?=active_sidebar(['logs']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nhật ký hoạt động</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('index.php?module=admin&action=dong-tien');?>"
                                        class="nav-link <?=active_sidebar(['dong-tien']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Biến động số dư</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/nap-the');?>"
                                        class="nav-link <?=active_sidebar(['nap-the']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Nạp Thẻ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/paypal');?>"
                                        class="nav-link <?=active_sidebar(['paypal']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Nạp PayPal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/perfectmoney');?>"
                                        class="nav-link <?=active_sidebar(['perfectmoney']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Nạp PM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/crypto');?>"
                                        class="nav-link <?=active_sidebar(['crypto']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Nạp Crypto old</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/sv2-autobank');?>"
                                        class="nav-link <?=active_sidebar(['sv2-autobank']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Nạp Auto SV2</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/spin-history');?>"
                                        class="nav-link <?=active_sidebar(['spin-history']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử Vòng Quay</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/toyyibpay');?>"
                                        class="nav-link <?=active_sidebar(['toyyibpay']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Toyyibpay History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/flutterwave');?>"
                                        class="nav-link <?=active_sidebar(['flutterwave']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Flutterwave History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/squadco');?>"
                                        class="nav-link <?=active_sidebar(['squadco']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Squadco History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('index.php?module=admin&action=users');?>"
                                class="nav-link <?=active_sidebar(['users', 'user-edit', 'statistic']);?>">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>
                                    Thành Viên
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/email-campaigns');?>"
                                class="nav-link <?=active_sidebar(['email-campaigns', 'email-campaign-add', 'email-campaign-edit', 'email-sending-view']);?>">
                                <i class="nav-icon fa-solid fa-envelope"></i>
                                <p>
                                    <?=__('Email Campaigns');?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['affiliates', 'log-ref', 'withdraw']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Affiliates
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url_admin('withdraw');?>"
                                        class="nav-link <?=active_sidebar(['rwithdraw']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn rút tiền</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/log-ref');?>"
                                        class="nav-link <?=active_sidebar(['log-ref']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử hoa hồng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/affiliates');?>"
                                        class="nav-link <?=active_sidebar(['affiliates']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/bank-list');?>"
                                class="nav-link <?=active_sidebar(['bank-list', 'bank-edit']);?>">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Ngân Hàng
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=base_url_admin('recharge-crypto');?>"
                                class="nav-link <?=active_sidebar(['recharge-crypto']);?>">
                                <i class="nav-icon fas fa-coins"></i>
                                <p>
                                    Crypto
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/blog-list');?>"
                                class="nav-link <?=active_sidebar(['blog-list', 'blog-edit', 'blog-add']);?>">
                                <i class="nav-icon fab fa-blogger-b"></i>
                                <p>
                                    Bài Viết
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('index.php?module=admin&action=invoices');?>"
                                class="nav-link <?=active_sidebar(['invoices', 'invoice-edit']);?>">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>
                                    Hoá Đơn
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/coupon-list');?>"
                                class="nav-link <?=active_sidebar(['coupon-list', 'coupon-edit', 'coupon-add', 'coupon-log']);?>">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>
                                    Mã Giảm Giá
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/discount-list');?>"
                                class="nav-link <?=active_sidebar(['discount-list', 'discount-edit', 'discount-add']);?>">
                                <i class="nav-icon fa-solid fa-tag"></i>
                                <p>
                                    Giảm giá
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/promotion-list');?>"
                                class="nav-link <?=active_sidebar(['promotion-list', 'promotion-edit', 'promotion-add', 'promotion-log']);?>">
                                <i class="nav-icon fas fa-dollar"></i>
                                <p>
                                    Khuyến Mãi Nạp Tiền
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/domain-list');?>"
                                class="nav-link <?=active_sidebar(['domain-list']);?>">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Quản lý website con
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/notification');?>"
                                class="nav-link <?=active_sidebar(['notification']);?>">
                                <i class="nav-icon fas fa-bell"></i>
                                <p>
                                    Thông Báo
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/spin-list');?>"
                                class="nav-link <?=active_sidebar(['spin-list', 'spin-add', 'spin-edit']);?>">
                                <i class="nav-icon fas fa-gamepad"></i>
                                <p>
                                    Vòng Quay
                                </p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="<?=BASE_URL('admin/giftbox-list');?>"
                                class="nav-link <?=active_sidebar(['giftbox-list']);?>">
                                <i class="nav-icon fas fa-gift"></i>
                                <p>
                                    Gift Box
                                </p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/question-list');?>"
                                class="nav-link <?=active_sidebar(['question-list', 'question-edit', 'question-add']);?>">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>
                                    FAQ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/feedback-list');?>"
                                class="nav-link <?=active_sidebar(['feedback-list']);?>">
                                <i class="nav-icon fas fa-comment-dots"></i>
                                <p>
                                    Đánh Giá
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/menu-list');?>"
                                class="nav-link <?=active_sidebar(['menu-list', 'menu-add', 'menu-edit']);?>">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    Menu
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/language-list');?>"
                                class="nav-link <?=active_sidebar(['language-list','language-add', 'language-edit', 'translate-list']);?>">
                                <i class="nav-icon fas fa-language"></i>
                                <p>
                                    Ngôn Ngữ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/currency-list');?>"
                                class="nav-link <?=active_sidebar(['currency-list','currency-add', 'currency-edit']);?>">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Tiền Tệ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/theme');?>"
                                class="nav-link <?=active_sidebar(['theme']);?>">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Giao Diện
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/settings');?>"
                                class="nav-link <?=active_sidebar(['settings']);?>">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Cài Đặt
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        