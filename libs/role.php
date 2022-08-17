<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

// Hàm thiết lập là đã đăng nhập
function set_logged($username, $level)
{
    session_set('ss_user_token', array(
        'username' => $username,
        'level' => $level
    ));
}

// Hàm thiết lập đăng xuất
function set_logout()
{
    session_delete('ss_user_token');
}

// Hàm kiểm tra trạng thái người dùng đã đăng hập chưa
function is_logged()
{
    $user = session_get('ss_user_token');
    return $user;
}

// Hàm kiểm tra có phải là admin hay không
function is_admin()
{
    $user  = is_logged();
    if (!empty($user['level']) && $user['level'] == '1') {
        return true;
    }
    return false;
}