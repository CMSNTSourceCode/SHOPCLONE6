<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Khuôn Mặt Ngẫu Nhiên').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

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
        require_once(__DIR__.'/../../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../../models/is_user.php');
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <iframe src="https://thispersondoesnotexist.com/" width="100%" height="700"
                    frameborder="0" scrolling="auto"><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span><span data-mce-type="bookmark"
                        style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;"
                        class="mce_SELRES_start">&#xFEFF;</span></iframe>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>