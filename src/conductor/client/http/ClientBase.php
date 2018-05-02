<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:07 AM
 */

namespace conductor\client\http;

class ClientBase
{
    /**
     * @var string
     */
    public $rootUri;


    /**
     * @param string $url
     * @param array $queryParams
     * @return string
     */
    public function getForEntity(string $url, array $queryParams = []): string
    {
        $url = "{$this->rootUri}{$url}" . (http_build_query($queryParams) ? '?' . http_build_query($queryParams) : '');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @param string $url
     * @param mixed $queryParams
     * @return string
     */
    public function postForEntity(string $url, $queryParams): string
    {
        $url = "{$this->rootUri}{$url}";
        $ch = curl_init($url);
        $payload = json_encode($queryParams);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function delete(string $url, $queryParams = []) : string
    {
        $url = "{$this->rootUri}{$url}" . (http_build_query($queryParams) ? '?' . http_build_query($queryParams) : '');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}