<?php

namespace App\Services\Telegram\Base;

use App\Http\Controllers\languageController;
use App\Models\Client;
use Carbon\Carbon;
use WeStacks\TeleBot\Handlers\CommandHandler;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;
use WeStacks\TeleBot\Objects\KeyboardButton;
use WeStacks\TeleBot\Objects\Update;

class BaseCommands extends CommandHandler
{
    public function handle()
    {
    }
    public function getClient(): ?Client
    {
        // Get the client id
        $request_client_id = $this->update->callback_query->from->id ?? $this->update->my_chat_member->from ?? $this->update->message->from->id;

        // Find the Client in the database
        return Client::firstWhere("client_id", $request_client_id);
    }
    public function checkClientState() : bool
    {
        $client = $this->getClient();
        if(!$client){
            return false;
        // }elseif($client->subscription->expire_at < Carbon::now()){
        //     return false;
        // }elseif($client->subscription->is_enabled == false){
        //     return false;
        }elseif($client->is_approved == false){
            return false;
        }elseif($client->is_enabled == false){
            return false;
        }
        return true;
    }
    public function validateMessage(Update $update){
        $lang = languageController::getLanguage($update);
        if($this->getClient()->is_approved == false){
            $LangChoose = new InlineKeyboardButton([
                'text' => "$lang->chooseLang",
                'callback_data' => "reChooseLang",
            ]);
            $validate = new InlineKeyboardButton([
                'text' => "$lang->askApproval",
                'callback_data' => "ask_approve",
            ]);
            $this->sendMessage([
                'text' => "$lang->approvalMsg",
                'reply_markup' => [
                    'inline_keyboard' => [[$validate,$LangChoose]]
                ]
            ]);
            
        }
    }
    protected function arguments()
    {
        $TheMessage = "";
        $TheMessage = $this->update->message->text;
        $command = array_filter(explode(' ', $TheMessage));
        array_shift($command);
        return $command;
    }
    public function getNumberOfDays(){
        $days = $this->arguments()[0] ?? "";
        if(!$days || $days == 0){
            return $this->sendMessage(["text" => "Number of days can't be null or zero, Please send /generate <number of days>"]);
        }else{
            return $days;
        }
    }
    public function is_admin() : bool
    {
        $updates = $this->update;
        $user = $updates->callback_query->from ?? $updates->my_chat_member->from ?? $updates->message->from;
        if ($user->id == config('settings.admin_id')) {
            return true;
        }else{
            return false;
        }
    }
    public function keyboardReply($ButtonText,$message,$is_one_time){
        $button = new KeyboardButton([
            'text' => $ButtonText
        ]);
        $this->sendMessage([
            'text' => $message,
            'reply_markup' => [
                'keyboard' => [[$button]],
                'one_time_keyboard' => $is_one_time,
            ]
        ]);
    }
    public function inlineButton($message,$text,$classCommand){
        $button = new InlineKeyboardButton([
            'text' => $text,
            'callback_data' => $classCommand,
        ]);
        $this->sendMessage([
            'text' => $message,
            'reply_markup' => [
                'inline_keyboard' => [[$button]]
            ]
        ]);
    }
}