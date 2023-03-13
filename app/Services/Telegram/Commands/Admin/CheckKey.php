<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\Subscription;
use App\Services\Telegram\Base\BaseCommands;
use Illuminate\Support\Carbon;

class CheckKey extends BaseCommands
{
    protected static $aliases = [ '/check' ];
    protected static $description = 'Send "/check" to check the remaining days of your subscription';

    public function handle()
    {
        $expire = Subscription::find($this->getClient()->subscription_id);
        if($expire){
            $date = Carbon::parse($expire->expire_at);
            $now = Carbon::now();
            
            $diff = $date->diffInDays($now);

            $this->sendMessage(["text" => $diff]); 
        }else{
            $this->sendMessage(["text" => "You are not subscribed"]);
        }
    }
}