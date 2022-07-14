<?php


namespace App;


use App\Modules\Monitoring\Model\Monitoring;
use App\Modules\Telegram\Model\Keyboard;
use App\Modules\Telegram\Model\Message;
use App\Modules\Telegram\Model\MessageRepositoryJson;
use App\Modules\Telegram\Model\Update;
use App\Modules\Telegram\Model\UpdateRepository;

class Executor
{
    public function run(){
        $update = new Update();
        (new UpdateRepository())->save();

        $message = new Message();

        //$keyboard = new Keyboard();
        //$keyboard->sendMessage($update->getFullName().'Ку ',array(array('Проверить URL')));
        switch ($update->getText()){
            case  'Проверить URL' :
                $message = $message->sendMessage('Отправите ссылку');
                break;
            case 'Привет' :   $message = $message->sendMessage('Привет, '.$update->getFullName());
                break;
            case ($update->getText() != '') :
                if(filter_var($update->getText(), FILTER_VALIDATE_URL)){
                    $message = $message->sendMessage((new Monitoring())->siteMessage($update->getText()));
                }else{
                    $message = $message->sendMessage('Я вас не понял');
                }

        }


        (new MessageRepositoryJson())->save($message);
    }
}