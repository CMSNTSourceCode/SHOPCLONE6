<?php
class Momo
{
    public $config = array();
    private $send = array();
    public $momo_data_config = array(
        "appVer" => 31160,
        "appCode" => "3.1.16",
        "device" => "maihuybao",
        "hardware" => "iPhone",
        "facture" => "Apple",
        "MODELID" => "Samsung SM-A102U",
        "device_os" => "IOS"

    );
    private $URLAction = array(
        "CHECK_USER_BE_MSG" => "https://api.momo.vn/backend/auth-app/public/CHECK_USER_BE_MSG", //Check người dùng
        "SEND_OTP_MSG"      => "https://api.momo.vn/backend/otp-app/public/SEND_OTP_MSG", //Gửi OTP
        "REG_DEVICE_MSG"    => "https://api.momo.vn/backend/otp-app/public/REG_DEVICE_MSG", // Xác minh OTP
        "QUERY_TRAN_HIS_MSG" => "https://owa.momo.vn/api/QUERY_TRAN_HIS_MSG", // Check ls giao dịch
        "USER_LOGIN_MSG"     => "https://owa.momo.vn/public/login", // Đăng Nhập
        "GENERATE_TOKEN_AUTH_MSG"     => "https://api.momo.vn/backend/auth-app/public/GENERATE_TOKEN_AUTH_MSG", // Get Token
        "QUERY_TRAN_HIS_MSG_NEW" => "https://m.mservice.io/hydra/v2/user/noti", // check ls giao dịch 
        "M2MU_INIT"         => "https://owa.momo.vn/api/M2MU_INIT", // Chuyển tiền
        "M2MU_CONFIRM"      => "https://owa.momo.vn/api/M2MU_CONFIRM", // Chuyển tiền
        "LOAN_MSG"          => "https://owa.momo.vn/api/LOAN_MSG", // yêu cầu chuyển tiền
        'M2M_VALIDATE_MSG'  => 'https://owa.momo.vn/api/M2M_VALIDATE_MSG', // Ko rõ chức năng 
        'CHECK_USER_PRIVATE' => 'https://owa.momo.vn/api/CHECK_USER_PRIVATE', // Check người dùng ẩn
        'TRAN_HIS_INIT_MSG' => 'https://owa.momo.vn/api/TRAN_HIS_INIT_MSG', // Rút tiền, chuyển tiền
        'TRAN_HIS_CONFIRM_MSG' => 'https://owa.momo.vn/api/TRAN_HIS_CONFIRM_MSG', // rút tiền chuyển tiền
        'GET_CORE_PREPAID_CARD' => 'https://owa.momo.vn/api/sync/GET_CORE_PREPAID_CARD',
        'ins_qoala_phone'   => 'https://owa.momo.vn/proxy/ins_qoala_phone',
        'GET_DETAIL_LOAN'   => 'https://owa.momo.vn/api/GET_DETAIL_LOAN', // Get danh sách yêu cầu chuyển
        'LOAN_UPDATE_STATUS' => 'https://owa.momo.vn/api/LOAN_UPDATE_STATUS', // Từ chỗi chuyển tiền
        'CANCEL_LOAN_REQUEST' => 'https://owa.momo.vn/api/CANCEL_LOAN_REQUEST', // Huỷe chuyển tiền
        'LOAN_SUGGEST'      => 'https://owa.momo.vn/api/LOAN_SUGGEST',
        'STANDARD_LOAN_REQUEST'  => 'https://owa.momo.vn/api/STANDARD_LOAN_REQUEST',
        'SAY_THANKS'        => 'https://owa.momo.vn/api/SAY_THANKS', // Gửi lời nhắn khi nhận tiền
        'HEARTED_TRANSACTIONS' => 'https://owa.momo.vn/api/HEARTED_TRANSACTIONS',
        'VERIFY_MAP'        => 'https://owa.momo.vn/api/VERIFY_MAP', // Liên kết ngân hàng
        'service'           => "https://owa.momo.vn/service",   // Check ngân hàng qua stk
        'NEXT_PAGE_MSG'     => 'https://owa.momo.vn/api/NEXT_PAGE_MSG', // mua thẻ điện thoại
        'dev_backend_gift-recommend' => 'https://owa.momo.vn/proxy/dev_backend_gift-recommend', // check gift
        'ekyc_init'         => 'https://owa.momo.vn/proxy/ekyc_init',  // Xác minh cmnd
        'ekyc_ocr'          => 'https://owa.momo.vn/proxy/ekyc_ocr', // xác minh cmnd
        'GetDataStoreMsg'   => 'https://owa.momo.vn/api/GetDataStoreMsg', // Get danh sách ngân hàng đã chuyển
        'VOUCHER_GET'       => 'https://owa.momo.vn/api/sync/VOUVHER_GET', // get voucher 
        'END_USER_QUICK_REGISTER' => 'https://api.momo.vn/backend/auth-app/public/END_USER_QUICK_REGISTER', // đăng kí
        'AGENT_MODIFY'      => 'https://api.momo.vn/backend/auth-app/api/AGENT_MODIFY', // Cập nhật tên email
        'ekyc_ocr_result'   => 'https://owa.momo.vn/proxy/ekyc_ocr_result', // xác minh cmnd
        'CHECK_INFO'        => 'https://owa.momo.vn/api/CHECK_INFO', // Check hóa đơn
        'BANK_OTP'          => 'https://owa.momo.vn/api/BANK_OTP', // Rút tiền
        'SERVICE_UNAVAILABLE' => 'https://owa.momo.vn/api/SERVICE_UNAVAILABLE', // Bên bảo mật
        'ekyc_ocr_confirm'  => 'https://owa.momo.vn/proxy/ekyc_ocr_confirm', //Xác minh cmnd
        'sync'              => 'https://owa.momo.vn/api/sync', // Lấy biến động số dư
        'MANAGE_CREDIT_CARD' => 'https://owa.momo.vn/api/MANAGE_CREDIT_CARD', //Thêm visa marter card
        'UN_MAP'            => 'https://owa.momo.vn/api/UN_MAP', // Hủy liên kết thẻ
        'WALLET_MAPPING'    => 'https://owa.momo.vn/api/WALLET_MAPPING', // Liên kết thẻ
        'NAPAS_CASHIN_INIT_MSG' => 'https://owa.momo.vn/api/NAPAS_CASHIN_INIT_MSG',
        "CARD_GET" => "https://owa.momo.vn/api/sync/CARD_GET",
        'NAPAS_CASHIN_DELETE_TOKEN_MSG' => 'https://owa.momo.vn/api/NAPAS_CASHIN_DELETE_TOKEN_MSG',
        'API_DEFAULT_SOURCE' => 'https://owa.momo.vn/api/API_DEFAULT_SOURCE',
        'GET_TRANS_BY_TID'          => 'https://owa.momo.vn/api/GET_TRANS_BY_TID',
        'TRAN_HIS_LIST'             => 'https://api.momo.vn/sync/transhis/browse',
        'CREATE_MONEY_REQUEST_LINK' => 'https://api.momo.vn/p2p/money-request-link/',
        'CHANGE_PIN'                => 'https://api.momo.vn/backend/auth-app/api/CHANGE_PIN',
    );
    function namemomo($sdt)
    {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://nhantien.momo.vn/'.$sdt);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        
        $headers = array();
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Sec-Ch-Ua: \" Not;A Brand\";v=\"99\", \"Google Chrome\";v=\"91\", \"Chromium\";v=\"91\"';
        $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Sec-Fetch-Site: none';
        $headers[] = 'Sec-Fetch-Mode: navigate';
        $headers[] = 'Sec-Fetch-User: ?1';
        $headers[] = 'Sec-Fetch-Dest: document';
        $headers[] = 'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7,fr-FR;q=0.6,fr;q=0.5';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $name = explode("</div>", explode('<div class="d-flex justify-content-center" style="padding-top: 15px;padding-bottom: 15px">', $result)[1])[0]; //Lấy tên chủ khoản momo
        if($name != '' && $name != '<img src="https://img.mservice.io/momo_app_v2/new_version/img/appx_image/ic_empty_document.png">'){
            return  json_encode([
                "error"   => 1,
                "msg"    => $name,
            ]);
        }else{
            return  json_encode([
                "error"   => 0,
                "msg"    => "Số điện thoại chưa đăng ký momo",
            ]);
        }
    }
    public function SendMoney($receiver,$amount = 100,$comment = "")
    {
        $result = $this->CHECK_USER_PRIVATE($receiver);
        if(!empty($result["errorCode"]) ){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message" => $result["errorDesc"],
                "full" => json_encode($result)
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $results = $this->M2M_VALIDATE_MSG($receiver, $comment);
        if(!empty($result["errorCode"]) && $result["errorDesc"] != "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau"){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"],
                "full" => json_encode($result)
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
        }
        $message = $results['momoMsg']['message'];
        $this->send = array(
            "amount" => (int)$amount,
            "comment"=> $message,
            "receiver"=> $receiver,
            "partnerName"=> $result["extra"]["NAME"]
        );
        $result = $this->M2MU_INIT();
        if(!empty($result["errorCode"]) && $result["errorDesc"] != "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau"){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }else if(is_null($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
        }else{
            $ID = $result["momoMsg"]["replyMsgs"]["0"]["ID"];
            $result = $this->M2MU_CONFIRM($ID);
            $balance = $result["extra"]["BALANCE"];
            $tranHisMsg = $result["momoMsg"]["replyMsgs"]["0"]["tranHisMsg"];
            // if($result["errorDesc"] == "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau") {
            //     $tranHisMsg["desc"] = $tranHisMsg["desc"] ?: "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau";
            // }
            if($tranHisMsg["status"] != 999 && $result["errorDesc"] != "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau"){
                return array(
                    "status"   => "1",
                    "message"  => $tranHisMsg["desc"],
                    "tranDList"=> array(
                        "balance" => $balance,
                        "ID"   => $tranHisMsg["ID"],
                        "tranId"=> $tranHisMsg["tranId"],
                        "partnerId"=> $tranHisMsg["partnerId"],
                        "partnerName"=> $tranHisMsg["partnerName"],
                        "amount"   => $tranHisMsg["amount"],
                        "comment"  => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
                        "status"   => $tranHisMsg["status"],
                        "desc"     => $tranHisMsg["desc"],
                        "ownerNumber" => $tranHisMsg["ownerNumber"],
                        "ownerName"=> $tranHisMsg["ownerName"],
                        "millisecond" => $tranHisMsg["finishTime"]
                    ),
                    "full" => json_encode($result)
                );
            }else{
                // $this->connect->query("UPDATE `cron_momo` SET `BALANCE` = '".$balance."',`today` = `today` + '".$amount."',`month` = `month` + '".$amount."',`today_gd` = `today_gd` + 1 WHERE `phone` = '".$this->config["phone"]."' ");
                return array(
                    "status" => "2",
                    "message"=> $tranHisMsg["desc"],
                    "tranDList" => array(
                        "balance" => $balance,
                        "ID"    => $tranHisMsg["ID"],
                        "tranId"=> $tranHisMsg["tranId"],
                        "partnerId"=> $tranHisMsg["partnerId"],
                        "partnerName"=> $tranHisMsg["partnerName"],
                        "amount"     => $tranHisMsg["amount"],
                        "comment"    => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
                        "status"     => $tranHisMsg["status"],
                        "desc"       => $tranHisMsg["desc"],
                        "ownerNumber"=> $tranHisMsg["ownerNumber"],
                        "ownerName"  => $tranHisMsg["ownerName"],
                        "millisecond"=> $tranHisMsg["finishTime"]
                    ),
                    "full" => json_encode($result)
                );
            }

        }
    }
    public function CheckHis($day)
    {
        $limit = 100;
        $from = date("d/m/Y",strtotime("-$day days ago"));
        $result = $this->TRAN_HIS_LIST($from,date("d/m/Y",time()),$limit);
        if(empty($result)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> 'Hết thời gian đăng nhập vui lòng đăng nhập lại'
            );
        }
        if(!empty($result["errorCode"])){
            return array(
                "status" => "error",
                "code"   => $result["errorCode"],
                "message"=> $result["errorDesc"]
            );
        }
        $HisList = $result["momoMsg"];
        $tranList = array();
        foreach ($HisList as $transaction){
            if($transaction['io'] == -1) {continue;}//chỉ lấy gd nhận,1
            $result = $this->GET_TRANS_BY_TID($transaction['transId']);
            if(empty($result)){
                return array(
                    "status" => "error",
                    "code"   => -5,
                    "message"=> 'Hết thời gian đăng nhập vui lòng đăng nhập lại'
                );
            }
            if(!empty($result["errorCode"])){
                return array(
                    "status" => "error",
                    "code"   => $result["errorCode"],
                    "message"=> $result["errorDesc"]
                );
            }
            if(empty($result["momoMsg"]['partnerId']) or empty($result["momoMsg"]['io'])) continue;
                $tranList[] = array(
                    'ID'    => $result["momoMsg"]['ID'],
                    "tranId"=> $result["momoMsg"]["tranId"],
                    "io"    => $result["momoMsg"]["io"],
                    "patnerID" => $result["momoMsg"]["partnerId"],
                    "status"=> $result["momoMsg"]["status"],
                    "partnerName" => empty($result["momoMsg"]["partnerName"]) ? "" : $result["momoMsg"]['partnerName'] ,
                    "amount" => empty($result["momoMsg"]["amount"]) ? 0 : $result["momoMsg"]["amount"],
                    "comment" => (!empty($result["momoMsg"]["comment"])) ? $result["momoMsg"]["comment"] : "",
                    "desc"  => empty($result["momoMsg"]["desc"]) ? "" : $result["momoMsg"]["desc"],
                    "millisecond" => empty($result["momoMsg"]["finishTime"]) ? 0 : $result["momoMsg"]['finishTime'] 
                );
        }
        
        
        return array(
            "status"  => "success",
            "message" => "Thành công",
            "TranList"=> $tranList
        );
    }
    public function CheckHisNew($hours = 5)
    {
        $begin =  (time() - (360000 * $hours)) * 1000;
        //$begin = strtotime("-1 minutes") * 1000;
        $header = array(
            "authorization: Bearer " . $this->config["authorization"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "agent_id: " . $this->config["agent_id"],
            'app_version: ' . $this->momo_data_config["appVer"],
            'app_code: ' . $this->momo_data_config["appCode"],
            "Host: m.mservice.io"
        );


        $Data = '{
            "userId": "' . $this->config['phone'] . '",
            "fromTime": ' . $begin . ',
            "toTime": ' . $this->get_microtime() . ',
            "limit": 5000,
            "cursor": "",
            "cusPhoneNumber": ""
        }';
        $result =  $this->CURL("QUERY_TRAN_HIS_MSG_NEW", $header, $Data);
        if (!is_array($result)) {
            return array(
                "status" => "error",
                "code" => -5,
                "message" => "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $tranHisMsg =  $result["message"]["data"]["notifications"];
        $return = array();
        foreach ($tranHisMsg as $value) {
            //if($value["type"] != 77) continue;
            //$extra = json_decode($value["extra"],true);
            $amount = $value['caption'];
            $name = explode("từ", $amount)[1] ?: "";
            if (strpos($amount, "Nhận") !== false && $name) {
                preg_match('#Nhận (.+?)đ#is', $amount, $amount);
                $amount = str_replace(".", "", $amount[1]) > 0 ? str_replace(".", "", $amount[1]) : '0';
                //Cover body to comment
                $comment = $value['body'];
                $comment = ltrim($comment, '"');
                $comment = explode('"', $comment);
                $comment = $comment[0];
                if ($comment == "Nhấn để xem chi tiết.") {
                    $comment = "";
                }
                $return[] = array(
                    "tranId"  => $value["tranId"],
                    "id"  => $value["ID"],
                    "partnerId" => $value["sender"],
                    "partnerName" => trim($name),
                    "comment" => $comment,
                    "amount" => (int)$amount,
                    "millisecond" => $value["time"]
                );
            }
        }
        return json_encode(array(
            "status" => true,
              'message' => 'Thành công',
              "momoMsg" => array("tranList" => $return)
      ), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function Mess()
    {
        $header = array(
            "Host: helios.mservice.io",
            "user-agent: xxx grpc-java-okhttp/1.32.2",
            "content-type: application/grpc",
            "te: trailers",
            "authorization: Bearer " . $this->config['authorization'],
            "grpc-accept-encoding: gzip"
        );

        if (!empty($this->send['message'])) {
            $message = json_encode(array(
                'roomId' => $this->send['roomId'],
                'requestId' => $this->generateImei(),
                'createAt' => $this->get_microtime(),
                'parts' =>
                array(
                    'partType' => 'INLINE',
                    'payload' =>
                    array(
                        'content' => $this->send['message'],
                        'customData' =>
                        array(
                            'name' => $this->send['name'],
                            'userName' => $this->send['name'],
                            '_id' => $this->config['phone'],
                            'avatar' => 'https://s3-ap-southeast-1.amazonaws.com/avatars.mservice.io/' . $this->config['phone'] . '.png',
                        ),
                    ),
                ),
                'userId' => $this->config['phone'],
                'userName' => '',
            ));
        } else {
            $message = json_encode(array(
                'roomId' => $this->send['roomId'],
                'parts' =>
                array(
                    'partType' => 'ATTACHMENT',
                    'payload' =>
                    array(
                        'customData' =>
                        array(
                            'userName' => $this->config['Name'],
                        ),
                        'content' => '',
                        'type' => 'IMAGE',
                        'url' => $this->send['image'],
                    ),
                ),
                'requestId' => $this->generateImei(),
                'userId' => $this->config['phone'],
                'userName' => '',
            ));
        }
        $curl = curl_init();
        $opt = array(
            CURLOPT_URL => "https://helios.mservice.io/helioschat.ChatService/connect",
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $this->HexDataMess($message),
            CURLOPT_HEADER => 1,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_CONNECTTIMEOUT_MS => 300,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
            CURLOPT_TIMEOUT => 1,
        );
        curl_setopt_array($curl, $opt);
        echo curl_exec($curl);
    }
    public function CheckMessage()
    {
        $header = array(
            'Host: m.mservice.io',
            'accept: application/json',
            'app_version: ' . $this->momo_data_config["appVer"],
            'app_code: 3.0.23',
            'device_os: ANDROID',
            'agent_id: ' . $this->config['agent_id'],
            'sessionkey: ' . $this->config['sessionkey'],
            'user_phone: ' . $this->config['phone'],
            'lang: vi',
            'authorization: Bearer ' . $this->config['authorization'],
            'content-type: application/json',
            'accept-encoding: gzip',
            'user-agent: okhttp/3.14.7'
        );
        $Data = array(
            'roomId' => $this->send['roomId'],
            'beforeId' => '',
            'limit' => 10,
            'action' => 1,
        );
        return $this->CURL_V2('https://m.mservice.io/helios/chat-api/v1/room/fetch-messages', $header, json_encode($Data));
    }
    public function GetGroupId()
    {

        $header = array(
            'Host: m.mservice.io',
            'accept: application/json',
            'app_version: ' . $this->momo_data_config["appVer"],
            'app_code: ' . $this->momo_data_config["appCode"],
            'device_os: ANDROID',
            'agent_id: ' . $this->config['agent_id'],
            'sessionkey: ' . $this->config['sessionkey'],
            'user_phone: ' . $this->config['phone'],
            'lang: vi',
            'authorization: Bearer ' . $this->config['authorization'],
            'content-type: application/json',
            'accept-encoding: gzip',
            'user-agent: okhttp/3.14.7'
        );
        $Data = array(
            'userId' => $this->config['phone'],
            'name' => '',
            'addUserIds' =>
            array(
                0 => $this->send['phone'],
            ),
            'customData' =>
            array(
                'users' =>
                array(
                    0 =>
                    array(
                        'phone' => $this->config['phone'],
                        'name' => $this->config['Name'],
                        'avatar' => 'https://s3-ap-southeast-1.amazonaws.com/avatars.mservice.io/' . $this->config['phone'] . '.png',
                    ),
                    1 =>
                    array(
                        'phone' => $this->send['phone'],
                        'name' => $this->send['name'],
                        'avatar' => 'https://s3-ap-southeast-1.amazonaws.com/avatars.mservice.io/' . $this->send['phone'] . '.png',
                        'isStranger' => false,
                    ),
                ),
            ),
        );

        return $this->CURL_V2('https://m.mservice.io/helios/chat-api/v1/room/', $header, json_encode($Data));
    }

    public function CURL_V2($Action, $header, $data)
    {
        $curl = curl_init();
        $opt = array(
            CURLOPT_URL => $Action,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 20,
        );
        curl_setopt_array($curl, $opt);
        $result = curl_exec($curl);
        if (is_object(json_decode($result))) {
            return json_decode($result, true);
        }
        return $result;
    }



    public function CheckBank()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            'Connection: Keep-Alive',
            "Host: owa.momo.vn"
        );
        $Data = array(
            'requestId' => $microtime,
            'agent' => $this->config['phone'],
            'channel' => 'APP',
            'coreBankCode' => '2001',
            'serviceId' => '2001',
            'benfAccount' =>
            array(
                'accId' => $this->send['accId'],
                'napasBank' =>
                array(
                    'bankCode' => $this->send['bankCode'],
                    'bankName' => $this->send['bankName'],
                ),
            ),
            'msgType' => 'CheckAccountRequestMsg',
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.transfer',
        );
        return $this->CURL("service", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function link_service_tokenization()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'requestId' => (string) $microtime,
            'type' => 'getList',
            'walletId' => $this->config['phone'],
            'sessionKey' => $this->config['sessionkey'],
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => 30323,
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 74,
            'appId' => 'vn.momo.authenlinkingservices',
        );
        return $this->CURL_proxy("https://owa.momo.vn/proxy/link_service_tokenization", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function dev_backend_gift_recommend()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            'Connection: Keep-Alive',
            "Host: owa.momo.vn"
        );
        $Data = array(
            "agent" => $this->config['phone'],
            'serviceId' => 'transfer_p2p',
            'momoMsg' =>
            array(
                'serviceId' => 'transfer_p2p',
                'originalAmount' => '100000',
                'page' => 1,
                'limit' => 20,
                '_class' => 'mservice.backend.entity.msg.GiftRecommendMsg',
                'user' => (string) $this->config['phone'],
            ),
            'requestId' => (string) $this->config['phone'] . $microtime,
            'msgType' => 'GIFT_RECOMMEND',
            'user' => (string) $this->config['phone'],
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => 30323,
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
        );
        return $this->CURL_proxy("https://owa.momo.vn/proxy/dev_backend_gift_recommend", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function ekyc_ocr()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'kycReference' => $this->send['kycReference'],
            'agent' => $this->config['phone'],
            'imageSide' => $this->send['imageSide'],
            'image' => $this->send['image'], //base64
            'action' => 'OCR',
            'serviceId' => 'ekyc_service',
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
        );
        return $this->CURL("ekyc_ocr", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function NAPAS_CASHIN_DELETE_TOKEN_MSG($requestTokenHash)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: NAPAS_CASHIN_DELETE_TOKEN_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'NAPAS_CASHIN_DELETE_TOKEN_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'partnerCode' => 'napas_cashin_tokenization',
                'requestTokenHash' => $requestTokenHash,
                'moneySource' => 5,
                '_class' => 'mservice.backend.entity.msg.NapasCashinDeleteTokenMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('NAPAS_CASHIN_DELETE_TOKEN_MSG', $microtime),
            ),
        );
        return $this->CURL('NAPAS_CASHIN_DELETE_TOKEN_MSG', $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function ekyc_init()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'agent' => $this->config['phone'],
            'purpose' => 'EKYC_IDENTIFY',
            'action' => 'OCR_INIT',
            'serviceId' => 'ekyc_service',
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
        );
        return $this->CURL("ekyc_init", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function ekyc_ocr_result()
    {
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data =  array(
            'kycReference' => $this->send['kycReference'],
            'frontReference' => $this->send['frontReference'],
            'idCardTypeInApp' => $this->send['idCardTypeInApp'],
            'backReference' => $this->send['backReference'],
            'agent' => $this->config['phone'],
            'action' => 'GET_OCR_RESULT',
            'serviceId' => 'ekyc_service',
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
        );
        return $this->CURL("ekyc_ocr_result", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function ekyc_ocr_confirm($result)
    {
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data =  array(
            'kycReference' => $this->send['kycReference'],
            'agent' => $this->config['phone'],
            'data' => $result,
            'serviceId' => 'ekyc_service',
            'action' => 'OCR_CONFIRM',
            'resultReference' => $this->send['resultReference'],
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
        );
        return $this->CURL("ekyc_ocr_confirm", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function VOUCHER_GET()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: VOUCHER_GET",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'VOUCHER_GET',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.SyncMsg',
                'limit'  => 100,
                'page'   => 1,
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('VOUCHER_GET', $microtime),
            ),
        );
        return $this->CURL("VOUCHER_GET", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function BANK_OTP($TranHisInit)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: BANK_OTP",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'BANK_OTP',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' => $TranHisInit,
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('BANK_OTP', $microtime),
            ),
        );
        return $this->CURL("BANK_OTP", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function CHECK_INFO()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: CHECK_INFO",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data =  array(
            'user' => $this->config['phone'],
            'msgType' => 'CHECK_INFO',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1537,
            'appId' => 'vn.momo.billpay',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'clientTime' => $microtime - 500,
                'tranType' => 7,
                'pageNumber' => 1,
                'parentTranType' => 3,
                'quantity' => 1,
                'billId' => $this->send['billId'],
                'serviceId' => $this->send['serviceId'],
                'serviceName' => $this->send['serviceName'],
                'category' => 21,
                'extras' => '{}',
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
            ),
            'extra' =>
            array(
                'currentFormDataModel' => '{"formData":"{}"}',
                'checkSum' => $this->generateCheckSum('CHECK_INFO', $microtime),
            ),
        );
        return $this->CURL("CHECK_INFO", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function NEXT_PAGE_MSG()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: NEXT_PAGE_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'NEXT_PAGE_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'user' => $this->config['phone'],
                'quantity' => 1,
                'pageNumber' => 1,
                'extras' => '{"vpc_CardType":"SML","vpc_TicketNo":"116.104.162.112","vpc_PaymentGateway":""}',
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                'serviceId' => $this->send['serviceId'],
                'ownerName' => $this->send['ownerName'],
                'originalAmount' => $this->send['amount'],
                'amount' => $this->send['amount'],
                'partnerId' => $this->config['phone'],
                'partnerExtra1' => $this->config['Name'],
                'discount' => 0,
                'serviceName' => 'Mua mã thẻ',
                'clientTime' => $microtime - 222,
                'category' => 11,
                'tranType' => 7,
                'moneySource' => 1,
                'partnerCode' => 'momo',
                'rowCardId' => '',
                'giftId' => '',
                'useVoucher' => 0,
                'prepaidIds' => '',
                'usePrepaid' => 0,
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('NEXT_PAGE_MSG', $microtime),
            ),
        );
        return $this->CURL("NEXT_PAGE_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function SERVICE_UNAVAILABLE()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: SERVICE_UNAVAILABLE",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'SERVICE_UNAVAILABLE',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1087,
            'appId' => 'vn.momo.mobilecenter',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'code' => 'topup_Viettel',
                'name' => 'Viettel',
                '_class' => 'mservice.backend.entity.msg.ServiceModel',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('SERVICE_UNAVAILABLE', $microtime),
            ),
        );
        return $this->CURL("SERVICE_UNAVAILABLE", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function VERIFY_MAP()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: VERIFY_MAP",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'VERIFY_MAP',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'rowCardNum' => $this->send['rowCardNum'],
                'extras' => $this->send['extras'],
                'customerNumber' => $this->send['customerNumber'],
                'partnerId' => $this->send['partnerId'],
                'partnerCode' => $this->BankId[$this->send['BankName']]['partnerCode'],
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('VERIFY_MAP', $microtime),
            ),
        );
        return $this->CURL("VERIFY_MAP", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function GET_DETAIL_LOAN()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: GET_DETAIL_LOAN",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'GET_DETAIL_LOAN',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.transfer',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'appSendChat' => false,
                'loanGroupId' => '1629731094629',
                'loanHisId' => '54d761ac-3795-4dfc-af2b-51585455315a',
                '_class' => 'mservice.backend.entity.msg.LoanDetailMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('GET_DETAIL_LOAN', $microtime),
            ),
        );
        return $this->CURL("GET_DETAIL_LOAN", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function GET_CORE_PREPAID_CARD()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateImei();
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        echo $requestkey;
        die;
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: GET_DETAIL_LOAN",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'GET_CORE_PREPAID_CARD',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                "partnerCode" => "napas_cashin_tokenization",
                "moneySource" => 5,
                '_class' => 'mservice.backend.entity.msg.SyncMsg'
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('GET_CORE_PREPAID_CARD', $microtime),
            ),
        );
        return $this->CURL("GET_CORE_PREPAID_CARD", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function CARD_GET()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: CARD_GET",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'CARD_GET',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.SyncMsg'
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('CARD_GET', $microtime),
            ),
        );
        return $this->CURL("CARD_GET", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }


    public function HEARTED_TRANSACTIONS()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: HEARTED_TRANSACTIONS",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'HEARTED_TRANSACTIONS',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config("appVer"),
            'appCode' => $this->momo_data_config("appCode"),
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.transfer',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.ForwardMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('HEARTED_TRANSACTIONS', $microtime),
            ),
        );
        return $this->CURL("HEARTED_TRANSACTIONS", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function LOAN_UPDATE_STATUS()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: LOAN_UPDATE_STATUS",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'LOAN_UPDATE_STATUS',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1874,
            'appId' => 'vn.momo.chat',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'appSendChat' => false,
                'replyTo' => '0977371507',
                'senderName' => 'NGUYỄN VĂN ĐẠT',
                'loanId' => '56058822',
                'accept' => false,
                '_class' => 'mservice.backend.entity.msg.LoanResponseMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('LOAN_UPDATE_STATUS', $microtime),
            ),
        );
        return $this->CURL("LOAN_UPDATE_STATUS", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function CANCEL_LOAN_REQUEST($info)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: CANCEL_LOAN_REQUEST",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'CANCEL_LOAN_REQUEST',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'appId' => 'vn.momo.transfer',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'senderName' => $this->config['Name'],
                'senderId' => $this->config['phone'],
                'partnerId' => $info['partnerId'],
                'partnerName' => $info['partnerName'],
                'loanGroup' => $info['loanGroup'],
                'loanGroupId' => $info['loanGroupId'],
                '_class' => 'mservice.backend.entity.msg.LoanCancelMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('CANCEL_LOAN_REQUEST', $microtime),
            ),
        );
        return $this->CURL("CANCEL_LOAN_REQUEST", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function LOAN_MSG()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            "user" => $this->config["phone"],
            "msgType" => "LOAN_MSG",
            "cmdId" => (string) $microtime . "000000",
            "lang"  => "vi",
            "time"  => $microtime,
            "channel" => "APP",
            "appVer"  => $this->momo_data_config["appVer"],
            "appCode" => $this->momo_data_config["appCode"],
            "deviceOS" => "ANDROID",
            "buildNumber" => 1874,
            "appId"   => "vn.momo.platform",
            "result"  => true,
            "errorCode" => 0,
            "errorDesc" => "",
            "momoMsg" => array(
                "_class" => "mservice.backend.entity.msg.M2MUInitMsg",
                "tranList" => [
                    array(
                        "_class" => "mservice.backend.entity.msg.TranHisMsg",
                        "user" => $this->config["phone"],
                        "clientTime" => ($microtime - 251),
                        "tranType"   => 36,
                        "amount" => $this->send["amount"],
                        "receiverType" => 1
                    ),
                    array(
                        "_class" => "mservice.backend.entity.msg.TranHisMsg",
                        "user"   => $this->config["phone"],
                        "clientTime" => ($microtime - 251),
                        "tranType"   => 36,
                        "partnerId"  => $this->send["receiver"],
                        "amount"     => $this->send["amount"],
                        "comment"    => $this->send["comment"],
                        "ownerName"  => "",
                        "receiverType" => 0,
                        "partnerExtra1" => '{\"totalAmount\":' . $this->send["amount"] . '}',
                        "partnerInvNo"  => "borrow"
                    )
                ]
            ),
            "extra" => array(
                "checkSum" => $this->generateCheckSum("LOAN_MSG", $microtime)
            )
        );
        return $this->CURL("LOAN_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function STANDARD_LOAN_REQUEST()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: STANDARD_LOAN_REQUEST",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'STANDARD_LOAN_REQUEST',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.transfer',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.LoanDetailMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('STANDARD_LOAN_REQUEST', $microtime),
            ),
        );
        return $this->CURL("STANDARD_LOAN_REQUEST", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function LOAN_SUGGEST()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: LOAN_SUGGEST",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'LOAN_SUGGEST',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1987,
            'appId' => 'vn.momo.transfer',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.LoanDetailMsg',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('LOAN_SUGGEST', $microtime),
            ),
        );
        return $this->CURL("LOAN_SUGGEST", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function MANAGE_CREDIT_CARD()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: MANAGE_CREDIT_CARD",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        // dailysieure.com
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'MANAGE_CREDIT_CARD',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1062,
            'appId' => 'vn.momo.bank',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'action' => 2,
                '_class' => 'mservice.backend.entity.msg.ManageCreditCardMsg',
                'clientIp' => '172.16.14.223',
                'cardList' =>
                array(
                    0 =>
                    array(
                        '_class' => 'mservice.backend.entity.msg.CardInfoMsg',
                        'cardType' => '001',
                        'cardNumber' => '',
                        'cardExpired' => '10/2026',
                        'cardHolder' => 'VU TUNG DUY',
                        'email' => $this->config["email"] . "@gmail.com",
                        'address' => 'HẢI DƯƠNG',
                        'cvn' => '144',
                        'personal_id_verify' => '040203013718',
                    ),
                ),
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('MANAGE_CREDIT_CARD', $microtime),
            ),
        );
        return $this->CURL("MANAGE_CREDIT_CARD", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function ins_qoala_phone()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "authorization: Bearer " . $this->config["authorization"],
            "Host: owa.momo.vn",
            'User-Agent: okhttp/3.14.7',
            'Connection: Keep-Alive',
        );
        $Data =  array(
            'requestId' => (string) $this->config['phone'] . $microtime,
            'type' => 50,
            'source' => 2,
            'serviceCode' => 'MobileTopup',
            'debitorEmail' => 'nguyenthihaudk41@gmail.com',
            'debitorName' => $this->config['Name'],
            'debitor' => $this->config['phone'],
            'reference1' => '',
            'reference2' => '',
            'phoneDetail' =>  array(
                'brand' => $this->config['facture'],
                'model' => $this->config['device'],
            ),
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 1087,
            'appId' => 'vn.momo.mobilecenter',
        );
        return $this->CURL('ins_qoala_phone', $header, $Data);
    }

    public function M2M_VALIDATE_MSG($phone, $message = '')
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: M2M_VALIDATE_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = '{
            "user":"' . $this->config['phone'] . '",
            "msgType":"M2M_VALIDATE_MSG",
            "cmdId":"' . $microtime . '000000",
            "lang":"vi",
            "time":' . (int) $microtime . ',
            "channel":"APP",
            "appVer": ' . $this->momo_data_config["appVer"] . ',
            "appCode": "' . $this->momo_data_config["appCode"] . '",
            "deviceOS":"ANDROID",
            "buildNumber":1916,
            "appId":"vn.momo.transfer",
            "result":true,
            "errorCode":0,
            "errorDesc":"",
            "momoMsg":
            {
                "partnerId":"' . $phone . '",
                "_class":"mservice.backend.entity.msg.ForwardMsg",
                "message":"' . $this->get_string($message) . '"
            },
            "extra":
            {
                "checkSum":"' . $this->generateCheckSum('M2M_VALIDATE_MSG', $microtime) . '"
            }
        }';
        return $this->CURL("M2M_VALIDATE_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function TRAN_HIS_INIT_MSG($tranHisMsg)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: TRAN_HIS_INIT_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            "user" =>  $this->config['phone'],
            "msgType" => "TRAN_HIS_INIT_MSG",
            "cmdId"   => (string) $microtime . '000000',
            "lang"    => "vi",
            "time"    =>  (int) $microtime,
            "channel" => "APP",
            "appVer"  =>  $this->momo_data_config["appVer"],
            "appCode" => $this->momo_data_config["appCode"],
            "deviceOS" => "ANDROID",
            "buildNumber" => 0,
            "appId"   => "vn.momo.platform",
            "result"  => true,
            "errorCode" => 0,
            "errorDesc" => "",
            "momoMsg" => $tranHisMsg,
            "extra" => array(
                "checkSum" => $this->generateCheckSum('TRAN_HIS_INIT_MSG', $microtime)
            )
        );
        return $this->CURL("TRAN_HIS_INIT_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function TRAN_HIS_CONFIRM_MSG($tranHisMsg = [])
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: TRAN_HIS_CONFIRM_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data =  array(
            'user'    => $this->config['phone'],
            'pass'    => $this->config['password'],
            'msgType' => 'TRAN_HIS_CONFIRM_MSG',
            'cmdId'   => (string) $microtime . '000000',
            'lang'    => 'vi',
            'time'    => $microtime,
            'channel' => 'APP',
            'appVer'  => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId'   => 'vn.momo.platform',
            'result'  => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' => $tranHisMsg,
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('TRAN_HIS_CONFIRM_MSG', $microtime),
            ),
        );
        return $this->CURL("TRAN_HIS_CONFIRM_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function M2MU_CONFIRM($ID)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $ipaddress = $this->get_ip_address();
        $Data =  array(
            'user' => $this->config['phone'],
            'pass' => $this->config['password'],
            'msgType' => 'M2MU_CONFIRM',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'ids' =>
                array(
                    0 => $ID,
                ),
                'totalAmount' => $this->send['amount'],
                'originalAmount' => $this->send['amount'],
                'originalClass' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                'originalPhone' => $this->config['phone'],
                'totalFee' => '0.0',
                'id' => $ID,
                'GetUserInfoTaskRequest' => $this->send['receiver'],
                'tranList' =>
                array(
                    0 =>
                    array(
                        '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                        'user' => $this->config['phone'],
                        'clientTime' => (int) ($microtime - 211),
                        'tranType' => 36,
                        'amount' => (int) $this->send['amount'],
                        'receiverType' => 1,
                    ),
                    1 =>
                    array(
                        '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                        'user' => $this->config['phone'],
                        'clientTime' => (int) ($microtime - 211),
                        'tranType' => 36,
                        'partnerId' => $this->send['receiver'],
                        'amount' => 100,
                        'comment' => '',
                        'ownerName' => $this->config['Name'],
                        'receiverType' => 0,
                        'partnerExtra1' => '{"totalAmount":' . $this->send['amount'] . '}',
                        'partnerInvNo' => 'borrow',
                    ),
                ),
                'serviceId' => 'transfer_p2p',
                'serviceCode' => 'transfer_p2p',
                'clientTime' => (int) ($microtime - 211),
                'tranType' => 2018,
                'comment' => '',
                'ref' => '',
                'amount' => $this->send['amount'],
                'partnerId' => $this->send['receiver'],
                'bankInId' => '',
                'otp' => '',
                'otpBanknet' => '',
                '_class' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                'extras' => '{"appSendChat":false,"vpc_CardType":"SML","vpc_TicketNo":"' . $ipaddress . '"","vpc_PaymentGateway":""}',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('M2MU_CONFIRM', $microtime),
            ),
        );
        return $this->CURL("M2MU_CONFIRM", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function M2MU_INIT()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: M2MU_INIT",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $ipaddress = $this->get_ip_address();
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'M2MU_INIT',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => (int) $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                'clientTime' => (int) $microtime - 221,
                'tranType' => 2018,
                'comment' => $this->send['comment'],
                'amount' => $this->send['amount'],
                'partnerId' => $this->send['receiver'],
                'partnerName' => $this->send['partnerName'],
                'ref' => '',
                'serviceCode' => 'transfer_p2p',
                'serviceId' => 'transfer_p2p',
                '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                'tranList' =>
                array(
                    0 =>
                    array(
                        'partnerName' => $this->send['partnerName'],
                        'partnerId' => $this->send['receiver'],
                        'originalAmount' => $this->send['amount'],
                        'serviceCode' => 'transfer_p2p',
                        'stickers' => '',
                        'themeBackground' => '#f5fff6',
                        'themeUrl' => 'https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png',
                        'transferSource' => '',
                        'socialUserId' => '',
                        '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                        'tranType' => 2018,
                        'comment' => $this->send['comment'],
                        'moneySource' => 1,
                        'partnerCode' => 'momo',
                        'serviceMode' => 'transfer_p2p',
                        'serviceId' => 'transfer_p2p',
                        'extras' => '{"loanId":0,"appSendChat":false,"loanIds":[],"stickers":"","themeUrl":"https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png","hidePhone":false,"vpc_CardType":"SML","vpc_TicketNo":"' . $ipaddress . '","vpc_PaymentGateway":""}',
                    ),
                ),
                'extras' => '{"loanId":0,"appSendChat":false,"loanIds":[],"stickers":"","themeUrl":"https://cdn.mservice.com.vn/app/img/transfer/theme/Corona_750x260.png","hidePhone":false,"vpc_CardType":"SML","vpc_TicketNo":"' . $ipaddress . '","vpc_PaymentGateway":""}',
                'moneySource' => 1,
                'partnerCode' => 'momo',
                'rowCardId' => '',
                'giftId' => '',
                'useVoucher' => 0,
                'prepaidIds' => '',
                'usePrepaid' => 0,
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('M2MU_INIT', $microtime),
            ),
        );
        return $this->CURL("M2MU_INIT", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function API_DEFAULT_SOURCE()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config['authorization'],
            "msgtype: QUERY_TRANSACTION_EXPENSE_MANAGEMENT_V2_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'API_DEFAULT_SOURCE',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' =>  (int) $microtime,
            'channel' => 'APP',
            'appVer' => 30323,
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 74,
            'appId' => 'vn.momo.authenlinkingservices',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.DefaultSourceRequestMsg',
                'action' => 'GET',
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('API_DEFAULT_SOURCE', $microtime),
            ),
        );
        return $this->CURL("API_DEFAULT_SOURCE", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function sync()
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config['authorization'],
            "msgtype: QUERY_TRANSACTION_EXPENSE_MANAGEMENT_V2_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'QUERY_TRANSACTION_EXPENSE_MANAGEMENT_V2_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 1720,
            'appId' => 'vn.momo.transactionhistory',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.ExpenseManagementDataMsg',
                'begin'  => 0,
                'end'    => $microtime
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('QUERY_TRANSACTION_EXPENSE_MANAGEMENT_V2_MSG', $microtime),
            ),
        );
        return $this->CURL("sync", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }
    public function TRAN_HIS_LIST($from, $to, $limit)
    {

        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "userid: " . $this->config["phone"],
            "Host: api.momo.vn",
            'requestkey: ' . $requestkey
        );
        $Data = array(
            'requestId' => (string) $microtime,
            'startDate' => $from,
            'endDate' => $to,
            'offset' => 0,
            'limit' => $limit,
            'appCode' => $this->momo_data_config["appCode"],
            'appVer' => $this->momo_data_config["appVer"],
            'lang' => 'vi',
            'deviceOS' => 'ANDROID',
            'channel' => 'APP',
            'buildNumber' => 4155,
            'appId' => 'vn.momo.transactionhistory',
        );

        return $this->CURL("TRAN_HIS_LIST", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }
    public function GET_TRANS_BY_TID($ID)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: GET_TRANS_BY_TID",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'GET_TRANS_BY_TID',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                'tranId' => $ID
            ),
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('GET_TRANS_BY_TID', $microtime),
            ),
        );
        return $this->CURL("GET_TRANS_BY_TID", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function QUERY_TRAN_HIS_MSG($hours)
    {

        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: QUERY_TRAN_HIS_MSG",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );

        $begin =  (time() - (3600 * $hours)) * 1000;
        $microtime = $this->get_microtime();
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'QUERY_TRAN_HIS_MSG',
            'cmdId' => (string) $microtime . '000000',
            'time' => $microtime,
            'lang' => 'vi',
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'appId' => 'vn.momo.platform',
            'result' => true,
            'buildNumber' => 0,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' =>
            array(
                'checkSum' => $this->generateCheckSum('QUERY_TRAN_HIS_MSG', $microtime),
            ),
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.QueryTranhisMsg',
                'begin' => $begin,
                'end' => $microtime,
            ),
        );
        return $this->CURL("QUERY_TRAN_HIS_MSG", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }
    public function CHECK_USER_PRIVATE($receiver)
    {
        $microtime = $this->get_microtime();
        $requestkeyRaw = $this->generateRandom(32);
        $requestkey = $this->RSA_Encrypt($this->config["RSA_PUBLIC_KEY"], $requestkeyRaw);
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . $this->config["sessionkey"],
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: CHECK_USER_PRIVATE",
            "userid: " . $this->config["phone"],
            "requestkey: " . $requestkey,
            "Host: owa.momo.vn"
        );
        $Data = '{
            "user":"' . $this->config['phone'] . '",
            "msgType":"CHECK_USER_PRIVATE",
            "cmdId":"' . $microtime . '000000",
            "lang":"vi",
            "time":' . (int) $microtime . ',
            "channel":"APP",
            "appVer": ' . $this->momo_data_config["appVer"] . ',
            "appCode": "' . $this->momo_data_config["appCode"] . '",
            "deviceOS":"ANDROID",
            "buildNumber":1916,
            "appId":"vn.momo.transfer",
            "result":true,
            "errorCode":0,
            "errorDesc":"",
            "momoMsg":
            {
                "_class":"mservice.backend.entity.msg.LoginMsg",
                "getMutualFriend":false
            },
            "extra":
            {
                "CHECK_INFO_NUMBER":"' . $receiver . '",
                "checkSum":"' . $this->generateCheckSum('CHECK_USER_PRIVATE', $microtime) . '"
            }
        }';
        return $this->CURL("CHECK_USER_PRIVATE", $header, $this->Encrypt_data($Data, $requestkeyRaw));
    }

    public function USER_LOGIN_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . (!empty($this->config["sessionkey"])) ? $this->config["sessionkey"] : "",
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: USER_LOGIN_MSG",
            "Host: owa.momo.vn",
            "user_id: " . $this->config["phone"],
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momo_data_config["appVer"],
            "app_code: " . $this->momo_data_config["appCode"],
            "device_os: ANDROID"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'USER_LOGIN_MSG',
            'pass' => $this->config['password'],
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.LoginMsg',
                'isSetup' => false,
            ),
            'extra' =>
            array(
                'pHash' => $this->get_pHash(),
                'AAID' => $this->config['AAID'],
                'IDFA' => '',
                'TOKEN' => $this->config['TOKEN'],
                'SIMULATOR' => '',
                'SECUREID' => $this->config['SECUREID'],
                'MODELID' => $this->config['MODELID'],
                'checkSum' => $this->generateCheckSum('USER_LOGIN_MSG', $microtime),
            ),
        );
        return $this->CURL("USER_LOGIN_MSG", $header, $Data);
    }
    public function GENERATE_TOKEN_AUTH_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: " . $this->config["agent_id"],
            "user_phone: " . $this->config["phone"],
            "sessionkey: " . (!empty($this->config["sessionkey"])) ? $this->config["sessionkey"] : "",
            "authorization: Bearer " . $this->config["authorization"],
            "msgtype: GENERATE_TOKEN_AUTH_MSG",
            "Host: api.momo.vn",
            "user_id: " . $this->config["phone"],
            "User-Agent: MoMoPlatform-Release/31062 CFNetwork/1325.0.1 Darwin/21.1.0",
            "app_version: " . $this->momo_data_config["appVer"],
            "app_code: " . $this->momo_data_config["appCode"],
            "device_os: ANDROID"
        );
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'GENERATE_TOKEN_AUTH_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RefreshTokenMsg',
                'refreshToken' => $this->config["refreshToken"],
            ),
            'extra' =>
            array(
                'pHash' => $this->get_pHash(),
                'AAID' => $this->config['AAID'],
                'IDFA' => '',
                'TOKEN' => $this->config['TOKEN'],
                'SIMULATOR' => '',
                'SECUREID' => $this->config['SECUREID'],
                'MODELID' => $this->config['MODELID'],
                'checkSum' => $this->generateCheckSum('GENERATE_TOKEN_AUTH_MSG', $microtime),
            ),
        );
        return $this->CURL("GENERATE_TOKEN_AUTH_MSG", $header, $Data);
    }
    public function CHECK_USER_BE_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: CHECK_USER_BE_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momo_data_config["appVer"],
            "app_code: ",
            "device_os: ANDROID"
        );

        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'CHECK_USER_BE_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->config['phone'],
                'imei' => $this->config["imei"],
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => $this->config["device"],
                'firmware' => '23',
                'hardware' => $this->config["hardware"],
                'manufacture' => $this->config["facture"],
                'csp' => 'Viettel',
                'icc' => '',
                'mcc' => '452',
                'device_os' => 'Android',
                'secure_id' => $this->config["SECUREID"],
            ),
            'extra' =>
            array(
                'checkSum' => '',
            ),
        );
        return $this->CURL("CHECK_USER_BE_MSG", $header, $Data);
    }

    public function REG_DEVICE_MSG()
    {
        $microtime = $this->get_microtime();
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: REG_DEVICE_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momo_data_config["appVer"],
            "app_code: " . $this->momo_data_config["appCode"],
            "device_os: ANDROID"
        );
        $Data = '{
            "user": "' . $this->config["phone"] . '",
            "msgType": "REG_DEVICE_MSG",
            "cmdId": "' . $microtime . '000000",
            "lang": "vi",
            "time": ' . $microtime . ',
            "channel": "APP",
            "appVer": ' . $this->momo_data_config["appVer"] . ',
            "appCode": "' . $this->momo_data_config["appCode"] . '",
            "deviceOS": "ANDROID",
            "buildNumber": 0,
            "appId": "vn.momo.platform",
            "result": true,
            "errorCode": 0,
            "errorDesc": "",
            "momoMsg": {
              "_class": "mservice.backend.entity.msg.RegDeviceMsg",
              "number": "' . $this->config["phone"] . '",
              "imei": "' . $this->config["imei"] . '",
              "cname": "Vietnam",
              "ccode": "084",
              "device": "' . $this->config["device"] . '",
              "firmware": "23",
              "hardware": "' . $this->config["hardware"] . '",
              "manufacture": "' . $this->config["facture"] . '",
              "csp": "",
              "icc": "",
              "mcc": "",
              "device_os": "Android",
              "secure_id": "' . $this->config["SECUREID"] . '"
            },
            "extra": {
              "ohash": "' . $this->config['ohash'] . '",
              "AAID": "' . $this->config["AAID"] . '",
              "IDFA": "",
              "TOKEN": "' . $this->config["TOKEN"] . '",
              "SIMULATOR": "",
              "SECUREID": "' . $this->config["SECUREID"] . '",
              "MODELID": "' . $this->config["MODELID"] . '",
              "checkSum": ""
            }
          }';
        return $this->CURL("REG_DEVICE_MSG", $header, $Data);
    }

    public function SEND_OTP_MSG()
    {
        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: SEND_OTP_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momo_data_config["appVer"],
            "app_code: " . $this->momo_data_config["appCode"],
            "device_os: ANDROID"
        );
        $microtime = $this->get_microtime();
        $Data = array(
            'user' => $this->config['phone'],
            'msgType' => 'SEND_OTP_MSG',
            'cmdId' => (string) $microtime . '000000',
            'lang' => 'vi',
            'time' => $microtime,
            'channel' => 'APP',
            'appVer' => $this->momo_data_config["appVer"],
            'appCode' => $this->momo_data_config["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->config['phone'],
                'imei' => $this->config["imei"],
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => $this->config["device"],
                'firmware' => '23',
                'hardware' => $this->config["hardware"],
                'manufacture' => $this->config["facture"],
                'csp' => '',
                'icc' => '',
                'mcc' => '452',
                'device_os' => 'Android',
                'secure_id' => $this->config['SECUREID'],
            ),
            'extra' =>
            array(
                'action' => 'SEND',
                'rkey' => $this->config["rkey"],
                'AAID' => $this->config["AAID"],
                'IDFA' => '',
                'TOKEN' => $this->config["TOKEN"],
                'SIMULATOR' => '',
                'SECUREID' => $this->config['SECUREID'],
                'MODELID' => $this->config["MODELID"],
                'isVoice' => false,
                'REQUIRE_HASH_STRING_OTP' => true,
                'checkSum' => '',
            ),
        );
        return $this->CURL("SEND_OTP_MSG", $header, $Data);
    }

    public function get_ip_address()
    {
        $isValid = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if (!empty($isValid)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        try {
            $isIpv4 = json_decode(file_get_contents('https://api.ipify.org?format=json'), true);
            return $isIpv4['ip'];
        } catch (\Throwable $e) {
            return '116.107.187.109';
        }
    }

    public function get_TOKEN()
    {
        return  $this->generateRandom(22) . ':' . $this->generateRandom(9) . '-' . $this->generateRandom(20) . '-' . $this->generateRandom(12) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(53) . '-' . $this->generateRandom(9) . '_' . $this->generateRandom(11) . '-' . $this->generateRandom(4);
    }

    public function CURL_proxy($Action, $header, $data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $DataPost = http_build_query(array(
            'url' => $Action,
            'data_post' => $Data,
            'header'    => json_encode($header)
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://curl.dowu.app',
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $DataPost
        ));

        return json_decode($this->Decrypt_data(curl_exec($curl)), true);
    }

    public function CURL($Action, $header, $data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        // echo strlen($Data); die;
        $header[] = 'Content-Type: application/json';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: ' . strlen($Data);
        $opt = array(
            CURLOPT_URL => $this->URLAction[$Action],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => empty($data) ? FALSE : TRUE,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 20,
        );
        curl_setopt_array($curl, $opt);
        $body = curl_exec($curl);
        // echo strlen($body); die;
        if (is_object(json_decode($body))) {
            return json_decode($body, true);
        }
        return json_decode($this->Decrypt_data($body), true);
    }

    public function RSA_Encrypt($key, $content)
    {
        if (empty($this->rsa)) {
            $this->INCLUDE_RSA($key);
        }
        return base64_encode($this->rsa->encrypt($content));
    }

    public function INCLUDE_RSA($key)
    {
        require_once('lib/RSA/Crypt/RSA.php');
        $this->rsa = new Crypt_RSA();
        $this->rsa->loadKey($key);
        $this->rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
        return $this;
    }

    public function Encrypt_data($data, $key)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $this->keys = $key;
        return base64_encode(openssl_encrypt(is_array($data) ? json_encode($data) : $data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
    }

    public function Decrypt_data($data)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $this->keys, OPENSSL_RAW_DATA, $iv);
    }

    public function generateCheckSum($type, $microtime)
    {
        $Encrypt =   $this->config["phone"] . $microtime . '000000' . $type . ($microtime / 1000000000000.0) . 'E12';
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($Encrypt, 'AES-256-CBC', $this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    public function get_pHash()
    {
        $data = $this->config["imei"] . "|" . $this->config["password"];
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    public function get_setupKey($setUpKey)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($setUpKey), 'AES-256-CBC', $this->config["ohash"], OPENSSL_RAW_DATA, $iv);
    }

    public function generateRandom($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function get_SECUREID($length = 17)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(12);
    }

    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_string($data)
    {
        return str_replace(array('<', "'", '>', '?', '/', "\\", '--', 'eval(', '<php', '-'), array('', '', '', '', '', '', '', '', '', ''), htmlspecialchars(addslashes(strip_tags($data))));
    }

    public function get_microtime()
    {
        return round(microtime(true) * 1000);
    }
}
