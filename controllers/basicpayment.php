<?php 
require("../models/payment.php");
require('../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

Class basicpayment
{
    private $client;
    private $endpoint;
    private $identificador;
    private $seed;
    private $nonce;
    private $secretKey;
    private $tranKey;
    private $accessToken;
    private $payment;
    private $returnUrl;

    public function __construct()
    {
        $this->endpoint = 'https://test.placetopay.com/redirection/';
        $this->returnUrl = 'https://proyecto.test/controllers/';
        $this->identificador = '6dd490faf9cb87a9862245da41170ff2';
        $this->secretKey = '024h1IlD';
        $this->nonce = $this->getNonce();
        $this->seed = $this->getSeed();
        $this->tranKey = $this->getTranKey();
        $this->client = new Client();
        $this->payment = new payment();
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

    
    
    public function Payment($IdPayment,$amount,$currency) {

        $request = [
            'auth' => [
                'login' => "$this->identificador",
                'seed' => "$this->seed",
                'nonce' => '"'.base64_encode($this->nonce).'"',
                'tranKey'=> "$this->tranKey"
            ],
            'payment' => [
                'reference' => $IdPayment,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => $currency,
                    'total' => $amount,
                ],
            ],
            'expiration' => date('c', strtotime('+5 minutes')),
            'returnUrl' => $this->returnUrl.'resultpayment.php?reference=' . $IdPayment,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        try
        {
            $url = $this->endpoint . "api/session";
            $response = $this->client->post($url, [
                'json' => $request
            ]);
            
            $redirect = $response->getBody()->getContents();
            $array = json_decode($redirect);

            $request = $array->requestId;
            $this->payment->AddIdPayment($IdPayment,$request);
            return $array->processUrl;
        }
        catch (RequestException $e)
        {
            return $e->getMessage();
        }
    }

    public function ManagerInfo($firstname,$lastname,$email,$amount,$currency)
    {
        $IdUser = $this->payment->User($firstname,$lastname,$email);
        $IdPayment = $this->payment->Payment($amount,$currency,$IdUser);
        
        $process = $this->Payment($IdPayment,$amount,$currency);

        header('Location: '.$process);
    }

}   

if(isset($_POST['pay'])){
    $firstname = $_REQUEST['inputfirstname'];
    $lastname = $_REQUEST['inputlastname'];
    $email = $_REQUEST['inputemail'];
    $amount = $_REQUEST['inputamount'];
    $currency = $_REQUEST['inputcurrency'];

    $client = new basicpayment();
    $client->ManagerInfo($firstname,$lastname,$email,$amount,$currency);
}
else{
    header('Location: /views/checkout.html');
}
?>