<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;

class disableUser extends BaseCommands
{
    protected static $aliases = [ '/disableUser' ];
    protected static $description = 'Send "/disableUser <user id>"to disable user';

    public function handle()
    {
        if ($this->is_admin()) {
            $user_id = $this->arguments()[0];
            if($user_id && is_numeric($user_id)){
              $user = Client::find($user_id);
              if($user){
                $user->is_enabled = false;
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
                $this->sendMessage(["text" => "Please enter the user id number /disableUser <user id>"]);
            }
        }
    }
}