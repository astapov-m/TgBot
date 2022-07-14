<?php


namespace App\Modules\Telegram\Model;


class Keyboard extends Message
{
    public function sendMessage($text,$keyboard){
        $reply = json_encode(array('keyboard'=>$keyboard,'resize_keyboard'=>true,'one_time_keyboard'=>false));
        $response = $this->query('sendMessage',[
            'text' => $text,
            'chat_id' => $this->chat_id,
            'reply_markup'=> $reply
        ]);
        return $response;
    }
}