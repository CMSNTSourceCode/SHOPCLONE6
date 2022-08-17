<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['rating_data'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die(json_encode(['status' => 'error', 'msg' => 'Bạn không được dùng chức năng này vì đây là trang web demo']));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `reviews` WHERE `user_id` = '".$getUser['id']."' AND `order_id` = '".check_string($_POST['order_id'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã đánh giá đơn hàng này rồi')]));
        }
        if (getRowRealtime("orders", check_string($_POST['order_id']), "pay") < $CMSNT->site('min_rating')) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn không đủ điều kiện đánh giá đơn hàng này')]));
        }
        if (empty($_POST['rating_data'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Số sao đánh giá không hợp lệ')]));
        }
        if (check_string($_POST["rating_data"]) < 1 || check_string($_POST["rating_data"]) > 5) {
            die(json_encode(['status' => 'error', 'msg' => __('Số sao đánh giá không hợp lệ')]));
        }
        if(isset($_POST['product_id'])){
            $isInsert = $CMSNT->insert("reviews", [
                'product_id'        =>  check_string($_POST['product_id']),
                'order_id'          =>  check_string($_POST['order_id']),
                'user_id'		    =>	$getUser['id'],
                'rating'		    =>	check_string($_POST["rating_data"]),
                'review'		    =>	check_string($_POST["user_review"]),
                'datetime'			=>	time()
            ]);
        }
        else if(isset($_POST['document_id'])){
            $isInsert = $CMSNT->insert("reviews", [
                'document_id'       =>  check_string($_POST['document_id']),
                'order_id'          =>  check_string($_POST['order_id']),
                'user_id'		    =>	$getUser['id'],
                'rating'		    =>	check_string($_POST["rating_data"]),
                'review'		    =>	check_string($_POST["user_review"]),
                'datetime'			=>	time()
            ]);
        }
        if ($isInsert) {
            die(json_encode(['status' => 'success', 'msg' => __('Gửi đánh giá thành công')]));
        } else {
            die(json_encode(['status' => 'error', 'msg' => __('Gửi đánh giá thất bại')]));
        }
    }

    if (isset($_POST["action"])) {
        $average_rating = 0;
        $total_review = 0;
        $five_star_review = 0;
        $four_star_review = 0;
        $three_star_review = 0;
        $two_star_review = 0;
        $one_star_review = 0;
        $total_user_rating = 0;
        $review_content = array();
        foreach ($CMSNT->get_list("SELECT * FROM `reviews` WHERE `product_id` = '".check_string($_POST['product_id'])."' ORDER BY id DESC ") as $row) {
            $review_content[] = array(
                'user_name'		=>	substr(getRowRealtime("users", $row['user_id'], "username"), 0, 2).'****',
                'review'        =>	$row["review"],
                'rating'		=>	$row["rating"],
                'datetime'		=>	timeAgo($row['datetime'])
            );
            if ($row["rating"] == '5') {
                $five_star_review++;
            }
            if ($row["rating"] == '4') {
                $four_star_review++;
            }
            if ($row["rating"] == '3') {
                $three_star_review++;
            }
            if ($row["rating"] == '2') {
                $two_star_review++;
            }
            if ($row["rating"] == '1') {
                $one_star_review++;
            }
            $total_review++;
            $total_user_rating = $total_user_rating + $row["rating"];
        }
        $average_rating = $total_user_rating / $total_review;
        $output = array(
            'average_rating'	=>	$average_rating,
            'total_review'		=>	$total_review,
            'five_star_review'	=>	$five_star_review,
            'four_star_review'	=>	$four_star_review,
            'three_star_review'	=>	$three_star_review,
            'two_star_review'	=>	$two_star_review,
            'one_star_review'	=>	$one_star_review,
            'review_data'		=>	$review_content
        );
        die(json_encode($output));
    }

    if (isset($_POST['profile_ctv'])) {
        $average_rating = 0;
        $total_review = 0;
        $five_star_review = 0;
        $four_star_review = 0;
        $three_star_review = 0;
        $two_star_review = 0;
        $one_star_review = 0;
        $total_user_rating = 0;
        $review_content = array();
        foreach ($CMSNT->get_list("SELECT * FROM `reviews` WHERE `user_id` = '".check_string($_POST['user_id'])."' ORDER BY id DESC ") as $row) {
            $review_content[] = array(
                'user_name'		=>	substr(getRowRealtime("users", $row['user_id'], "username"), 0, 2).'*****',
                'product_name'  =>  getRowRealtime("products", $row['product_id'], 'name'),
                'review'        =>	$row["review"],
                'rating'		=>	$row["rating"],
                'datetime'		=>	timeAgo($row['datetime'])
            );
            if ($row["rating"] == '5') {
                $five_star_review++;
            }
            if ($row["rating"] == '4') {
                $four_star_review++;
            }
            if ($row["rating"] == '3') {
                $three_star_review++;
            }
            if ($row["rating"] == '2') {
                $two_star_review++;
            }
            if ($row["rating"] == '1') {
                $one_star_review++;
            }
            $total_review++;
            $total_user_rating = $total_user_rating + $row["rating"];
        }
        $average_rating = $total_user_rating / $total_review;
        $output = array(
            'average_rating'	=>	number_format($average_rating, 1),
            'total_review'		=>	$total_review,
            'five_star_review'	=>	$five_star_review,
            'four_star_review'	=>	$four_star_review,
            'three_star_review'	=>	$three_star_review,
            'two_star_review'	=>	$two_star_review,
            'one_star_review'	=>	$one_star_review,
            'review_data'		=>	$review_content
        );
        die(json_encode($output));
    }
}
