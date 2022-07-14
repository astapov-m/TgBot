<?php


namespace App\Modules\Telegram\Model;

class Update
{

    public function update(){
        return json_decode(file_get_contents('php://input'),true);
    }

    public function getChatid(){
        return $this->update()['message']['chat']['id'];
    }
    public  function  getLastName(){
        return $this->update()['message']['chat']['last_name'];
    }

    public function getFirstName(){
        return $this->update()['message']['chat']['first_name'];
    }

    public function getFullName(){
        return $this->getLastName().' '.$this->getFirstName();
    }

    public  function  getText(){
        return $this->update()['message']['text'];
    }
/*
    public function saveMessage(){
        $message = $this->jsonUpdate();
        file_put_contents('message.json',$message);
    }
*/
}