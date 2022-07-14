<?php


namespace App\Modules\Telegram\Model;


class UpdateRepository
{

    public function save(){
        $file = file_get_contents('save/update.json');

        file_put_contents('save/update.json',$file.json_encode((new Update())->update())."\n");
    }
}