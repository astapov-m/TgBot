<?php


namespace App\Modules\Telegram\Model;
use GuzzleHttp\Client;

class Message
{
    const token = '5575281586:AAG__7V88o4Qd_hFj24rybmZFEsdp2MTc20';
    protected $chat_id;

    public function __construct()
    {
        $this->chat_id = (new Update())->getChatid();
    }

    protected function query($method,$params = []){
        $url = 'https://api.telegram.org/bot';
        $url .= self::token;
        $url .= "/".$method;
        if(!empty($params)){
            $url .= "?".http_build_query($params);
        }
        $client = new Client(['base_uri'=> $url]);
        $result = $client->request('GET');
        return json_decode($result->getBody());
    }

    public function sendMessage($text){
        $response = $this->query('sendMessage',[
            'chat_id' => $this->chat_id,
            'text' => $text
        ]);
        return $response;
    }
}