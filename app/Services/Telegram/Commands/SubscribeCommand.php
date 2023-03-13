<?php

namespace App\Services\Telegram\Commands;

use App\Http\Controllers\languageController;
use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\Objects\User;

class SubscribeCommand extends BaseCommands
{
    protected static $aliases = [ '/subscribe', '/sub' ];
    protected static $description = 'Send "/subscribe" or "/sub" to get subscribed';

    public function handle()
    {
        $updates = $this->update;
        $user = $updates->callback_query->from ?? $updates->my_chat_member->from ?? $updates->message->from;
        $lang = languageController::getLanguage($updates);
        $res = $this->subClient($user,$updates);
        if($res){
            $this->sendMessage([
                'text' => "$lang->doneSub",
            ]);
            $this->validateMessage($updates);
        }
    }
   
    protected function handleClient(){
        $client = $this->getClient();
        if($client){
            return $client;
        }else{
            return false;
        }
    }
    protected function subClient(User $user,Update $update){
        $client = $this->handleClient();
        $lang = languageController::getLanguage($update);
        if($client){
            $this->sendMessage([
                'text' => "$lang->alreadySub",
            ]);
            $this->validateMessage($update);
        }else{
            $client = new Client;
            $client->client_id = $user->id;
            $client->first_name = $user->first_name ?? null;
            $client->last_name = $user->last_name ?? null;
            $client->username = $user->username ?? null;
            $client->language = $user->language_code ?? null;
            $result = $client->save();
            return $result;
        }
    }
}