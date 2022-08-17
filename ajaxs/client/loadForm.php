<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/apiAutoFB.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    if($_POST['type'] == 'getUIDFB'){
        if(!empty($_POST['profile_user'])){
            // kiểm tra có phải url không
            if (!filter_var($_POST['profile_user'], FILTER_VALIDATE_URL) === false){
                $data = getUID_AutoFB($_POST['profile_user']);
                if($data['status'] == 200){
                    die(json_encode([
                        'status' => 'success',
                        'msg' => __('Lấy UID Facebook thành công!'), 
                        'uid' => $data['id']
                    ]));
                }
                die(json_encode(['status' => 'error', 'msg' => $data['msg']]));
            }
        }
    }

    if($_POST['type'] == 'getUIDFB_post'){
        if(!empty($_POST['profile_user'])){
            // kiểm tra có phải url không
            if (!filter_var($_POST['profile_user'], FILTER_VALIDATE_URL) === false){
                if (strpos($_POST['profile_user'], 'posts') != false) {
                    $data = explode('posts/', $_POST['profile_user'])[1];
                    $data = explode('/', $data)[0];
                }
                else if (strpos($_POST['profile_user'], 'videos') != false) {
                    $data = explode('videos/', $_POST['profile_user'])[1];
                    $data = explode('/', $data)[0];
                }
                if($data){
                    die(json_encode([
                        'status' => 'success',
                        'msg' => __('Lấy ID Bài Viết thành công!'), 
                        'uid' => $data
                    ]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Lấy ID Bài Viết thất bại!')]));
            }
        }
    }

    if($_POST['type'] == 'getUIDFB_story'){
        if(!empty($_POST['profile_user'])){
            // kiểm tra có phải url không
            if (!filter_var($_POST['profile_user'], FILTER_VALIDATE_URL) === false){
                $data = explode('stories/', $_POST['profile_user'])[1];
                $data = explode('/?', $data)[0];
                if($data){
                    die(json_encode([
                        'status' => 'success',
                        'msg' => __('Lấy ID Story thành công!'), 
                        'uid' => $data
                    ]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Lấy ID Story thất bại!')]));
            }
        }
    }


}
 
