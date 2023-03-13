<?php

namespace App\Services\Telegram\Commands;

use App\helpers\teleSession;
use App\Http\Controllers\languageController;
use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;
use App\Services\Telegram\Commands\shortLinks\generateForm;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;
use WeStacks\TeleBot\Objects\Update;

class StartCommand extends BaseCommands
{
    protected static $aliases = [ '/start', '/s' ];
    protected static $description = 'Send "/start" or "/s" to Start chat';

    public function handle()
    {
        $updates = $this->update;
        $bot = $this->bot;
        $user = $updates->callback_query->from ?? $updates->my_chat_member->from ?? $updates->message->from;
        $lang = languageController::getLanguage($updates);
        $this->sendMessage([
            'text' => $lang->helloMessage.$user->first_name.' '.$user->last_name,
        ]);
        if(teleSession::Get('lang',$updates)){
            $this->checkClient($updates);
            if($this->getClient()){
                $Form = new generateForm($bot,$updates);
                $Form->handle();
            }
        }else{
            $this->chooseLanguage($updates);
        }
    }
    protected function chooseLanguage(Update $update){
        $lang = languageController::getLanguage($update);
        $langs = config("settings.langs");
        $langKeys = array_keys($langs);
        $buttons = array();
        $l = 0;
        $row = 0;
        for($i=0; sizeof($langs) > $i; $i++){
            if($l <= 2){
                $buttons[$row][] = new InlineKeyboardButton([
                    'text' => $langs[$langKeys[$i]],
                    'callback_data' => "$langKeys[$i]Lang",
                ]);
            }else{
                $l = 0;
                $row++;
                $buttons[$row][] = new InlineKeyboardButton([
                    'text' => $langs[$langKeys[$i]],
                    'callback_data' => "$langKeys[$i]Lang",
                ]);
            }
            $l++;
        }
        // $Arabic = new InlineKeyboardButton([
        //     'text' => "العربيه",
        //     'callback_data' => "arabicLang",
        // ]);
        // $English = new InlineKeyboardButton([
        //     'text' => "English",
        //     'callback_data' => "englishLang",
        // ]);
        $this->sendMessage([
            "text" => "$lang->chooseLang",
            "reply_markup"=>
            [
                "inline_keyboard"=> $buttons
            ]
        ]);
    }
    protected function checkClient(Update $update){
        $lang = languageController::getLanguage($update);
        $client = $this->getClient();
        if(!$client){
            $subButton = new InlineKeyboardButton([
                'text' => "$lang->subscribe",
                'callback_data' => "subscribe",
            ]);
            $LangChoose = new InlineKeyboardButton([
                'text' => "$lang->chooseLang",
                'callback_data' => "reChooseLang",
            ]);
            $this->sendMessage([
                'text' => "$lang->subscribeMessage",
                'reply_markup' => [
                    'inline_keyboard' => [[$subButton,$LangChoose]]
                ]
            ]);
        } else {
            $this->sendMessage([
                'text' => "$lang->welBack",
            ]);
            $this->validateMessage($update);
        }
    }
}