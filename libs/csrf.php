<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
class Csrf
{
    // Tên kiểm tra token
    private $_csrf_token_name    = 'cms-token-name';

    // Thời gian sống của session, 3600 = 1h
    private $_csrf_time_live = 3600;

    private $_csrf_value = '';


    // Hàm khởi tạo, có hai tham số
    // - $use_token : nếu true thì có sử dụng validate token
    // - $token_post: nếu true thì nếu method = post thì sẽ validate token trong form
    // - $token_get : nếu true thì nếu method = get thì sẽ validate token trên url
    public function __construct($use_token = true, $token_post = false, $token_get = false)
    {
        // Nếu không muốn sử dụng token thì dừng
        if (!$use_token) {
            return;
        }

        // Tạo CSRF Token
        $this->__create_csrf_token();

        // Nếu có validate cho phương thức POST
        if ($token_post && !$this->__validate_post()) {
            die('Token sai');
        }

        // Nếu có validate cho phương thức GET
        if ($token_get && !$this->__validate_get()) {
            die('Token sai');
        }
    }

    // Mỗi người dùng sẽ có một mã token riêng biệt,
    // nên trong hàm này ta sẽ tạo một quy luật riêng để tạo token nhé
    private function __create_csrf_token()
    {
        // Khởi tạo token name
        $this->_csrf_token_name = 'token'.md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].'@#$%^+&*(-)');

        // Nếu token chưa dược khởi tạo thì khởi tạo
        if (!isset($_COOKIE[$this->_csrf_token_name])) {
            // Tạo token
            $token = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);

            // Lưu token trong 1h
            setcookie($this->_csrf_token_name, $token, time() + $this->_csrf_time_live);
        } else {
            $token = $_COOKIE[$this->_csrf_token_name];
            setcookie($this->_csrf_token_name, $token, time() + $this->_csrf_time_live);
        }
        $this->_csrf_value = $token;
    }

    // Kiểm tra phương thức POST
    private function __validate_post()
    {
        // Kiểm tra nếu phương thức hiện tại là POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra có tồn tại token không
            if (!isset($_POST[$this->_csrf_token_name]) || !isset($_COOKIE[$this->_csrf_token_name])) {
                return false;
            }
            // Nếu tokeon không phù hợp
            elseif ($_POST[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_token_name]) {
                return false;
            }
        }
        return true;
    }


    // Kiểm tra phương thức GET
    private function __validate_get()
    {
        // Kiểm tra nếu phương thức hiện tại là POST
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Kiểm tra có tồn tại token không
            if (!isset($_GET[$this->_csrf_token_name]) || !isset($_COOKIE[$this->_csrf_token_name])) {
                return false;
            }
            // Nếu tokeon không phù hợp
            elseif ($_GET[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_token_name]) {
                return false;
            }
        }
        return true;
    }

    // Lấy token name
    public function get_token_name()
    {
        return $this->_csrf_token_name;
    }

    // Lấy token value
    public function get_token_value()
    {
        return $this->_csrf_value;
    }

    // Tạo link có token
    public function create_link($url)
    {
        return $url.'?'.$this->_csrf_token_name.'='.$this->_csrf_value;
    }
}
