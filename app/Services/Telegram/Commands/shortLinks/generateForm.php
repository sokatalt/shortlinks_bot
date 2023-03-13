<?php

namespace App\Services\Telegram\Commands\shortLinks;

use App\Http\Controllers\languageController;
use App\Http\Controllers\toggleForm;
use App\Services\Telegram\Base\BaseCommands;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;

class generateForm extends BaseCommands
{
    protected static $aliases = [ '/generateForm' ];
    protected static $description = 'Send "/generateForm" to generate form link';

    public function handle()
    {
        $bot = $this->bot;
        $update = $this->update;
        $lang = languageController::getLanguage($update);
        if($this->checkClientState() == true){
            $formButton1 = new InlineKeyboardButton([
                'text' => "$lang->genForm 1",
                'callback_data' => "GenerateForm1",
            ]);
            $formButton2 = new InlineKeyboardButton([
                'text' => "$lang->genForm 2",
                'callback_data' => "GenerateForm2",
            ]);
            $formButton3 = new InlineKeyboardButton([
                'text' => "$lang->genForm 3",
                'callback_data' => "GenerateForm3",
            ]);
            $ToggleName1 = toggleForm::getState($this->getClient()->id,1) ? $lang->enForm:$lang->disForm;
            $ToggleName2 = toggleForm::getState($this->getClient()->id,2) ? $lang->enForm:$lang->disForm;
            $ToggleName3 = toggleForm::getState($this->getClient()->id,3) ? $lang->enForm:$lang->disForm;
            $ToggleFormButton1 = new InlineKeyboardButton([
                'text' => "$ToggleName1 1",
                'callback_data' => "ToggleForm1",
            ]);
            $ToggleFormButton2 = new InlineKeyboardButton([
                'text' => " $ToggleName2 2",
                'callback_data' => "ToggleForm2",
            ]);
            $ToggleFormButton3 = new InlineKeyboardButton([
                'text' => "$ToggleName3 3",
                'callback_data' => "ToggleForm3",
            ]);
            $showLeadsButton = new InlineKeyboardButton([
                'text' => "$lang->leads",
                "callback_data" => "getLeads",
            ]);
            $reportButton = new InlineKeyboardButton([
                'text' => "$lang->report",
                "callback_data" => "showReports",
            ]);
            $this->sendMessage([
                "text" => "$lang->chooseFormMsg",
                "reply_markup"=>
                [
                    "inline_keyboard"=> [[$formButton1,$formButton2,$formButton3],
                    [$ToggleFormButton1,$ToggleFormButton2,$ToggleFormButton3],
                    [$reportButton,$showLeadsButton]]
                ]
            ]);
        }else{
            $this->sendMessage(["text" => "$lang->cpError"]);
        }
    }
}