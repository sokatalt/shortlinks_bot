<?php

namespace App\Http\Controllers;

use App\helpers\teleSession;
use Illuminate\Http\Request;
use WeStacks\TeleBot\Objects\Update;

class languageController extends Controller
{
    public static function getLanguage(Update $update){
        $langName = teleSession::Get("lang",$update) ?? "english";
        $xml = simplexml_load_file(app_path().'/Services/lang/'.$langName.'.xml') or die("Error: Cannot create object");
        $lang = $xml;
        return $lang;
    }
    public static function setLanguage($lang,Update $update){
        teleSession::Set("lang",$lang,$update);
    }
}
