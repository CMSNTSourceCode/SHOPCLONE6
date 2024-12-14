<?php

class Api  
{
   
    public $api_url = 'https://5gsmm.com/api/v2'; // API URL
    private $api_key;


    function __construct(string $api_key) {
        $CMSNT = new DB;

		if(empty($api_key)) {
			throw new Exception('API key is not specified');
		} else {
			$this->api_key = $api_key;
		}
        $this->api_url = $CMSNT->site('domain_smmpanel').'api/v2';
	}


    public function order($data) { // add order
        $post = array_merge(array('key' => $this->api_key, 'action' => 'add'), $data);
        return json_decode($this->connect($post), true);
    }

    public function status($order_id) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'status',
            'order' => $order_id
        )));
    }

    public function multiStatus($order_ids) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'status',
            'orders' => implode(",", (array)$order_ids)
        )), true);
    }

    public function services() { // get services
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'services',
        )), true);
    }

    public function balance() { // get balance
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'balance',
        )), true);
    }


    private function connect($post) {
        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);
            }
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}


// $api = new Api('');

// $services = $api->services(); # return all services

// $balance = $api->balance(); # return user balance

// // add order

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100)); # Default

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'comments' => "good pic\ngreat photo\n:)\n;)")); # Custom Comments

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => 1000, 'usernames'=>"test")); # Mentions

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test')); # Package

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'runs' => 10, 'interval' => 60)); # Drip-feed

// $order = $api->order(array('service' => 1, 'username' => 'username', 'min' => 100, 'max' => 110, 'posts' => 0,'delay' => 30, 'expiry' => '11/11/2019')); # Subscriptions

// $order = $api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'username' => "test")); # Comment Likes

// $status = $api->status($order->order); # return status, charge, remains, start count, currency

// $statuses = $api->multiStatus([1, 2, 3]); # return orders status, charge, remains, start count, currency