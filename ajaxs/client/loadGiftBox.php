<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();

// hiển thị giftbox

if ($CMSNT->num_rows("SELECT * FROM `giftbox` WHERE `status` = 0 AND `user_id` = 0 ") > 0) {
    $html = '
    <div style="display: block; position: fixed; bottom: 40%; left: 50%; z-index: 1000; cursor: pointer; width: 30%;">
        <a href="'.base_url('client/giftbox/'.$CMSNT->get_row(" SELECT * FROM `giftbox` WHERE `status` = 0 AND `user_id` = 0  ")['id']).'" class="float-center">
            <img src="'.base_url($CMSNT->site('gif_giftbox')).'" width="100%">
        </a>
    </div>';
    die($html);
}
