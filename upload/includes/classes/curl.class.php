<?php

namespace Classes;
class Curl
{
    private $base_url;

    private $curl;


    /**
     * @param $base_url
     * @param $beared_token
     */
    public function __construct($base_url, $beared_token)
    {
        $this->base_url = $base_url . (substr($base_url, -1) != '/' ? '/' : '');
        $this->beared_token = $beared_token;
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $beared_token,
                'accept: application/json'
            ]
        ]);
    }

    /**
     * @param $action
     * @param $param
     * @return array
     */
    public function exec($action, $param=[])
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->base_url . $action . (!empty($param) ? '?' : '') . http_build_query($param)
        ]);
        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);
        return ['error'=>$err, 'response'=> json_decode($response,true)];
    }

    /**
     *
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }
}