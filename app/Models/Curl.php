<?php

namespace App\Models;

class Curl
{
    private $headers = array();
    private $postDatas = array();
    private $files = array();
    private $url = '';

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setPostDatas($postDatas = null)
    {
        $postDatas ? $this->postDatas = $postDatas : null;
    }

    /*
     * @$json bool
     * @$return bool
     * @$method 1:POST 2:GET
     */
    public function request($json = false, $return = true, $method = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if ($return) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        }
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($json) {
            $this->headers[] = 'Content-Type:application/json; charset=utf-8';
        }
        if ($this->headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if ($method == 1) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        if (is_array($this->postDatas)) {
            $this->postDatas = $this->postDatas + $this->files;
        }
        if ($this->postDatas) {
            if ($json) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->postDatas));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postDatas);
            }
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
