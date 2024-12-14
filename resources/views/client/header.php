<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=isset($body['title']) ? $body['title'] : $CMSNT->site('title');?></title>
    <link rel="canonical" href="<?=get_url();?>" />
    <meta name="description" content="<?=isset($body['desc']) ? $body['desc'] : $CMSNT->site('desc');?>" />
    <meta name="keywords" content="<?=isset($body['keyword']) ? $body['keyword'] : $CMSNT->site('keyword');?>">
    <meta name="copyright" content="CMSNT.CO - THIẾT KẾ WEBSITE MMO" />
    <meta name="author" content="<?=$CMSNT->site('author');?>" />
    <!-- Open Graph data -->
    <meta property="og:title" content="<?=isset($body['title']) ? $body['title'] : $CMSNT->site('title');?>">
    <meta property="og:type" content="Website">
    <meta property="og:url" content="<?=base_url('');?>">
    <meta property="og:image:alt" content="<?=isset($body['desc']) ? $body['desc'] : $CMSNT->site('desc');?>">
    <meta property="og:image" content="<?=isset($body['image']) ? $body['image'] : BASE_URL($CMSNT->site('image'));?>">
    <meta property="og:description" content="<?=isset($body['desc']) ? $body['desc'] : $CMSNT->site('desc');?>">
    <meta property="og:site_name" content="<?=isset($body['title']) ? $body['title'] : $CMSNT->site('title');?>">
    <meta property="article:section" content="<?=isset($body['desc']) ? $body['desc'] : $CMSNT->site('desc');?>">
    <meta property="article:tag" content="<?=isset($body['keyword']) ? $body['keyword'] : $CMSNT->site('keyword');?>">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=BASE_URL($CMSNT->site('favicon'));?>" />
    <link rel="stylesheet" href="<?=BASE_URL('public/datum');?>/assets/css/backend-plugin.min.css">
    <!-- <link rel="stylesheet" href="<?=BASE_URL('public/datum');?>/assets/css/backend.css?v=1.0.0"> -->

    <link rel="stylesheet" href="<?=BASE_URL('resources');?>/css/responsive.css">
    <link rel="stylesheet" href="<?=BASE_URL('resources');?>/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="<?=BASE_URL('resources');?>/css/customize.css">
    <script src="<?=BASE_URL('resources');?>/js/jquery.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweetalert2-->
    <link class="main-stylesheet" href="<?=BASE_URL('public/');?>sweetalert2/default.css" rel="stylesheet"
        type="text/css">
    <script src="<?=BASE_URL('public/');?>sweetalert2/sweetalert2.js"></script>
    <!-- Cute Alert -->
    <link class="main-stylesheet" href="<?=BASE_URL('public/');?>cute-alert/style.css" rel="stylesheet" type="text/css">
    <script src="<?=BASE_URL('public/');?>cute-alert/cute-alert.js"></script>
    <!-- jQuery -->
    <script src="<?=base_url('public/js/jquery-3.6.0.js');?>"></script>
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    body {
        <?=$CMSNT->site('font_family');
        ?>
    }

    .card-product {
        color: white;
        background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color2'); ?>);
    }

    #loading-center {
        background: url(<?=$CMSNT->site('gif_loader') !=''? BASE_URL($CMSNT->site('gif_loader')): base_url('public/datum/assets/images/loader.gif');
        ?>) no-repeat scroll 50%;
        background-size: 20%;
        width: 100%;
        height: 100%;
        position: relative;
    }

    .change-mode .custom-switch.custom-switch-icon label.custom-control-label:after {
        top: 0;
        left: 0;
        width: 35px;
        height: 30px;
        border-radius: 5px 0 0 5px;
        background-color: <?=$CMSNT->site('theme_color'); ?>;
        border-color: <?=$CMSNT->site('theme_color'); ?>;
        z-index: 0;
    }
    </style>
    <?=$body['header'];?>
    <!-- Script Header -->
    <?=$CMSNT->site('javascript_header');?>
</head>
<!-- Dev By CMSNT.CO | FB.COM/CMSNT.CO | ZALO.ME/0947838128 | MMO Solution -->
