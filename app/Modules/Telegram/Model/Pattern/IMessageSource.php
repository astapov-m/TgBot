<?php


namespace App\Modules\Telegram\Model\Pattern;


interface IMessageSource
{
    public function save($data);
}