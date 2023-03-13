<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Http\Controllers\approveController;
use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;

class rejectApprove extends BaseCommands
{
    protected static $aliases = [ '/rejectApprove' ];
    protected static $description = 'Send "/rejectApprove <user id>" to reject user subscription';

    public function handle()
    {
        if ($this->is_admin()) {
            $user_id = $this->arguments()[0];
            if($user_id && is_numeric($user_id)){
              $user = Client::find($user_id);
              if($user){
                $chat_id = approveController::giveApprove($user->id);
                if($chat_id){
                    $this->sendMessage(["text" => "Done !"]);
                    $this->sendMessage(["chat_id" => $chat_id,"text" => "Your subscription is rejected"]);
                }else{
                    $this->sendMessage(["text" => "Something worng"]);
                }
              }else{
                $this->sendMessage(["text" => "The user not found"]);
              }
            }else{
                $this->sendMessage(["text" => "Please enter the user id number /rejectApprove <user id>"]);
            }
        }
    }
}