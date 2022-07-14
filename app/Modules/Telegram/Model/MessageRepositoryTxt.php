<?php


namespace App\Modules\Telegram\Model;


use App\Modules\Telegram\Model\Pattern\IMessageSource;

class MessageRepositoryTxt implements IMessageSource
{

    public function save($data){
        $file = file_get_contents('save/message.txt');

        $newMessage = $data;

        file_put_contents('save/message.txt',$file.$newMessage."\n");
    }

}