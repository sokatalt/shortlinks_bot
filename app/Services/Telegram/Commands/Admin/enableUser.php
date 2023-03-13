<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;

class enableUser extends BaseCommands
{
    protected static $aliases = [ '/enableUser' ];
    protected static $description = 'Send "/enableUser <user id>"to enable user';

    public function handle()
    {
        if ($this->is_admin()) {
            $user_id = $this->arguments()[0];
            if($user_id && is_numeric($user_id)){
              $user = Client::find($user_id);
              if($user){
                $user->is_enabled = true;
                $result = $user->save();
                if($result){
                    $this->sendMessage(["text" => "Done !"]);
                }else{
                    $this->sendMessage(["text" => "Something worng"]);
                }
              }else{
                $this->sendMessage(["text" => "The user not found"]);
              }
            }else{
                $this->sendMessage(["text" => "Please enter the user id number /enableUser <user id>"]);
            }
        }
    }
}