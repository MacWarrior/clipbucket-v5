<?php

namespace Xhgui\Profiler\Saver;

use Xhgui\Profiler\Exception\ProfilerException;

final class UploadSaver implements SaverInterface
{
    /** @var string */
    private $url;
    /** @var int */
    private $timeout;
    /** @var bool */
    private $verify;

    public function __construct($url, $token, $timeout, $verify)
    {
        $this->url = $url;
        if ($token) {
            $this->url .= '?&token=' . $token;
        }

        $this->timeout = $timeout;
        $this->verify = $verify;
    }

    public function isSupported()
    {
        return $this->url && function_exists('curl_init');
    }

    public function save(array $data)
    {
        $json = json_encode($data, PHP_VERSION_ID >= 70200 ? JSON_INVALID_UTF8_IGNORE : 0);

        if ($json === false) {
            return false;
        }

        $this->submit($this->url, $json);

        return true;
    }

    /**
     * @param string $url
     * @param string $payload
     */
    private function submit($url, $payload)
    {
        $ch = curl_init($url);
        if (!$ch) {
            throw new ProfilerException('Failed to create cURL resource');
        }

        $headers = array(
            // Prefer to receive JSON back
            'Accept: application/json',
            // The sent data is JSON
            'Content-Type: application/json',
        );

        $res = curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => $this->verify,
        ));
        if (!$res) {
            $error = curl_errno($ch) ? curl_error($ch) : '';
            throw new ProfilerException('Failed to set cURL options' . ($error ? ': ' . $error : ''));
        }

        $result = curl_exec($ch);
        if ($result === false) {
            $error = curl_errno($ch) ? curl_error($ch) : '';
            throw new ProfilerException('Failed to submit data' . ($error ? ': ' . $error : ''));
        }
        curl_close($ch);

        $response = json_decode($result, true);
        if (!$response) {
            $error = json_last_error() ? (PHP_VERSION_ID >= 50500 ? json_last_error_msg() : 'Error ' . json_last_error()) : '';
            throw new ProfilerException('Failed to decode response' . ($error ? ': ' . $error : ''));
        }

        if (isset($response['error']) && $response['error']) {
            $message = isset($response['message']) ? $response['message'] : 'Error in response';
            throw new ProfilerException($message);
        }
    }
}
