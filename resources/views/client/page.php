<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

if (isset($_GET['slug'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `menu` WHERE `slug` = '".check_string($_GET['slug'])."' AND `status` = 1 AND `content` != '' ")) {
        redirect(base_url());
    }
}else{
    redirect(base_url());
}
$body = [
    'title' => __($row['name']).' | '.$CMSNT->site('title'),
    'desc'   => __($row['name']),
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
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-5"><?=__($row['name']);?></h3>
                        <?=$row['content'];?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>