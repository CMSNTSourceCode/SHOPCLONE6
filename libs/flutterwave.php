<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


use GuzzleHttp\Client;

class Flutterwave {
    private $publicKey;
    private $secretKey;
    private $baseUrl;

    public function __construct($publicKey, $secretKey, $isTestMode = true) {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->baseUrl = $isTestMode ? 'https://api.flutterwave.com/v3' : 'https://api.ravepay.co/v3';
    }

    public function initializePayment($amount, $currency, $redirectUrl, $customerEmail, $customerName) {
        $client = new Client();
        $payload = [
            'amount' => $amount,
            'currency' => $currency,
            'redirect_url' => $redirectUrl,
            'customer' => [
                'email' => $customerEmail,
                'name' => $customerName
            ]
        ];

        $response = $client->post($this->baseUrl . '/payments', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ],
            'json' => $payload
        ]);

        $responseData = json_decode($response->getBody(), true);
        return $responseData['data']['link'];
    }

    public function verifyPayment($transactionId) {
        $client = new Client();
        $response = $client->get($this->baseUrl . '/transactions/' . $transactionId . '/verify', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ]
        ]);
    
        return json_decode($response->getBody(), true);
    }
}