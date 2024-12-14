<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php require_once(__DIR__.'/nav.php');?>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?=base_url('ctv/');?>" class="brand-link">
               <center> <img width="100%" src="<?=base_url($CMSNT->site('logo_dark'));?>" alt="<?=$CMSNT->site('title');?>"></center>
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
                        <li class="nav-header">CTV Menu</li>
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('ctv/home');?>"
                                class="nav-link <?=active_sidebar(['home', '']);?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <!-- <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('ctv/withdraw');?>"
                                class="nav-link <?=active_sidebar(['withdraw', '']);?>">
                                <i class="nav-icon fa-solid fa-money-bill"></i>
                                <p>
                                    Rút tiền
                                </p>
                            </a>
                        </li> -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Sản Phẩm
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('ctv/product-add');?>"
                                        class="nav-link <?=active_sidebar(['product-add']);?>">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        <p>Thêm sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('ctv/product-list');?>"
                                        class="nav-link <?=active_sidebar(['product-list','product-edit','accounts']);?>">
                                        <i class="fas fa-shopping-cart nav-icon"></i>
                                        <p>Danh sách sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('ctv/product-order');?>"
                                        class="nav-link <?=active_sidebar(['product-order']);?>">
                                        <i class="fas fa-chart-area nav-icon"></i>
                                        <p>Đơn hàng đã bán</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>