<?php

namespace Classes;
class Curl
{
    private $base_url;
    private $curl;
    private $headers;

    /**
     * @param $base_url
     * @param $beared_token
     */
    public function __construct($base_url, $beared_token)
    {
        $this->base_url = $base_url . (!str_ends_with($base_url, '/') ? '/' : '');
        $this->curl = curl_init();
        $this->headers = [
            'Authorization: Bearer ' . $beared_token,
            'accept: application/json'
        ];
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => $this->headers
        ]);
    }

    /**
     * @param $action
     * @param $param
     * @return array
     */
    public function exec($action, $param=[]): array
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->base_url . $action . (!empty($param) ? '?' : '') . http_build_query($param)
        ]);
        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);
        return ['error'=>$err, 'response'=> json_decode($response,true)];
    }

    /**
     * @param $action
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function execPost($action, $param=[]): array
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->base_url . $action,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_USERAGENT => 'CB ' . \Update::getInstance()->getCurrentDBVersion() . ' - #' . \Update::getInstance()->getCurrentDBRevision(),
            CURLOPT_REFERER => config('base_url')
        ]);
        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);
        return ['error'=>$err, 'response'=> json_decode($response,true)];
    }

    /**
     * Upload a file using POST request
     * @param string $action Endpoint to call
     * @param string $filePath Path to the file to send
     * @param array $params Additional POST parameters
     * @param string $fieldName Name of the file field
     * @return array
     */
    public function sendFile(string $action, string $filePath, array $params = [], string $fieldName = 'file'): array
    {
        $params[$fieldName] = new \CURLFile($filePath);
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->base_url . $action,
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array_merge($this->headers, ['Content-Type: multipart/form-data'])
        ]);
        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);
        return ['error'=>$err, 'response'=> json_decode($response,true)];
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}