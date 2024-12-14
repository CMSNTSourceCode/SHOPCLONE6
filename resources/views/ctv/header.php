<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$body['title'];?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?=BASE_URL('public/AdminLTE3/');?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=BASE_URL('public/AdminLTE3/');?>dist/css/adminlte.min.css">
    <!-- Cute Alert -->
    <link class="main-stylesheet" href="<?=BASE_URL('public/');?>cute-alert/style.css" rel="stylesheet"
        type="text/css">
    <script src="<?=BASE_URL('public/');?>cute-alert/cute-alert.js"></script>
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?=BASE_URL('public/AdminLTE3/');?>plugins/jqvmap/jqvmap.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?=BASE_URL('public/AdminLTE3/');?>plugins/summernote/summernote-bs4.css">
    <!-- Sparkline -->
    <script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/sparklines/sparkline.js"></script>
    <script src="https://use.fontawesome.com/99c3653b8b.js"></script>
    <!-- jQuery -->
    <script src="<?=base_url('public/js/jquery-3.6.0.js');?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <?=$body['header'];?>
</head>