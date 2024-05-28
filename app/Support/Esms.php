<?php
namespace App\Support;

use \GuzzleHttp\Client;

class Esms
{
    const API_KEY = '';
    const SECRET_KEY = '';
    const BASE_URL = '';
    const BRANDNAME = '';

    private $apiKey;
    private $secretKey;
    private $baseUrl = '';
    private $brandName = '';

    public function __construct()
    {
        $this->apiKey = env('ESMS_API_KEY');
        $this->secretKey = env('ESMS_SECRET_KEY');
    }

    public function getBalance()
    {
        $httpClient = new Client();
        $response = $httpClient->get($this->baseUrl . 'GetBalance/' . $this->apiKey . '/' . $this->secretKey);
        echo $response->getStatusCode();
    }

    public function sendOtp($phone_number, $content)
    {
        $content = "Ma xac thuc cua ban la: $content";
        $httpClient = new Client();
        $response = $httpClient->get($this->baseUrl . 'SendMultipleMessage_V4_get?Phone=' . $phone_number . '&Content=' . $content . '&ApiKey=' . $this->apiKey . '&SecretKey=' . $this->secretKey . '&SmsType=2&Brandname=' . $this->brandName);
        $results = json_decode((string) $response->getBody(), true);
        if ($results['CodeResult'] == 100) {
            return true;
        }
        return false;
    }
}