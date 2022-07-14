<?php


namespace App\Modules\Telegram\Model;


use App\Modules\Telegram\Model\Pattern\IMessageSource;

class MessageRepositoryJson implements IMessageSource
{
    public function save($data){
        $file = file_get_contents('save/message.json');

        file_put_contents('save/message.json',$file.json_encode($data)."\n");
    }
}