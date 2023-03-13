<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Http\Controllers\ApiManager;
use App\Http\Controllers\approveController;
use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;

class giveApprove extends BaseCommands
{
    protected static $aliases = [ '/giveApprove' ];
    protected static $description = 'Send "/giveApprove <user id>"to Approve user subscription';

    public function handle()
    {
        if ($this->is_admin()) {
            $argus = $this->arguments();
            $user_id = null;
            if($argus){
              $user_id = $argus[0];
            }
            if($user_id && is_numeric($user_id)){
              $user = Client::find($user_id);
              if($user){
                $chat_id = approveController::giveApprove($user->id);
                if($chat_id){
                    $this->sendMessage(["text" => "Done !"]);
                    ApiManager::CreateCampaign($user->client_id,$user->id,11);
                    $startButton = new InlineKeyboardButton([
                      'text' => "Start",
                      'callback_data' => "StratCp",
                    ]);
                    $this->sendMessage([
                      "chat_id" => $chat_id,
                      "text" => "Congratulations, your subscription has been confirmed 🎉",
                      'reply_markup' => [
                        'inline_keyboard' => [[$startButton]]
                    ]
                    ]);
                }else{
                    $this->sendMessage(["text" => "Something worng"]);
                }
              }else{
                $this->sendMessage(["text" => "The user not found"]);
              }
            }else{
                $this->sendMessage(["text" => "Please enter the user id number /giveApprove <user id>"]);
            }
        }
    }
}