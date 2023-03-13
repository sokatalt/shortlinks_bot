<?php

namespace App\Services\Telegram\Commands\shortLinks;

use App\Http\Controllers\languageController;
use App\Services\Telegram\Base\BaseCommands;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;

class showReports extends BaseCommands
{
    protected static $aliases = [ '/showReports' ];
    protected static $description = 'Send "/showReports" to get your reports type';

    public function handle()
    {
        if($this->checkClientState() == true){
            $update = $this->update;
            $lang = languageController::getLanguage($update);
            $reportDayButton = new InlineKeyboardButton([
                'text' => "$lang->reportToday",
                'callback_data' => "reportToday",
            ]);
            $report7DayButton = new InlineKeyboardButton([
                'text' => "$lang->report7Day",
                'callback_data' => "report7Day",
            ]);
            $this->sendMessage([
                "text" => "$lang->ChooseReport",
                "reply_markup"=>
                [
                    "inline_keyboard"=> [[$reportDayButton,$report7DayButton]]
                ]
            ]);
        }
    }
}