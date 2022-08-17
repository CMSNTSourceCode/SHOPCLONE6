<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>
<nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=BASE_URL('');?>" class="nav-link">HOME</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=base_url('client/contact');?>" target="_blank" class="nav-link">LIÊN HỆ QUẢN TRỊ VIÊN</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>