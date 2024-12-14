<?php

    define("IN_SITE", true);
    require_once(__DIR__."/../libs/db.php");
    require_once(__DIR__."/../config.php");
    require_once(__DIR__."/../libs/lang.php");
    require_once(__DIR__."/../libs/helper.php");
    require_once(__DIR__."/../libs/database/users.php");
    $CMSNT = new DB();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
        }
        if (empty($_POST['username']) || empty($_POST['password'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng điền thông tin đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_POST['username'])."' AND `admin` = 1  ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
        }
        if($getUser['banned'] == 1){
            die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị cấm truy cập')]));
        }
        if (empty($_POST['product'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập ID sản phẩm')]));
        }
        $password = check_string($_POST['password']);
        if ($CMSNT->site('type_password') == 'bcrypt') {
            if (!password_verify($password, $getUser['password'])) {
                if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                    $CMSNT->insert('banned_ips', [
                        'ip'                => myip(),
                        'attempts'          => $getUser['login_attempts'],
                        'create_gettime'    => gettime(),
                        'banned'            => 1,
                        'reason'            => __('Đăng nhập thất bại nhiều lần')
                    ]);
                }
                if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                    $User = new users();
                    $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                    die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
                }
                $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
                die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
            }
        } else {
            if ($getUser['password'] != TypePassword($password)) {
                if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                    $CMSNT->insert('banned_ips', [
                        'ip'                => myip(),
                        'attempts'          => $getUser['login_attempts'],
                        'create_gettime'    => gettime(),
                        'banned'            => 1,
                        'reason'            => __('Đăng nhập thất bại nhiều lần')
                    ]);
                }
                if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                    $User = new users();
                    $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                    die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
                }
                $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
                die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
            }
        }
        // kiểm tra ip có trong whitelist
        if($CMSNT->site('status_security') == 1){
            if(!$CMSNT->get_row("SELECT * FROM `ip_white` WHERE `ip` = '".myip()."' ")){
                die(json_encode(['status' => 'error','msg' => __('IP của bạn không được phép truy cập')]));
            }
        }
        if(!$row = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id` = '".check_string($_POST['product'])."' ")){
            die(json_encode(['status' => 'error','msg' => __('ID sản phẩm không tồn tại trong hệ thống')]));
        }
        if(isset($_POST['product']) && isset($_POST['account'])){  
            $isAdd = $CMSNT->insert("accounts", [
                    'product_id'    => check_string($_POST['product']),
                    'seller'        => $getUser['id'],
                    'account'       => $_POST['account'],
                    'status'        => 'LIVE',
                    'create_date'   => gettime(),
                    'create_time'   => time(),
                    'update_date'   => gettime(),
                    'update_time'   => time()
                ]);
                
            if($isAdd){
                /** SEND NOTI TELEGRAM */
                $my_text = $CMSNT->site('noti_import_telegram');
                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                $my_text = str_replace('{name}', $row['name'], $my_text);
                $my_text = str_replace('{amount}', 1, $my_text);
                $my_text = str_replace('{time}', gettime(), $my_text);
                sendMessTelegram($my_text, $CMSNT->site('group_id_import_telegram'));
                die('Thêm tài khoản thành công!');
            }
        }else{
            die(json_encode(['status' => 'error', 'msg' => __('Thiếu product và account')]));
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
        }
        if (empty($_GET['username']) || empty($_GET['password'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng điền thông tin đăng nhập')]));
        }
        if (empty($_GET['product'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập ID sản phẩm')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."' AND `admin` = 1  ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
        }
        if($getUser['banned'] == 1){
            die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị cấm truy cập')]));
        }
        $password = check_string($_GET['password']);
        if ($CMSNT->site('type_password') == 'bcrypt') {
            if (!password_verify($password, $getUser['password'])) {
                if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                    $CMSNT->insert('banned_ips', [
                        'ip'                => myip(),
                        'attempts'          => $getUser['login_attempts'],
                        'create_gettime'    => gettime(),
                        'banned'            => 1,
                        'reason'            => __('Đăng nhập thất bại nhiều lần')
                    ]);
                }
                if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                    $User = new users();
                    $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                    die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
                }
                $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
                die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
            }
        } else {
            if ($getUser['password'] != TypePassword($password)) {
                if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                    $CMSNT->insert('banned_ips', [
                        'ip'                => myip(),
                        'attempts'          => $getUser['login_attempts'],
                        'create_gettime'    => gettime(),
                        'banned'            => 1,
                        'reason'            => __('Đăng nhập thất bại nhiều lần')
                    ]);
                }
                if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                    $User = new users();
                    $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                    die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
                }
                $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
                die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
            }
        }
        if(!$row = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id` = '".check_string($_GET['product'])."'  ")){
            die(json_encode(['status' => 'error','msg' => __('ID sản phẩm không tồn tại trong hệ thống')]));
        }
        if(isset($_GET['product']) && isset($_GET['account'])){  
            $isAdd = $CMSNT->insert("accounts", [
                    'product_id'    => check_string($_GET['product']),
                    'seller'        => $getUser['id'],
                    'account'       => $_GET['account'],
                    'status'        => 'LIVE',
                    'create_date'   => gettime(),
                    'create_time'   => time(),
                    'update_date'   => gettime(),
                    'update_time'   => time()
                ]);
                
            if($isAdd){
                /** SEND NOTI TELEGRAM */
                $my_text = $CMSNT->site('noti_import_telegram');
                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                $my_text = str_replace('{name}', $row['name'], $my_text);
                $my_text = str_replace('{amount}', 1, $my_text);
                $my_text = str_replace('{time}', gettime(), $my_text);
                sendMessTelegram($my_text, $CMSNT->site('group_id_import_telegram'));
                die('Thêm tài khoản thành công!');
            }
        }else{
            die(json_encode(['status' => 'error', 'msg' => __('Thiếu product và account')]));
        }
    }