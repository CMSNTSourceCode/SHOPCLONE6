<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=isset($body['title']) ? $body['title'] : $CMSNT->site('title');?></title>
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
    <link rel="stylesheet" href="<?=BASE_URL('public/datum');?>/assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Script Header -->
    <?=$CMSNT->site('javascript_header');?>
</head>
<!-- sweetalert2-->
<link class="main-stylesheet" href="<?=BASE_URL('public/');?>sweetalert2/default.css" rel="stylesheet" type="text/css">
<script src="<?=BASE_URL('public/');?>sweetalert2/sweetalert2.js"></script>
<!-- Cute Alert -->
<link class="main-stylesheet" href="<?=BASE_URL('public/');?>cute-alert/style.css" rel="stylesheet" type="text/css">
<script src="<?=BASE_URL('public/');?>cute-alert/cute-alert.js"></script>
<!-- jQuery -->
<script src="<?=base_url('public/js/jquery-3.6.0.js');?>"></script>
<script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
<style>
body {
    <?=$CMSNT->site('font_family');?>
}
.card-product {
    color: white;
    background-image: linear-gradient(to right, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color');?>, <?=$CMSNT->site('theme_color2');?>);
}
#loading-center {
    background: url(<?=$CMSNT->site('gif_loader') !=''? BASE_URL($CMSNT->site('gif_loader')): base_url('public/datum/assets/images/loader.gif');
    ?>) no-repeat scroll 50%;
    background-size: 20%;
    width: 100%;
    height: 100%;
    position: relative;
}
      
ol {
  counter-reset: li; 
  list-style: none; 
  padding: 0;
  text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol a {
  position: relative;
  display: block;
  padding: .4em .4em .4em .8em;
  margin: .5em 0 .5em 2.5em;
  background: #D3D4DA;
  color: #444;
  text-decoration: none;
  transition: all .3s ease-out;
}

ol a:hover {background: #DCDDE1;}       
ol a:before {
  content: counter(li);
  counter-increment: li;
  position: absolute;
  left: -2.5em;
  top: 50%;
  margin-top: -1em;
  background: #f9dd94;
  height: 2em;
  width: 2em;
  line-height: 2em;
  text-align: center;
  font-weight: bold;
}

ol a:after {
  position: absolute;
  content: "";
  border: .5em solid transparent;
  left: -1em;
  top: 50%;
  margin-top: -.5em;
  transition: all .3s ease-out;
}

ol a:hover:after {
  left: -.5em;
  border-left-color: #f9dd94;
}

.thumbnail_zoom {
  margin: 0 auto;
}

.thumbnail_zoom:hover {
  transform: scale(10); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
  position:absolute; 
  z-index: 999;
   
}
.img_thumbnail_zoom{
  height: 100px;
  border-width: 0.5px;
}
 

/* CSS */
.nav-link {
  align-items: center;
  background: #252525;
  border: 0 solid #E2E8F0;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  box-sizing: border-box;
  color: white;
  display: block;
  font-size: 1rem;
  font-weight: 700;
  height: 60px;
  margin: 5px;
  justify-content: center;
  line-height: 24px;
  overflow-wrap: break-word;
  padding: 22px 25px;
  text-decoration: none;
  width: auto;
  border-radius: 8px;
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}
.nav-pills .nav-item a {
    color: white;
}
</style>
<?=$body['header'];?>
<!-- Dev By CMSNT.CO | FB.COM/CMSNT.CO | ZALO.ME/0947838128 | MMO Solution -->