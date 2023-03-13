<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\Subscription;
use App\Services\Telegram\Base\BaseCommands;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class GenerateSubKey extends BaseCommands
{
    protected static $aliases = [ '/generate' ];
    protected static $description = 'Send "/generate <number of days>"to get subscription key';

    public function handle()
    {
        if ($this->is_admin()) {
            // Generate a subscription key
            $generated_key = Str::uuid()->toString();
            $days = $this->getNumberOfDays();
            if(is_numeric($days) && $days != 0){
                $expire = Carbon::now()->addDays($days);

                // save it
                $subscription = $this->CreateKey($generated_key,$expire);

                if ($subscription) {
                    // send it to the admin
                    $this->sendMessage(["text" => $generated_key]);
                } else {
                    $this->sendMessage(["text" => 'Something Wrong!.']);
                }
            }
        }
    }
    
    protected function CreateKey($generated_key,$expire){
        $subscription = new Subscription();
        $subscription->key = $generated_key;
        $subscription->expire_at = $expire;
        $result = $subscription->save();
        return $result;
    }
}