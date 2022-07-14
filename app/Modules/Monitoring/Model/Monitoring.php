<?php


namespace App\Modules\Monitoring\Model;


class Monitoring
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getTitle() {
        $title="";
        $page=file_get_contents($this->url);
        if ($page) {
            if (preg_match("~<title>(.*?)</title>~iu", $page, $out)) {
                $title = $out[1];
            }
        }
        return $title;
    }

    public function siteMessage(){
        $title = $this->getTitle();
        $request = $this->request();
        $ssl = $this->getSSL();

        if($title == ""){
            return "Сайт не доступен";
        }else{
            return "Страница: ".$title." {Статус : ".$request['status']." ; http_code : ".$request['http_code']." ; Время ответа : ".$request['time']."}\n".
                "Домен : ".$ssl['subject']['CN'] . "\r\n".
                "Выдан : ".$ssl['issuer']['CN'] . "\r\n".
                'Истекает: ' . date('d.m.Y H:i', $ssl['validTo_time_t']);
            //return "Страница: ".$title;
        }
    }

    public function request(){
        $status = "ok";
        $http_code = "0";

        $startScriptTime = microtime(TRUE);
        file_get_contents($this->url, false, stream_context_create(['http' => ['ignore_errors' => true]]));
        $endScriptTime = microtime(TRUE);
        $totalScriptTime = $endScriptTime - $startScriptTime;

        if ($http_response_header == NULL){
            $status = "connection error";
        } elseif ($totalScriptTime > 30){
            $status = "conection timeout";
        } else {

            $status_line = $http_response_header[0];
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $http_code = $match[1];

            if ($http_code[0] != 2){
                $status = "http error";
            }
        }

        $output_item['status'] = $status;
        $output_item['http_code'] = $http_code;
        $output_item['time'] = number_format($totalScriptTime * 1000, 0);
        $output = $output_item;
        return $output;
    }
    public function getSSL(){
        $orignal_parse = parse_url($this->url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        return $certinfo;
    }

}