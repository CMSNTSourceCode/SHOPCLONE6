<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/libs/db.php');
    require_once(__DIR__.'/libs/lang.php');
    require_once(__DIR__.'/config.php');
    require_once(__DIR__.'/libs/helper.php');
    $CMSNT = new DB();    
    // for ($i = 1; $i <= 500; $i++) {
    //     echo '1'.random('01233456789', 6).'|'.random('QWERTYUIOPASDFGHJKLZXCVBNM0123456789', 16).'<br>';
    // }
     
    function insert_options($name, $value){
        global $CMSNT;
        if (!$CMSNT->get_row("SELECT * FROM `settings` WHERE `name` = '$name' ")) {
            $CMSNT->insert("settings", [
                'name'  => $name,
                'value' => $value
            ]);
        }
    }
    $CMSNT->query(" ALTER TABLE `menu` ADD `position` INT(11) NOT NULL DEFAULT '3' AFTER `target` ");
    $CMSNT->query(" ALTER TABLE `menu` ADD `content` LONGTEXT NULL DEFAULT NULL AFTER `position` ");
    $CMSNT->query(" ALTER TABLE `menu` ADD `slug` TEXT NULL DEFAULT NULL AFTER `name` ");

    insert_options('recharge_notice', '');
    insert_options('contact_page', '');
    insert_options('gif_loading', '');
    insert_options('type_showProduct', 1);
    insert_options('clientId_paypal', '');
    insert_options('status_paypal', 1);
    insert_options('status_thesieure', 1);
    insert_options('token_thesieure', '');
    insert_options('check_time_cron_thesieure', 0);
    insert_options('api_napthe', '');
    insert_options('status_napthe', 1);
    insert_options('notice_napthe', '');
    insert_options('ck_napthe', 1);
    insert_options('chinh_sach_bao_mat', '');
    insert_options('dieu_khoan_su_dung', '');
    insert_options('status_update', 1);
    insert_options('status_captcha', 1);
    insert_options('session_login', '2592000'); // 1 tháng
    insert_options('gif_giftbox', '');
    insert_options('display_sold', 1);
    insert_options('status_zalopay', 1);
    insert_options('token_zalopay', '');
    insert_options('check_time_cron_zalopay', 0);
    insert_options('type_password', 'md5');
    insert_options('theme_color', '#0c2556');
    insert_options('min_recharge', 10000);
    insert_options('time_check_live', 1800);
    insert_options('currency', 'VND');
    insert_options('usd_rate', 23000);
    insert_options('clientSecret_paypal', '');
    insert_options('rate_paypal', 23000);
    insert_options('paypal_notice', '<p>Thay đổi ghi ch&uacute; nạp thẻ&nbsp;trong <strong>C&agrave;i Đặt -&gt;&nbsp;Ghi ch&uacute; nạp paypal</strong></p>');
    insert_options('gif_loader', 'public/datum/assets/images/loader.gif');
    insert_options('invoice_expiration', 86400); // 24h
    insert_options('mouse_click_effect', 1);
    insert_options('notice_spin', '<p>Thay đổi th&ocirc;ng b&aacute;o hệ thống&nbsp;trong <strong>C&agrave;i Đặt -&gt;&nbsp;Th&ocirc;ng b&aacute;o v&ograve;ng quay</strong></p>');
    insert_options('status_spin', 1);
    insert_options('condition_spin', 1000000);
    insert_options('status_perfectmoney', 1);
    insert_options('perfectmoney_notice', '<p>Thay đổi ghi chú nạp perfect money <strong>C&agrave;i Đặt -&gt;&nbsp;Ghi ch&uacute; nạp perfect money</strong></p>');
    insert_options('PAYEE_ACCOUNT_PM', '');
    insert_options('PAYMENT_UNITS_PM', 'USD');
    insert_options('perfectmoney_pass_pm', '');
    insert_options('rate_pm', 23000);
    insert_options('status_crypto', 1);
    insert_options('notice_crypto', '');
    insert_options('status_giao_dich_gan_day', 1);
    insert_options('check_time_cron_card', 0);
    insert_options('check_time_cron_checklivefb', 0);
    insert_options('partner_id_card', '');
    insert_options('partner_key_card', '');
    insert_options('javascript_header', '');
    insert_options('sign_view_product', 0);
    insert_options('display_box_shop', 1);
    insert_options('type_notice_order', 'Email');
    insert_options('font_family', "font-family: 'Roboto', sans-serif;");
    insert_options('time_delete_orders', 0);
    insert_options('check_time_cron_cron', 0);
    insert_options('display_show_product', 1);
    insert_options('display_rating', 1);
    insert_options('stt_giaodichao', 0);
    insert_options('theme_color2', '#0665d0');
    insert_options('stt_topnap', 1);
    insert_options('sv1_autobank', 1);
    insert_options('sv2_autobank', 1);
    insert_options('prefix_autobank', explode(".", $_SERVER['HTTP_HOST'])[0]);
    insert_options('status_buff_like_sub', 0);
    insert_options('token_autofb', '');
    insert_options('virtual_sold_quantity', 0);
    insert_options('domain_autofb', 'https://cmslike.com/');
    insert_options('status_buff_like_sub', 0);
    $CMSNT->update("settings", [
        'value' => 'https://cmslike.com/'
    ], "`name` = 'domain_autofb'" );
    insert_options('status_store_fanpage', 0);
    insert_options('notice_store_fanpage', '');
    insert_options('status_security', 0);
    insert_options('status_active_member', 0);
    insert_options('type_notification', 'telegram');
    insert_options('token_telegram', '');
    insert_options('chat_id_telegram', '');
    insert_options('buy_notification', '');
    insert_options('naptien_notification', '');
    insert_options('register_notification', '');
    insert_options('max_time_buy', 10);
    insert_options('time_delete_clone_die', 2592000);
    insert_options('check_time_cron1', 0);
    insert_options('bg_card', 'resources/images/bg-buy.png');
    insert_options('display_blog', 1);
    insert_options('display_question', 1);
    insert_options('display_contact', 1);
    insert_options('display_api', 1);
    insert_options('display_tool', 1);
    insert_options('status_connect_api', 1);
    insert_options('check_time_cron2', 0);
    insert_options('ck_connect_api', 10);
    insert_options('status_ref', 0);
    insert_options('ck_ref', 5);
    insert_options('notice_ref', '');
    insert_options('listbank_ref', '');
    insert_options('minrut_ref', 100000);

    $CMSNT->query(" ALTER TABLE `categories` ADD `id_api` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `users` ADD `chietkhau` FLOAT NOT NULL DEFAULT '0' AFTER `SecretKey_2fa` ");
    $CMSNT->query(" ALTER TABLE `accounts` ADD `time_live` INT(11) NOT NULL DEFAULT '0' AFTER `status` ");
    $CMSNT->query(" CREATE TABLE `documents` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(255) NULL DEFAULT NULL , `content` LONGTEXT NULL , `price` FLOAT NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , `create_date` DATETIME NOT NULL , `update_date` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `payment_paypal` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `trans_id` VARCHAR(255) NULL , `amount` FLOAT NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `payment_paypal` ADD `user_id` INT(11) NOT NULL AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `payment_paypal` ADD `price` INT(11) NOT NULL DEFAULT '0' AFTER `amount` ");
    $CMSNT->query(" ALTER TABLE `invoices` ADD `create_time` INT(11) NOT NULL DEFAULT '0' AFTER `update_date`, ADD `update_time` INT(11) NOT NULL DEFAULT '0' AFTER `create_time` ");
    $CMSNT->query(" CREATE TABLE `send_email` ( `id` INT NOT NULL AUTO_INCREMENT , `template` VARCHAR(255) NULL DEFAULT NULL , `receiver` VARCHAR(255) NULL DEFAULT NULL , `name` TEXT NULL DEFAULT NULL , `title` TEXT NULL , `content` LONGTEXT NULL , `bcc` TEXT NULL , `status` INT(11) NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL , `update_date` DATETIME NOT NULL , `response` TEXT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `spin_option` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` TEXT NULL , `price` INT(11) NOT NULL DEFAULT '0' , `rate` FLOAT NOT NULL DEFAULT '0' , `display` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `users` ADD `spin` INT(11) NOT NULL DEFAULT '0' AFTER `chietkhau` ");
    $CMSNT->query(" CREATE TABLE `spin_history` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(255) NULL DEFAULT NULL, `create_date` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `spin_history` ADD `trans_id` VARCHAR(255) NULL DEFAULT NULL AFTER `id` ");
    if ($CMSNT->num_rows("SELECT * FROM `spin_option` ") == 0) {
        $CMSNT->query(" INSERT INTO `spin_option` (`id`, `name`, `price`, `rate`, `display`) VALUES
        (1, '+ 20.000đ', 20000, 10, 1),
        (2, '+ 10.000đ', 10000, 20, 1),
        (3, '+ 50.000đ', 50000, 5, 1),
        (4, '+ 2.000đ', 2000, 30, 1),
        (5, '+ 100đ', 100, 30, 1),
        (6, '+ 100.000đ', 100000, 2, 1),
        (7, '+ 500.000đ', 500000, 0.5, 1),
        (8, '+ 30.000đ', 30000, 10, 1),
        (9, '+ 99.999đ', 99999, 5, 1),
        (10, '+ 11.111đ', 11111, 20, 1),
        (11, '+ 1.000.000đ', 1000000, 0.1, 1),
        (12, '+ 22.000', 22000, 20, 1),
        (13, '+ 222.222', 222222, 2, 1),
        (14, '+ 6.666đ', 6666, 30, 1),
        (15, '+ 77.777đ', 77777, 10, 1) ");
    }
    $CMSNT->query(" ALTER TABLE `accounts` ADD `create_time` INT(11) NOT NULL DEFAULT '0' AFTER `update_date`, ADD `update_time` INT(11) NOT NULL DEFAULT '0' AFTER `create_time` ");
    $CMSNT->query(" CREATE TABLE `payment_pm` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `payment_id` INT(11) NOT NULL DEFAULT '0' , `amount` INT(11) NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , `update_date` DATETIME NOT NULL , `update_time` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `spin_history` CHANGE `name` `name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `payment_pm` CHANGE `payment_id` `payment_id` VARCHAR(255) NULL DEFAULT NULL  ");
    $CMSNT->query(" ALTER TABLE `payment_pm` ADD `price` INT(11) NOT NULL DEFAULT '0' AFTER `amount` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `create_time` INT(11) NOT NULL DEFAULT '0' AFTER `create_date` ");
    $CMSNT->query(" ALTER TABLE `products` ADD `stt` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" CREATE TABLE `blogs` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` TEXT NULL DEFAULT NULL , `content` LONGTEXT NULL DEFAULT NULL , `display` INT(11) NOT NULL DEFAULT '0' , `image` VARCHAR(255) NULL DEFAULT NULL , `view` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `blogs` ADD `create_date` DATETIME NOT NULL AFTER `view` ");
    $CMSNT->query(" ALTER TABLE `blogs` ADD `slug` VARCHAR(255) NULL DEFAULT NULL AFTER `title` ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `name` `name` VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `categories` ADD `stt` INT(1) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `users` ADD `time_request` INT(11) NOT NULL DEFAULT '0' AFTER `time_session` ");
    $CMSNT->query(" ALTER TABLE `documents` ADD `image` TEXT NULL AFTER `name` ");
    $CMSNT->query(" CREATE TABLE `document_categories` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` TEXT NULL , `image` TEXT NULL , `status` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `document_categories` ADD `stt` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `documents` ADD `category_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id` ");
    $CMSNT->query(" ALTER TABLE `documents` ADD `stt` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `documents` ADD `slug` VARCHAR(255) NULL DEFAULT NULL AFTER `name` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `document_id` INT(11) NOT NULL DEFAULT '0' AFTER `product_id` ");
    $CMSNT->query(" CREATE TABLE `promotions` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `amount` FLOAT NOT NULL DEFAULT '0' , `discount` FLOAT NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `promotions` ADD `create_date` DATETIME NULL DEFAULT NULL AFTER `status` ");
    $CMSNT->query(" ALTER TABLE `promotions` ADD `update_date` DATETIME NULL AFTER `create_date` ");
    $CMSNT->query(" ALTER TABLE `promotions` CHANGE `amount` `amount` INT(11) NOT NULL DEFAULT '0' ");
    $CMSNT->query(" ALTER TABLE `products` ADD `time_delete_account` INT(11) NOT NULL DEFAULT '0' AFTER `preview` ");
    $CMSNT->query(" ALTER TABLE `invoices` ADD `description` TEXT NULL AFTER `note` ");
    $CMSNT->query(" ALTER TABLE `invoices` ADD `tid` TEXT NULL AFTER `description` ");
    $CMSNT->query(" CREATE TABLE `addons` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` TEXT NULL , `description` TEXT NULL , `image` TEXT NULL , `createdate` DATETIME NOT NULL , `price` INT(11) NOT NULL DEFAULT '0' , `purchase_key` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 1 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 1,
            'name'          => 'Template 3',
            'description'   => 'Giao diện bán sản phẩm #3',
            'image'         => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgXDYOrjeak2ntc5wVGM4l2R4eylah-1pBl7nspO8xZXvRbGnSg8bmZCX9SPhrBkFZCDB_SBMI2MwbjWsokznk6_Vx4miTCZb8-vO3l1isIuLW5T4ULf7HIMoo3q_Uvt0TJi4jbuGe7i_ID_pLgBmuJUhR6hOXq_yy5Oav6h_EP2yVXibJ28G5giDVO/s2063/screencapture-localhost-CMSNT-CO-SHOPCLONE6-2022-04-07-14_26_07-edit.png',
            'createdate'    => '2022-04-07 10:02:41',
            'price'         => 200000,
            'purchase_key'  => ''
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 2 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 2,
            'name'          => 'Tạo giao dịch ảo',
            'description'   => 'Tự động tạo giao dịch nạp tiền, mua sản phẩm ảo để tăng uy tín cho shop',
            'image'         => 'https://i.imgur.com/6kNRjfN.png',
            'createdate'    => '2022-04-07 20:52:41',
            'price'         => 100000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `invoices` ADD `fake` INT(11) NOT NULL DEFAULT '0' AFTER `tid` ");
    $CMSNT->query(" ALTER TABLE `invoices` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `fake` INT(11) NOT NULL DEFAULT '0' AFTER `display` ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 3 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 3,
            'name'          => 'Template 4',
            'description'   => 'Giao diện bán sản phẩm #4',
            'image'         => 'https://i.imgur.com/bXmRtMM.png',
            'createdate'    => '2022-04-09 15:42:41',
            'price'         => 200000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `users` ADD `rankings` INT(11) NOT NULL DEFAULT '0' AFTER `total_money` ");
    $CMSNT->query(" ALTER TABLE `users` ADD `icon_ranking` TEXT NOT NULL AFTER `rankings` ");
    $CMSNT->query(" ALTER TABLE `users` CHANGE `icon_ranking` `icon_ranking` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL ");
    $CMSNT->query(" ALTER TABLE `addons` CHANGE `name` `name` TEXT CHARACTER SET utf8 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `image` `image` TEXT CHARACTER SET utf8 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `purchase_key` `purchase_key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8mb4_general_ci NULL DEFAULT NULL ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 4 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 4,
            'name'          => 'Bảng Xếp Hạng Nạp Tiền',
            'description'   => 'Bảng xếp hàng nạp tiền cho thành viên',
            'image'         => 'https://i.imgur.com/ZRIRAaB.png',
            'createdate'    => '2022-04-12 02:42:41',
            'price'         => 200000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" UPDATE `addons` SET `image` = 'https://i.imgur.com/929iYyH.png' WHERE `id` = 1 ");
    $CMSNT->query(" ALTER TABLE `products` ADD `minimum` INT(11) NOT NULL DEFAULT '1' AFTER `time_delete_account`, ADD `maximum` INT(11) NOT NULL DEFAULT '10000' AFTER `minimum` ");
    $CMSNT->query(" CREATE TABLE `server2_autobank` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `tid` TEXT NULL , `description` TEXT NULL , `create_gettime` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 24 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 24,
            'name'          => 'Nạp Tiền Server 2',
            'description'   => 'Nạp tiền bằng nội dung + id',
            'image'         => 'https://i.imgur.com/CydpsWl.png',
            'createdate'    => '2022-04-19 01:40:11',
            'price'         => 500000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `server2_autobank` CHANGE `tid` `tid` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `server2_autobank` ADD UNIQUE(`tid`) ");
    $CMSNT->query(" ALTER TABLE `server2_autobank` ADD `amount` FLOAT NOT NULL DEFAULT '0' AFTER `description` ");
    $CMSNT->query(" ALTER TABLE `server2_autobank` ADD `received` FLOAT NOT NULL DEFAULT '0' AFTER `amount` ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 211 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 211,
            'name'          => 'Số Lượng Đã Bán Ảo',
            'description'   => 'Điều chỉnh số lượng đã bán ảo (số lượng ảo + số lượng thật)',
            'image'         => 'https://i.imgur.com/3tOOFDC.png',
            'createdate'    => '2022-04-26 01:40:11',
            'price'         => 50000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `invoices` CHANGE `tid` `tid` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `invoices` ADD UNIQUE(`tid`) ");



    for ($i=1; $i < 10; $i++) { 
        $CMSNT->query(" ALTER TABLE `server2_autobank` DROP INDEX `tid_$i` ");
        $CMSNT->query(" ALTER TABLE `invoices` DROP INDEX `tid_$i` ");
    }

    $CMSNT->query(" CREATE TABLE `order_autofb` (
        `id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL DEFAULT 0,
        `trans_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `id_rate_autofb` int(11) NOT NULL DEFAULT 0,
        `insertId` int(11) DEFAULT 0,
        `payment` int(11) NOT NULL DEFAULT 0,
        `payment_api` int(11) NOT NULL DEFAULT 0,
        `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `quantity` int(11) NOT NULL DEFAULT 0,
        `subscribers` int(11) NOT NULL DEFAULT 0,
        `count_success` int(11) NOT NULL DEFAULT 0,
        `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `server` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `create_time` int(11) NOT NULL DEFAULT 0,
        `create_gettime` datetime NOT NULL,
        `update_time` int(11) NOT NULL DEFAULT 0,
        `update_gettime` datetime NOT NULL,
        `status` int(11) NOT NULL DEFAULT 0
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ");

    $CMSNT->query(" CREATE TABLE `rate_autofb` (
        `id` int(11) NOT NULL,
        `type_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `name_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `loaiseeding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `price` float NOT NULL DEFAULT 0,
        `name_loaiseeding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ");


    if ($CMSNT->num_rows("SELECT * FROM `rate_autofb` ") == 0) {
        $CMSNT->query(" INSERT INTO `rate_autofb` (`id`, `type_api`, `name_api`, `loaiseeding`, `price`, `name_loaiseeding`, `note`) VALUES
        (1, 'buffsub_sale', 'Facebook buff sub sale (sv1)', '1', 20, 'Tăng Sub sale - SV1 (tốc độ ổn định)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (2, 'buffsub_sale', 'Facebook buff sub sale (sv2)', '2', 30, 'Tăng Sub sale - SV2 (tốc độ ổn định)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (3, 'buffsub_sale', 'Facebook buff sub sale (sv3)', '3', 10, 'Tăng Sub sale - SV3 (done trong ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (4, 'buffsub_sale', 'Facebook buff sub sale (sv4)', '4', 35, 'Tăng Sub sale - SV4 (tốc độ nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (7, 'buffsub_speed', 'Facebook buff sub speed (sv1)', '1', 50, 'Tăng Sub - SV1 (MAX 50K, bấm tay)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (8, 'buffsub_speed', 'Facebook buff sub speed (sv2)', '2', 50, 'Tăng Sub - SV2 (Lên khá nhanh, Max 1000k, Bảo hành 1 tháng) tốt nhất nên dùng', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (9, 'buffsub_speed', 'Facebook buff sub speed (sv3)', '3', 30, 'Tăng Sub - SV3 (Chạy được cho page pro5, 1k sub / ngày, max 250k sub clone, Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (10, 'buffsub_speed', 'Facebook buff sub speed (sv4)', '4', 30, 'Tăng Sub - SV4 (Lên ổn định, Max 80k, Bảo hành 1 tháng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (11, 'buffsub_speed', 'Facebook buff sub speed (sv5)', '5', 40, 'Tăng Sub - SV5 (Lên nhanh, Max 50k Lên cực nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (12, 'buffsub_speed', 'Facebook buff sub speed (sv6)', '6', 30, 'Tăng Sub - SV6 (Max 15k Hoàn thành trong 1-24H)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (13, 'buffsub_speed', 'Facebook buff sub speed (sv7)', '7', 30, 'Tăng Sub - SV7 (Max 20k Lên cực nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (14, 'buffsub_speed', 'Facebook buff sub speed (sv8)', '8', 60, 'Tăng Sub - SV8 (Lên rất nhanh, Max 600k, Bảo hành 6 tháng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (15, 'buffsub_speed', 'Facebook buff sub speed (sv9)', '9', 20, 'Tăng Sub - SV9 (Max 1000k , bảo hành 15 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (16, 'buffsub_slow', 'Facebook buff sub chậm (basic)', '1', 40, 'Tăng Sub đề xuất - Basic (BH 3 tháng, max 400k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (17, 'buffsub_slow', 'Facebook buff sub chậm (v1)', '3', 30, 'Tăng Sub đề xuất - V1 (BH 1 tháng, max 200k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (18, 'buffsub_slow', 'Facebook buff sub v2 (sv2)', '2', 60, 'Tăng Sub đề xuất - V3 (xịn nhất, nick đang hoạt động 96,69%, max 60k) (sub kết bạn, ẩn kết bạn hoặc qua thẳng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (19, 'buffsub_slow', 'Facebook buff sub chậm (v2)', '4', 30, 'Tăng Sub đề xuất - V2 (Chất lượng cao, ổn định, nên dùng max 200k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (20, 'bufflikefanpagesale', '', '1', 20, 'Tăng Like Fanpage - SV1 (Lên chậm khoảng 1-2k/ngày Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (21, 'bufflikefanpagesale', NULL, '2', 28, 'Tăng Like Fanpage - SV2 (Lên ổn định khoảng 5-10k/ngày Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (22, 'bufflikefanpagesale', NULL, '3', 31, 'Tăng Like Fanpage - SV3 (tốc độ rất nhanh (1 ngày mua max 20k, chạy done mai mua tiếp)) (BH 7 ngày )', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (23, 'bufflikefanpage', NULL, '1', 57, 'Tăng Like Fanpage - BASIC (like bấm tay, ít tụt, có 1 vài page ko thể tăng like) (Nên dùng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (24, 'bufflikefanpage', NULL, '2', 28, 'Tăng Like Fanpage - PRO (Like Via, max 200k tốc độ chậm Không bảo hành', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (25, 'bufflikefanpage', NULL, '3', 47, 'Tăng Like Fanpage - SV3 (MAX 40k BH 3 tháng) (Like lên chậm)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (26, 'bufflikefanpage', NULL, '4', 46, 'Tăng Like Fanpage - SV4 (MAX 20k BH 1 tháng) (Like lên chậm)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (27, 'bufflikefanpage', NULL, '5', 60, 'Tăng Like Fanpage - SV5 (MAX 50K BH 1 tháng) (Like chất lượng tốt) (Like lên nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (28, 'bufflikefanpage', NULL, '6', 67, 'Tăng Like Fanpage - SV6 (Like page Global (Like Tây Lên Nhanh ít tụt, nên sử dụng Bảo hành 45 ngày))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (29, 'bufflikefanpage', NULL, '7', 25, 'Tăng Like Fanpage - SV7 (Like Việt Lên nhanh (max 100k))(BH 60 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (30, 'bufflikefanpage', NULL, '8', 22, 'Tăng Like Fanpage - SV8 (Like việt, rẻ, nhanh (max 100k)) (BH 30 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (32, 'buffsubfanpage', NULL, '2', 42, 'Tăng Sub Fanpage - SV2 (page pro5 chạy sau 12-24h)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (33, 'buffsubfanpage', NULL, '1', 27, 'Tăng Sub Fanpage - SV1 (page thường, hoàn thành các đơn < 30k trong 24h)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (34, 'bufflikecommentsharelike', NULL, 'like', 58, 'Tăng Like Bài Viết (Like người việt thật) (max 50k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (35, 'bufflikecommentsharelike', NULL, 'like_v2', 10, 'Tăng Like Bài Viết V2 (Like việt clone, tốc độ chậm, có tụt like) (max 250k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (36, 'bufflikecommentsharelike', NULL, 'like_v3', 20, 'Tăng Like Bài Viết V3 (Like việt, rẻ, nhanh !) (max 50k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (37, 'bufflikecommentsharelike', NULL, 'like_v4', 24, 'Tăng Like Bài Viết V4 (Like Việt Lên nhanh (max 80k) có tụt like)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (38, 'bufflikecommentsharelike', NULL, 'like_v5', 27, 'Tăng Like Bài Viết V5 (Like Việt Lên nhanh(1 ngày chạy 15-25k like) có tụt like)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (39, 'bufflikecommentsharelike', NULL, 'like_v6', 16, 'Tăng Like Bài Viết V6 (Like clone nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (40, 'bufflikecommentsharelike', NULL, 'like_v7', 34, 'Tăng Like Bài Viết V7 (Like Việt Lên Max Nhanh,luôn oder được)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (41, 'bufflikecommentshareshare', NULL, 'share', 1000, 'Tăng Share Bài Viết SV1 (share người thật,share việt)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (42, 'bufflikecommentshareshare', NULL, 'share_sv2', 250, 'Tăng Share Bài Viết SV2 (share giá rẻ (không chạy đối với bài viết share bài viết khác))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (43, 'bufflikecommentshareshare', NULL, 'share_sv3', 30, 'Tăng Share Bài Viết SV3 (share ảo (không chạy đối với bài viết share bài viết khác))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (44, 'bufflikecommentshareshare', NULL, 'share_sv4', 410, 'Tăng Share Bài Viết SV4', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (45, 'bufflikecommentshareshare', NULL, 'share_sv5', 24, 'Tăng Share Bài Viết SV5 (share ảo rẻ)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
        (46, 'buffviewstory', NULL, '1', 18, 'Tăng View Story SV1', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.') ");
    }
    $CMSNT->query(" ALTER TABLE `order_autofb` ADD PRIMARY KEY (`id`) ");
    $CMSNT->query(" ALTER TABLE `rate_autofb` ADD PRIMARY KEY (`id`) ");
    $CMSNT->query(" ALTER TABLE `order_autofb` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT ");
    $CMSNT->query(" ALTER TABLE `rate_autofb` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT ");
    $CMSNT->query(" CREATE TABLE `store_fanpage` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `seller` INT(11) NOT NULL DEFAULT '0' , `buyer` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(255) NULL DEFAULT NULL , `icon` VARCHAR(255) NULL DEFAULT NULL , `uid` VARCHAR(255) NULL DEFAULT NULL , `type` VARCHAR(255) NULL DEFAULT NULL , `price` FLOAT NOT NULL DEFAULT '0' , `content` LONGTEXT NULL , `create_gettime` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , `update_gettime` DATETIME NOT NULL , `update_time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `store_fanpage_id` INT(11) NOT NULL DEFAULT '0' AFTER `document_id` ");
    $CMSNT->query(" ALTER TABLE `store_fanpage` ADD `sl_like` INT(11) NOT NULL DEFAULT '0' AFTER `uid` ");
    $CMSNT->query(" ALTER TABLE `store_fanpage` ADD `url` TEXT NULL AFTER `name`, ADD `new_name` VARCHAR(255) NULL AFTER `url` ");
    $CMSNT->query(" ALTER TABLE `store_fanpage` ADD `fb_admin` VARCHAR(255) NULL DEFAULT NULL AFTER `sl_like` ");
    $CMSNT->query(" ALTER TABLE `store_fanpage` ADD `note` LONGTEXT NULL DEFAULT NULL AFTER `update_time` ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 14232 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 14232,
            'name'          => 'Bán Fanpage/Group',
            'description'   => 'Addon bán Fanpage/Group thủ công',
            'image'         => 'https://i.imgur.com/jmIjBfI.png',
            'createdate'    => '2022-05-07 01:59:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `store_fanpage` ADD `nam_tao_fanpage` VARCHAR(255) NULL DEFAULT NULL AFTER `sl_like` ");
    $CMSNT->query(" CREATE TABLE `ip_white` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `ip` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`))  ");
    $CMSNT->query(" ALTER TABLE `users` ADD `active` INT(11) NOT NULL DEFAULT '0' AFTER `banned` ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 112246 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 112246,
            'name'          => 'BOT Telegram',
            'description'   => 'Addon thông báo về Telegram',
            'image'         => 'https://i.imgur.com/9Ci2geb.png',
            'createdate'    => '2022-06-26 16:00:00',
            'price'         => 300000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" CREATE TABLE `connect_api` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `domain` VARCHAR(255) NULL DEFAULT NULL , `username` VARCHAR(255) NULL DEFAULT NULL , `password` VARCHAR(255) NULL DEFAULT NULL , `price` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `connect_api` CHANGE `price` `price` VARCHAR(255) NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `products` ADD `id_api` INT(11) NOT NULL DEFAULT '0' AFTER `maximum` ");
    $CMSNT->query(" ALTER TABLE `products` ADD `id_connect_api` INT(11) NOT NULL DEFAULT '0' AFTER `id_api` ");
    $CMSNT->query(" ALTER TABLE `products` ADD `cost` INT(11) NOT NULL DEFAULT '0' AFTER `price`    ");
    $CMSNT->query(" ALTER TABLE `categories` ADD `id_connect_api` INT(11) NOT NULL DEFAULT '0' AFTER `id_api`  ");
    $CMSNT->query(" ALTER TABLE `products` ADD `api_stock` INT(11) NOT NULL DEFAULT '0' AFTER `id_connect_api`    ");
    $CMSNT->query(" ALTER TABLE `categories` DROP INDEX `name` ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `name` `name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `api_trans_id` VARCHAR(255) NULL DEFAULT NULL AFTER `trans_id`   ");
    $CMSNT->query(" ALTER TABLE `accounts` ADD `api_trans_id` VARCHAR(255) NULL DEFAULT NULL AFTER `trans_id`    ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `id_connect_api` INT(11) NOT NULL DEFAULT '0' AFTER `api_trans_id`    ");
    $CMSNT->query(" ALTER TABLE `connect_api` ADD `user_id` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `connect_api` CHANGE `price` `price` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `users` ADD `ref_id` INT(11) NOT NULL DEFAULT '0' AFTER `spin`, ADD `ref_click` INT(11) NOT NULL DEFAULT '0' AFTER `ref_id` ");
    $CMSNT->query(" ALTER TABLE `users` ADD `ref_money` FLOAT NOT NULL DEFAULT '0' AFTER `ref_click`    ");
    $CMSNT->query(" ALTER TABLE `users` ADD `ref_total_money` FLOAT NOT NULL DEFAULT '0' AFTER `ref_money`    ");
    $CMSNT->query(" ALTER TABLE `users` ADD `ref_amount` FLOAT NOT NULL DEFAULT '0' AFTER `ref_total_money`  ");
    $CMSNT->query(" CREATE TABLE `withdraw_ref` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `bank` VARCHAR(255) NULL DEFAULT NULL , `stk` VARCHAR(255) NULL DEFAULT NULL , `name` VARCHAR(255) NULL DEFAULT NULL , `amount` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `reason` TEXT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `log_ref` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `reason` TEXT NULL DEFAULT NULL , `sotientruoc` FLOAT NOT NULL DEFAULT '0' , `sotienthaydoi` FLOAT NOT NULL DEFAULT '0' , `sotienhientai` INT NOT NULL , `create_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `withdraw_ref` ADD `trans_id` VARCHAR(50) NOT NULL AFTER `id`, ADD UNIQUE (`trans_id`) ");
    $CMSNT->query(" ALTER TABLE `log_ref` CHANGE `sotienhientai` `sotienhientai` FLOAT(1) NOT NULL DEFAULT '0'    ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `price` `price` FLOAT NOT NULL DEFAULT '0'    ");
    $CMSNT->query(" ALTER TABLE `coupons` ADD `min` INT(11) NOT NULL DEFAULT '1000' AFTER `updatedate`, ADD `max` INT(11) NOT NULL DEFAULT '10000000' AFTER `min` ");
    insert_options('display_preview', 1);
    insert_options('display_country', 1);
    $CMSNT->query(" ALTER TABLE `products` ADD `name_api` VARCHAR(255) NULL DEFAULT NULL AFTER `api_stock` ");
    // $CMSNT->update('settings', [
    //     'value' => 1
    // ], " `name` = 'status_captcha' ");
    $CMSNT->query(" ALTER TABLE `users` ADD `change_password` INT(11) NOT NULL DEFAULT '0' AFTER `ref_amount` ");
    insert_options('apikey_nowpayments', '');
    insert_options('status_nowpayments', 0);
    insert_options('status_is_change_password', 1);
    insert_options('auto_rename_api', 0);
    $CMSNT->query(" ALTER TABLE `orders` ADD `cost` FLOAT NOT NULL DEFAULT '0' AFTER `pay`    ");
    insert_options('ipn_nowpayments', '');
    insert_options('min_crypto', 10);
    insert_options('rate_crypto', 23000);
    $CMSNT->query(" CREATE TABLE `nowpayments` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `payment_id` VARCHAR(50) NULL DEFAULT NULL , `invoice_id` VARCHAR(50) NULL DEFAULT NULL , `payment_status` VARCHAR(50) NULL DEFAULT NULL , `pay_address` VARCHAR(255) NULL DEFAULT NULL , `price_amount` FLOAT NOT NULL DEFAULT '0' , `price_currency` VARCHAR(255) NULL DEFAULT NULL , `pay_amount` FLOAT NOT NULL DEFAULT '0' , `actually_paid` FLOAT NOT NULL DEFAULT '0' , `pay_currency` VARCHAR(255) NULL DEFAULT NULL , `order_id` VARCHAR(255) NULL DEFAULT NULL , `order_description` VARCHAR(255) NULL DEFAULT NULL , `purchase_id` VARCHAR(255) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , `outcome_amount` FLOAT NOT NULL DEFAULT '0' , `outcome_currency` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `nowpayments` CHANGE `order_description` `order_description` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ");
    insert_options('check_time_cron_crypto', 0);
    $CMSNT->query(" ALTER TABLE `nowpayments` ADD `price` FLOAT NOT NULL DEFAULT '0' AFTER `price_amount` ");
    $CMSNT->query(" ALTER TABLE `connect_api` ADD `type` VARCHAR(255) NULL DEFAULT 'CMSNT' AFTER `user_id`    ");
    insert_options('check_time_cron3', 0);
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11412 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11412,
            'name'          => 'API 1',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-07-26 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('menu_title', mb_strtoupper(__($_SERVER['SERVER_NAME']), 'UTF-8'));
    $CMSNT->query(" ALTER TABLE `products` ADD `update_api` INT(11) NOT NULL DEFAULT '0' AFTER `name_api`   ");
    insert_options('default_api_product_status', 1);
    insert_options('min_gd_ao', 1);
    insert_options('max_gd_ao', 30);
    insert_options('speed_buy_gd_ao', 10);
    insert_options('amount_nap_ao', '10000
20000
40000
50000
60000
70000
100000
200000
300000
500000
400000
40000
15000
25000
35000
45000
55000
65000
45000
1000000
1500000
2000000');
    insert_options('speed_nap_gd_ao', 10);
    insert_options('position_gd_gan_day', 2);
    if($CMSNT->num_rows("SELECT * FROM `addons` WHERE `id` = 2 AND `price` = 100000 ")){
        $CMSNT->update('addons', [
            'price' => 500000
        ], " `id` = 2 ");
    }
    insert_options('is_account_buy_fake', 0);
    insert_options('hide_product_empty', 0);
    insert_options('email_nowpayments', '');
    insert_options('password_nowpayments', '');
    $CMSNT->query(" ALTER TABLE `products` ADD `sold` INT(11) NOT NULL DEFAULT '0' AFTER `update_api`    ");
    $CMSNT->query(" ALTER TABLE `products` ADD `filter_time_checklive` INT(11) NOT NULL DEFAULT '1' AFTER `sold` ");

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11413 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11413,
            'name'          => 'API 4',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-07-26 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron4', 0);
    $CMSNT->query(" ALTER TABLE `categories` CHANGE `id_api` `id_api` VARCHAR(50) NOT NULL DEFAULT '0' ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `id_api` `id_api` VARCHAR(50) NOT NULL DEFAULT '0'    ");

    foreach($CMSNT->get_list(" SELECT * FROM `products` ") as $product){
        $amount = $CMSNT->get_row(" SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NOT NULL ")['COUNT(id)'];
        $CMSNT->cong('products', 'sold', $amount, " `id` = '".$product['id']."' ");
    }
    $CMSNT->query(" ALTER TABLE `connect_api` ADD `token` TEXT NULL DEFAULT NULL AFTER `password` ");
    $CMSNT->update('addons', [
        'description' => 'Kết nối API sản phẩm website không dùng API của CMSNT'
    ], " `id` = 11413 ");
    insert_options('home_page', 'home');
    $CMSNT->query(" ALTER TABLE `orders` ADD `name` BLOB NULL DEFAULT NULL AFTER `trans_id` ");

 
    $CMSNT->query(" ALTER TABLE `users` CHANGE `username` `username` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL    ");
    insert_options('notice_popup', '');
    $CMSNT->query(" CREATE TABLE `currencies` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` TEXT NULL DEFAULT NULL , `code` VARCHAR(50) NULL DEFAULT NULL , `rate` FLOAT NOT NULL DEFAULT '0' , `symbol_left` TEXT NULL DEFAULT NULL , `symbol_right` TEXT NULL DEFAULT NULL , `seperator` TEXT NULL DEFAULT NULL , `display` INT(11) NOT NULL DEFAULT '1' , `default` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->remove('addons', " `id` = 12145 ");
    $CMSNT->query(" ALTER TABLE `users` CHANGE `money` `money` FLOAT NOT NULL DEFAULT '0'    ");
    $CMSNT->query(" ALTER TABLE `currencies` CHANGE `default` `default_currency` INT(11) NOT NULL DEFAULT '0' ");
    $CMSNT->query(" ALTER TABLE `currencies` ADD `decimal_currency` INT(11) NOT NULL DEFAULT '0' AFTER `default_currency`    ");
    $CMSNT->query(" ALTER TABLE `currencies` CHANGE `name` `name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `symbol_left` `symbol_left` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `symbol_right` `symbol_right` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `seperator` `seperator` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ");
    if(!$CMSNT->get_row("SELECT * FROM `currencies` WHERE `code` = 'VND' ")){
        $CMSNT->insert('currencies', [
            'name'  => 'Đồng',
            'code'  => 'VND',
            'rate'  => 1,
            'symbol_left'   => NULL,
            'symbol_right'  => 'đ',
            'seperator' => 'dot',
            'display'   => 1,
            'default_currency'  => 1,
            'decimal_currency'  => 0
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `currencies` WHERE `code` = 'USD' ")){
        $CMSNT->insert('currencies', [
            'name'  => 'Dollar',
            'code'  => 'USD',
            'rate'  => 23558,
            'symbol_left'   => '$',
            'symbol_right'  => NULL,
            'seperator' => 'dot',
            'display'   => 1,
            'default_currency'  => 0,
            'decimal_currency'  => 2
        ]);
    }
    $CMSNT->query(" ALTER TABLE `products` CHANGE `cost` `cost` FLOAT NOT NULL DEFAULT '0'    ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11422 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11422,
            'name'          => 'API DONGVAN..',
            'description'   => 'Kết nối API sản phẩm website DONGVAN..',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-09-14 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron_dongvanfb', 0);
    $CMSNT->update('addons', [
        'name'          => 'API 5',
        'description' => 'Kết nối API sản phẩm website không dùng API của CMSNT'
    ], " `id` = 11422 ");

    insert_options('timezone', 'Asia/Ho_Chi_Minh');
    insert_options('status_addfun_seller', 1);
    insert_options('status_store_document', 1);
    insert_options('noti_import_telegram', '');
    insert_options('group_id_import_telegram', '');
    $CMSNT->query(" ALTER TABLE `products` CHANGE `name` `name` BLOB NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `content` `content` LONGBLOB NULL DEFAULT NULL     ");
    insert_options('max_register_ip', 5);

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11427 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11427,
            'name'          => 'API 6',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-07-26 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron6', 0);
    insert_options('pin_cron', '');
    insert_options('status_toyyibpay', 0);
    insert_options('notice_toyyibpay', '');
    insert_options('userSecretKey_toyyibpay', '');
    insert_options('min_toyyibpay', 1);
    insert_options('categoryCode_toyyibpay', '');
    insert_options('check_time_cron_toyyibpay', 0);
    insert_options('rate_toyyibpay', 5258);
    $CMSNT->query(" CREATE TABLE `toyyibpay_transactions` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `trans_id` VARCHAR(50) NULL DEFAULT NULL , `billName` TEXT NULL DEFAULT NULL , `amount` FLOAT NOT NULL , `status` INT(11) NOT NULL DEFAULT '0' , `BillCode` VARCHAR(50) NULL DEFAULT NULL , `create_date` DATETIME NOT NULL , `update_date` DATETIME NOT NULL , PRIMARY KEY (`id`), UNIQUE (`trans_id`), UNIQUE (`BillCode`)) ");
    $CMSNT->query(" ALTER TABLE `toyyibpay_transactions` ADD `reason` TEXT NULL DEFAULT NULL AFTER `update_date`    ");
    insert_options('billChargeToCustomer', '');
    $CMSNT->query(" ALTER TABLE `connect_api` ADD `auto_rename_api` INT(11) NOT NULL DEFAULT '".$CMSNT->site('auto_rename_api')."' AFTER `status`, ADD `ck_connect_api` FLOAT NOT NULL DEFAULT '".$CMSNT->site('ck_connect_api')."' AFTER `auto_rename_api` ");

    $CMSNT->query(" ALTER TABLE `users` CHANGE `total_money` `total_money` FLOAT NOT NULL DEFAULT '0'    ");


    // CHỨC NĂNG TẠO CHIẾN DỊCH EMAIL MARKETING
    $CMSNT->query(" CREATE TABLE `email_campaigns` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` TEXT NULL DEFAULT NULL , `subject` TEXT NULL DEFAULT NULL , `cc` TEXT NULL DEFAULT NULL , `bcc` TEXT NULL DEFAULT NULL , `content` LONGBLOB NULL DEFAULT NULL , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `status` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `email_sending` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `camp_id` INT(11) NULL DEFAULT '0' , `user_id` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `email_sending` ADD `update_gettime` DATETIME NOT NULL AFTER `create_gettime` ");
    insert_options('check_time_cron_sending_email', 0);
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11469 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11469,
            'name'          => 'Email Campaigns',
            'description'   => 'Gửi Email đến toàn bộ khách hàng của bạn',
            'image'         => 'https://i.imgur.com/iQWAKTY.jpg',
            'createdate'    => '2022-11-02 00:00:00',
            'price'         => 300000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `email_sending` ADD `response` TEXT NULL DEFAULT NULL AFTER `update_gettime`    ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11487 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11487,
            'name'          => 'API 7',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-11-03 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron7', 0);
    $CMSNT->query(" ALTER TABLE `connect_api` CHANGE `password` `password` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `connect_api` CHANGE `username` `username` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL    ");
    insert_options('host_smtp', 'smtp.gmail.com');
    insert_options('encryption_smtp', 'tls');
    insert_options('port_smtp', '587');

    // BÁN LIKE SUB
    $CMSNT->query(" ALTER TABLE `services` ADD `id_api` VARCHAR(50) NULL DEFAULT '0' AFTER `status`, ADD `type` VARCHAR(50) NULL DEFAULT NULL AFTER `id_api`, ADD `min` INT(11) NOT NULL DEFAULT '0' AFTER `type`, ADD `max` INT(11) NOT NULL DEFAULT '0' AFTER `min`, ADD `dripfeed` VARCHAR(50) NULL DEFAULT NULL AFTER `max`, ADD `refill` VARCHAR(50) NULL DEFAULT NULL AFTER `dripfeed`, ADD `cancel` VARCHAR(50) NULL DEFAULT NULL AFTER `refill` ");
    $CMSNT->query(" CREATE TABLE `category_service` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NULL DEFAULT NULL , `display` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `category_service` CHANGE `name` `name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `category_service` CHANGE `name` `name` BLOB NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `services` CHANGE `name` `name` BLOB NULL DEFAULT NULL ");
    $CMSNT->query(" ALTER TABLE `services` ADD `category_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`    ");
    $CMSNT->query(" ALTER TABLE `services` ADD `note` TEXT NULL DEFAULT NULL AFTER `cancel`    ");
    $CMSNT->query(" ALTER TABLE `services` ADD `cost` FLOAT NOT NULL DEFAULT '0' AFTER `price`   ");
    $CMSNT->query(" ALTER TABLE `services` CHANGE `price` `price` FLOAT NOT NULL DEFAULT '0'    ");
    $CMSNT->query(" ALTER TABLE `services` ADD `source_api` VARCHAR(255) NULL DEFAULT '5gsmm.com' AFTER `note` ");
    insert_options('token_5gsmm', '');
    $CMSNT->query(" CREATE TABLE `order_service` ( `id` INT NOT NULL AUTO_INCREMENT , `buyer` INT(11) NOT NULL DEFAULT '0' , `id_api` VARCHAR(50) NULL DEFAULT NULL , `server` TEXT NULL DEFAULT NULL , `service_id` INT(11) NOT NULL DEFAULT '0' , `amount` INT(11) NOT NULL DEFAULT '0' , `price` FLOAT NOT NULL DEFAULT '0' , `url` TEXT NULL DEFAULT NULL , `note` TEXT NULL DEFAULT NULL , `trans_id` VARCHAR(50) NULL DEFAULT NULL , `comment` TEXT NULL DEFAULT NULL , `task_note` TEXT NULL DEFAULT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `update_time` INT(11) NOT NULL DEFAULT '0' , `update_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `services` CHANGE `note` `note` BLOB NULL DEFAULT NULL");
    $CMSNT->query(" ALTER TABLE `order_service` ADD `remains` INT(11) NOT NULL DEFAULT '0' AFTER `amount` ");
    $CMSNT->query(" ALTER TABLE `order_service` ADD `status` VARCHAR(50) NULL DEFAULT 'Pending' AFTER `update_gettime`    ");
    insert_options('ck_rate_service', 0);
    insert_options('status_updatec_rate_service', 'ON');
    insert_options('rate_vnd_5gsmm', 24867);
    insert_options('check_time_cron_UpdateRate5gsmm', 0);
    insert_options('check_time_cron_UpdateHistory5gsmm', 0);
    $CMSNT->query(" ALTER TABLE `order_service` ADD `refund` INT(11) NOT NULL DEFAULT '0' AFTER `status` ");

    $CMSNT->query(" ALTER TABLE `email_sending` ADD `response` TEXT NULL DEFAULT NULL AFTER `update_gettime`    ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11521 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11521,
            'name'          => 'Bán Like, Follow MXH',
            'description'   => 'Tích hợp bán like, follow mạng xã hội vào mã nguồn SHOPCLONE6',
            'image'         => 'https://i.imgur.com/gS5RRnm.png',
            'createdate'    => '2022-11-11 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    //
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11535 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11535,
            'name'          => 'API 8',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-11-11 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron8', 0);
    insert_options('taohoadonnaptien_notification', '');
    insert_options('copyright_footer', 'Powered By <a target="_blank" href="https://www.cmsnt.co/?ref='.base_url().'">CMSNT.CO</a>');

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11542 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11542,
            'name'          => 'API 9',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-11-23 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron9', 0);
    // $CMSNT->query(" ALTER TABLE `categories` CHANGE `name` `name` LONGBLOB NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `categories` CHANGE `id_api` `id_api` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'    ");
    insert_options('status_api_buyproduct', 1);
    $CMSNT->query(" ALTER TABLE `products` CHANGE `name_api` `name_api` BLOB NULL DEFAULT NULL    ");
    insert_options('marquee_notication_shopacc', '');

    // tich hop thue api
    insert_options('status_thuesim', 0);
    insert_options('server_thuesim', '');
    insert_options('domain_thuesim', '');
    insert_options('title_thuesim', 'Dịch vụ Thuê OTP, Thuê SIM tự động uy tín');
    insert_options('description_thuesim', 'Dịch vụ Thuê OTP, Thuê SIM tự động uy tín');
    insert_options('keyword_thuesim', 'thue sim, thue otp, thue sms');
    insert_options('token_thuesim', '');
    insert_options('ck_rate_thuesim', 0);
    insert_options('check_time_cron_service_otp_cron', 0);
    $CMSNT->query(" CREATE TABLE `service_otp` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `server` TEXT NULL DEFAULT NULL , `id_api` INT(11) NOT NULL DEFAULT '0' , `name_api` TEXT NULL DEFAULT NULL , `name` TEXT NULL DEFAULT NULL , `price_api` FLOAT NOT NULL DEFAULT '0' , `price` FLOAT NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ");
    insert_options('notice_thuesim', '');
    $CMSNT->query(" CREATE TABLE `otp_history` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `id_service_otp` INT(11) NOT NULL DEFAULT '0' , `number` TEXT NULL DEFAULT NULL , `id_order_api` INT(11) NOT NULL DEFAULT '0' , `app` TEXT NULL DEFAULT NULL , `price` FLOAT NOT NULL DEFAULT '0' , `code` TEXT NULL DEFAULT NULL , `create_gettime` DATETIME NOT NULL , `create_time` INT(11) NOT NULL DEFAULT '0' , `update_time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `otp_history` ADD `user_id` INT(11) NOT NULL DEFAULT '0' AFTER `id_service_otp`    ");
    $CMSNT->query(" ALTER TABLE `otp_history` ADD `cost` FLOAT NOT NULL DEFAULT '0' AFTER `price`    ");
    $CMSNT->query(" ALTER TABLE `otp_history` ADD `sms` TEXT NULL DEFAULT NULL AFTER `code`    ");
    $CMSNT->query(" ALTER TABLE `otp_history` ADD `status` INT(11) NOT NULL DEFAULT '1' AFTER `update_time`    ");
    $CMSNT->query(" ALTER TABLE `service_otp` ADD `update_time` INT(11) NOT NULL DEFAULT '0' AFTER `status`    ");
    insert_options('check_time_cron_service_otp_history', 0);
    $CMSNT->query(" ALTER TABLE `otp_history` ADD `transid` TEXT NULL DEFAULT NULL AFTER `id`    ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11621 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11621,
            'name'          => 'Tích hợp thuê OTP qua API 1',
            'description'   => 'Chức năng thuê SIM tích hợp qua API 1',
            'image'         => 'https://i.imgur.com/wQlNAcH.png',
            'createdate'    => '2022-12-13 00:00:00',
            'price'         => 2000000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->update("addons", [
        'name'          => 'Tích hợp thuê OTP qua API 1',
        'description'   => 'Chức năng thuê SIM tích hợp qua API 1',
        'image'         => 'https://i.imgur.com/wQlNAcH.png',
        'createdate'    => '2022-12-13 00:00:00',
        'price'         => 1000000
    ], " `id` = 11621 ");
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11634 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11634,
            'name'          => 'Tích hợp thuê OTP qua API 2',
            'description'   => 'Chức năng thuê SIM tích hợp qua API 2',
            'image'         => 'https://i.imgur.com/wQlNAcH.png',
            'createdate'    => '2022-12-28 00:00:00',
            'price'         => 2000000,
            'purchase_key'  => ''
        ]);
    }

    // end


    $CMSNT->query(" ALTER TABLE `services` ADD `update_time` INT(11) NOT NULL DEFAULT '0' AFTER `source_api`    ");


    // API 10
    insert_options('check_time_cron10', 0);
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11635 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11635,
            'name'          => 'API 10',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2022-12-19 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `products` CHANGE `api_stock` `api_stock` FLOAT NOT NULL DEFAULT '0'    ");
    //



    $CMSNT->query(" CREATE TABLE `domains` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `domain` VARCHAR(50) NULL DEFAULT NULL , `status` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`domain`)) ");
    $CMSNT->query(" ALTER TABLE `domains` ADD `admin_note` TEXT NULL DEFAULT NULL AFTER `status` ");
    $CMSNT->query(" ALTER TABLE `domains` ADD `create_gettime` DATETIME NOT NULL AFTER `admin_note`, ADD `update_gettime` DATETIME NOT NULL AFTER `create_gettime` ");
    insert_options('text_create_website', '<ul>
    <li>Bước 1: Trỏ IP <b style="color: red;">103.14.48.40</b> vào bản ghi Host @ và www trong tên miền của bạn, có thể liên hệ nhà cung cấp tên miền để nhờ trỏ giúp.</li>
    <li>Bước 2: Nhập tên miền muốn đăng ký đại lý và nhấn Thêm Ngay.</li>
    <li>Bước 3: Chờ đợi QTV setup website (thanh trạng thái thay đổi thành <b
            style="color: green;">Hoạt Động</b>).</li>
    <li>Bước 4: Truy cập Website bạn vừa tạo và nhập thông tin token và đăng ký
        1 tài khoản quản trị của
        bạn (tài khoản đầu tiên sẽ là tài khoản admin, lưu ý không để lộ tên
        miền ra khi chưa setup xong website).</li>
</ul>');
    insert_options('status_create_website', 0);
    insert_options('stt_create_website', 0);
    insert_options('create_website_notification', '');
    
    // API 11
    insert_options('check_time_cron11', 0);
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11645 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11645,
            'name'          => 'API 11',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-01-02 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11656 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11656,
            'name'          => 'Tích hợp thuê OTP qua API 3',
            'description'   => 'Chức năng thuê SIM tích hợp qua API 3',
            'image'         => 'https://i.imgur.com/wQlNAcH.png',
            'createdate'    => '2023-01-10 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }

    $CMSNT->query(" ALTER TABLE `users` ADD `ref_ck` FLOAT NOT NULL DEFAULT '0' AFTER `ref_amount` ");

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11657 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11657,
            'name'          => 'API 12',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-02-06 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron12', 0);

    $CMSNT->query(" CREATE TABLE `crypto_invoice` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `trans_id` TEXT NULL DEFAULT NULL , `user_id` INT(11) NOT NULL DEFAULT '0' , `request_id` TEXT NULL DEFAULT NULL , `amount` DECIMAL(18,6) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `status` VARCHAR(55) NULL DEFAULT NULL , `msg` TEXT NULL DEFAULT NULL , `url_payment` TEXT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");
    insert_options('crypto_address', '');
    insert_options('crypto_token', '');
    insert_options('crypto_min', 10);
    insert_options('crypto_max', 1000000);
    
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11678 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11678,
            'name'          => 'Tích hợp thuê OTP qua API 4',
            'description'   => 'Chức năng thuê SIM tích hợp qua API 4',
            'image'         => 'https://i.imgur.com/wQlNAcH.png',
            'createdate'    => '2023-02-06 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->query(" ALTER TABLE `service_otp` CHANGE `id_api` `id_api` TEXT NULL DEFAULT NULL    ");
    $CMSNT->query("ALTER TABLE `otp_history` CHANGE `id_order_api` `id_order_api` TEXT NULL DEFAULT NULL");

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11724 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11724,
            'name'          => 'API 13',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-02-08 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron13', 0);

    insert_options('flutterwave_api_key' , '');
    insert_options('flutterwave_api_secret' , '');
    insert_options('prefix_invoice', 'NT');
    $CMSNT->query(" ALTER TABLE `dongtien` CHANGE `noidung` `noidung` BLOB NULL DEFAULT NULL ");

    $CMSNT->query(" ALTER TABLE `users` ADD `token_forgot_password` VARCHAR(255) NULL DEFAULT NULL AFTER `change_password`, ADD `time_forgot_password` INT(11) NOT NULL DEFAULT '0' AFTER `token_forgot_password` ");
    $CMSNT->query(" ALTER TABLE `categories` CHANGE `id_api` `id_api` VARCHAR(52) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' ");

    insert_options('logo_login', $CMSNT->site('logo_light'));

    // $CMSNT->query(" ALTER TABLE `categories` ADD UNIQUE(`name`)    ");

    insert_options('domain_smmpanel', 'https://5gsmm.com/');
    $CMSNT->query(" ALTER TABLE `connect_api` CHANGE `ck_connect_api` `ck_connect_api` FLOAT NOT NULL DEFAULT '0' ");
    $CMSNT->query(" ALTER TABLE `categories` CHANGE `id_api` `id_api` VARCHAR(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'    ");
    $CMSNT->query("ALTER TABLE `products` CHANGE `content` `content` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL  ");
    insert_options('show_category', 'head');
    $CMSNT->query(" ALTER TABLE `orders` ADD `refund` INT(11) NOT NULL DEFAULT '0' AFTER `fake` ");

    // Flutterwave Nigeria Recharge
    insert_options('flutterwave_status', 0);
    insert_options('flutterwave_publicKey', '');
    insert_options('flutterwave_secretKey', '');
    insert_options('flutterwave_rate', 24000);
    insert_options('flutterwave_notice', '');
    $CMSNT->query(" CREATE TABLE `payment_flutterwave` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `tx_ref` VARCHAR(55) NULL DEFAULT NULL , `amount` FLOAT NOT NULL DEFAULT '0' , `currency` TEXT NULL DEFAULT NULL , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `status` VARCHAR(55) NOT NULL DEFAULT 'pending' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `products` CHANGE `name` `name` TEXT NULL DEFAULT NULL    ");
    
    insert_options('reCAPTCHA_status', 0);
    insert_options('reCAPTCHA_secret_key', '');
    insert_options('reCAPTCHA_site_key', '');
    
    $CMSNT->query(" ALTER TABLE `users` ADD `login_attempts` INT(11) NOT NULL DEFAULT '0' AFTER `banned` ");

    $CMSNT->query(" CREATE TABLE `banned_ips` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `ip` VARCHAR(55) NULL DEFAULT NULL , `attempts` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `banned` INT(11) NOT NULL DEFAULT '0' , `reason` TEXT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");
    
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11698 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11698,
            'name'          => 'Tích hợp thuê OTP qua API 5',
            'description'   => 'Chức năng thuê SIM tích hợp qua API 5',
            'image'         => 'https://i.imgur.com/wQlNAcH.png',
            'createdate'    => '2023-05-09 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11735 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11735,
            'name'          => 'API 14',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-05-10 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron14', 0);
    $CMSNT->query(" ALTER TABLE `categories` CHANGE `name` `name` TEXT NULL DEFAULT NULL    ");
    // for ($i=1; $i < 50; $i++) { 
    //     $CMSNT->query(" ALTER TABLE `categories` DROP INDEX `name_$i` ");
    // }
    insert_options('html_top_product', '');
    insert_options('html_banned', '<p>Vui lòng liên hệ Admin để được hỗ trợ chi tiết</p>');
    insert_options('html_block_ip', '<p>Vui lòng liên hệ Admin để được hỗ trợ chi tiết</p>');
    insert_options('squadco_status', 0);
    insert_options('squadco_Secret_Key', '');
    insert_options('squadco_Public_Key', '');
    insert_options('squadco_rate', 51);
    insert_options('squadco_currency_code', 'NGN');
    insert_options('squadco_notice', '');
    $CMSNT->query(" CREATE TABLE `payment_squadco` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `transaction_ref` VARCHAR(55) NULL DEFAULT NULL , `amount` FLOAT NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `price` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11872 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11872,
            'name'          => 'API 15',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-06-28 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron15', 0);
    insert_options('buy_fanpage_notification', '');

    $CMSNT->query(" CREATE TABLE `discounts` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `product_id` INT(11) NOT NULL DEFAULT '0' , `discount` FLOAT NOT NULL DEFAULT '0' , `amount` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");

    $CMSNT->query(" ALTER TABLE `connect_api` ADD `status_update_ck` INT(11) NOT NULL DEFAULT '1' AFTER `ck_connect_api` ");
    insert_options('is_update_phone', 0);

    
    if($CMSNT->site('prefix_autobank') == ''){
        $CMSNT->update('settings', [
            'value' => 'naptien'
        ], " `name` = 'prefix_autobank' ");
    }
    // ADDON BÁN XU //
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11522 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11522,
            'name'          => 'Bán xu TDS - TTC',
            'description'   => 'Chức năng bán xu TDS và TTC tự động',
            'image'         => 'https://i.imgur.com/1RHdBdT.png',
            'createdate'    => '2023-09-09 00:00:00',
            'price'         => 3000000,
            'purchase_key'  => ''
        ]);
    }
    $CMSNT->update("addons", [
        'price'         => 3000000
    ], " `id` = 11522 ");
    $CMSNT->query(" CREATE TABLE `list_tds_ttc` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `server` VARCHAR(55) NULL DEFAULT NULL COMMENT 'TTC or TDS' , `username` TEXT NULL DEFAULT NULL COMMENT 'Username nếu có' , `password` TEXT NULL DEFAULT NULL COMMENT 'Password nếu có' , `token` TEXT NULL DEFAULT NULL COMMENT 'Token nếu có' , `cookie` TEXT NULL DEFAULT NULL COMMENT 'Cookie nếu có' , `xu` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `day_limit` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `order_tds_ttc` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `server` TEXT NULL DEFAULT NULL , `user_nhan` TEXT NULL DEFAULT NULL , `amount` INT NOT NULL DEFAULT '0' , `remaining` INT(11) NOT NULL DEFAULT '0' , `money` FLOAT NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `update_gettime` DATETIME NOT NULL , `status` INT(11) NOT NULL DEFAULT '0' COMMENT '0 Đang chạy - 1 Hoàn tất - 2 Hủy' , `note` TEXT NULL DEFAULT NULL COMMENT 'Ghi chú từ Admin' , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `order_tds_ttc` ADD `trans_id` VARCHAR(55) NULL DEFAULT NULL AFTER `id` ");
    $CMSNT->query(" CREATE TABLE `log_tds_ttc` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `order_id` INT(11) NOT NULL DEFAULT '0' , `action` TEXT NULL DEFAULT NULL , `create_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`))");
    $CMSNT->query(" ALTER TABLE `list_tds_ttc` ADD `proxy_host` TEXT NULL DEFAULT NULL AFTER `day_limit`, ADD `proxy_user` TEXT NULL DEFAULT NULL AFTER `proxy_host` ");
    $CMSNT->query(" ALTER TABLE `list_tds_ttc` CHANGE `xu` `coin` INT(11) NOT NULL DEFAULT '0'    ");
    insert_options('status_ban_xu_ttc', 0);
    insert_options('status_ban_xu_tds', 0);
    insert_options('min_ban_xu_ttc', 1000000);
    insert_options('max_ban_xu_ttc', 100000000);
    insert_options('rate_ban_xu_ttc', 15);
    insert_options('notice_ban_xu_ttc', '');
    insert_options('min_ban_xu_tds', 1000000);
    insert_options('max_ban_xu_tds', 100000000);
    insert_options('rate_ban_xu_tds', 15);
    insert_options('notice_ban_xu_tds', '');
    insert_options('check_time_cron_mua_xu_cron', 0);
    insert_options('check_time_cron_mua_xu_ttc', 0);
    insert_options('check_time_cron_mua_xu_tds', 0);
    insert_options('check_time_cron_mua_xu_cron_24h', 0);
    insert_options('check_time_cron_mua_xu_cron1', 0);
    // END //

    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11898 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11898,
            'name'          => 'API 16',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-10-01 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron16', 0);

    $CMSNT->query(" DELETE FROM addons WHERE `id` = 3 ");
    $CMSNT->query(" DELETE FROM addons WHERE `id` = 1 ");

    $CMSNT->query(" ALTER TABLE `users` ADD `otp` VARCHAR(55) NULL DEFAULT NULL AFTER `login_attempts`, ADD `otp_limit` INT(11) NOT NULL DEFAULT '0' AFTER `otp` ");
    $CMSNT->query(" ALTER TABLE `users` ADD `otp_token` TEXT NULL DEFAULT NULL AFTER `otp_limit` ");

    $CMSNT->query(" ALTER TABLE `users` ADD `token_2fa` TEXT NULL DEFAULT NULL AFTER `SecretKey_2fa`    ");
    $CMSNT->query(" ALTER TABLE `users` ADD `limit_2fa` INT(11) NOT NULL DEFAULT '0' AFTER `token_2fa`    ");
    
    insert_options('status_otp_login_admin', 0);


    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11901 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11901,
            'name'          => 'API 17',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2023-12-29 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron17', 0);
    insert_options('check_time_shopclone7', 0);
    $CMSNT->query(" ALTER TABLE `dongtien` ADD `transid` VARCHAR(55) NULL AFTER `noidung`, ADD UNIQUE (`transid`) ");

    $CMSNT->query(" ALTER TABLE `products` ADD `allow_api` INT(11) NOT NULL DEFAULT '1' AFTER `filter_time_checklive` ");
    
    if($CMSNT->num_rows(" SELECT * FROM `addons` WHERE `id` = 11925 ") == 0){
        $CMSNT->insert("addons", [
            'id'            => 11925,
            'name'          => 'API 23',
            'description'   => 'Kết nối API sản phẩm website không dùng API của CMSNT',
            'image'         => 'https://i.imgur.com/EFq5tTX.png',
            'createdate'    => '2024-09-13 00:00:00',
            'price'         => 1000000,
            'purchase_key'  => ''
        ]);
    }
    insert_options('check_time_cron23', 0);

    insert_options('status_only_ip_login_admin', 1);

    insert_options('limit_block_ip_admin_access', 5);
    $CMSNT->query(" CREATE TABLE `failed_attempts` ( `id` INT NOT NULL AUTO_INCREMENT , `ip_address` VARCHAR(45) NULL DEFAULT NULL , `attempts` INT(11) NOT NULL DEFAULT '0' , `create_gettime` DATETIME NOT NULL , `type` VARCHAR(55) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");

    
    die('Success!');

