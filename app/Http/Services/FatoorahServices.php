<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class FatoorahServices {

    private $base_url;
    private $headers;
    private $request_clients;

    public function __construct(Client $request_clients){
        $this->request_clients = $request_clients;
        $this->base_url = env('fatoorah_base_url');
        $this->headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Bearer ' . env('fatoorah_token')
        ];
    }

    public function buildRequest($uri,$method,$data= []){
        $request = new Request($method, $this->base_url . $uri,$this->headers);
        //if(!$data)
        //    return false;
        $response = $this->request_clients->send($request,
        [
            'json' => $data
        ]);
        if($response->getStatusCode() != 200){
            //return false;
        }
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    public function sendPayment($data){
        return $response = $this->buildRequest('/v2/SendPayment','POST',$data);
    }

    public function getPaymentStatus($data)
    {
        return $response = $this->buildRequest('/v2/getPaymentStatus','POST',$data);
    }

}
