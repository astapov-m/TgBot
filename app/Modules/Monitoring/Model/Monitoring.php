<?php


namespace App\Modules\Monitoring\Model;


class Monitoring
{
    function getTitle($url) {
        $title="";
        $page=file_get_contents($url);
        if ($page) {
            if (preg_match("~<title>(.*?)</title>~iu", $page, $out)) {
                $title = $out[1];
            }
        }
        return $title;
    }

    function siteMessage($url){
        $title = $this->getTitle($url);

        if($title == ""){
            return "Сайт не доступен";
        }else{
            return "Страница: ".$title;
        }
    }
}