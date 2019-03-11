<?php
require("../models/payment.php");
require('../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

Class resultpayment
{
    private $client;
    private $payment;
    private $urlDetail;
    private $identificador;
    private $seed;
    private $nonce;
    private $secretKey;
    private $tranKey;

    public function __construct()
    {
        $this->urlDetail = 'https://test.placetopay.com/redirection/';
        $this->identificador = '6dd490faf9cb87a9862245da41170ff2';
        $this->secretKey = '024h1IlD';
        $this->nonce = $this->getNonce();
        $this->seed = $this->getSeed();
        $this->tranKey = $this->getTranKey();
        $this->payment = new payment();
        $this->client = new Client();
    }

    public function getNonce()
    {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        return $nonce;
    }
    public function getSeed()
    {
        return date('c');
    }

    public function getTranKey()
    {
        $tranKey = base64_encode(sha1($this->nonce . $this->seed . $this->secretKey, true));
        return $tranKey;
    }
    
    public function response($response)
    {
        $IdPayment = $this->payment->GetPaymentId($response);

        $request = [
            'auth' => [
                'login' => "$this->identificador",
                'seed' => "$this->seed",
                'nonce' => '"'.base64_encode($this->nonce).'"',
                'tranKey'=> "$this->tranKey"
                ]
            ];

        $url = $this->urlDetail . "api/session/".$IdPayment;
        $responseUrl = $this->client->post($url, [
            'json' => $request
        ]);

        $redirect = $responseUrl->getBody()->getContents();
        $array = json_decode($redirect);
        
        require_once("../views/result.html");
    }
}

$response = $_REQUEST['reference'];
$result = new resultpayment();
$result->response($response);
?>