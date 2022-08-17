<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

if(isset($_GET['ref'])){
    if($row = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".check_string($_GET['ref'])."' ")){
        $_SESSION['ref'] = $row['id'];
        // CỘN LƯỢT CLICK
        $CMSNT->cong('users', 'ref_click', 1, " `id` = '".$row['id']."' ");
        redirect(base_url());
    }
    redirect(base_url());
}
redirect(base_url());
 
?>
 