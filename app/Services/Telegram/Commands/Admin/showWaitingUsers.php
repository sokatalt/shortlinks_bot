<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\users_wait_approve;
use App\Services\Telegram\Base\BaseCommands;
use League\Csv\Writer;

class showWaitingUsers extends BaseCommands
{
    protected static $aliases = [ '/showWaitingUsers' ];
    protected static $description = 'Send "/showWaitingUsers" to get waiting approve users';

    public function handle()
    {
        if ($this->is_admin()) {
            $clients = users_wait_approve::select("id","user_id","client_id","first_name","last_name","username","chat_id");
            if($clients->count() > 0){
                $csv = Writer::createFromPath(storage_path()."/Files/WaitingUsers.txt","w");
                $csv->insertOne(["id","user_id","client_id","first_name","last_name","username","chat_id"]);
                $csv->insertAll($clients->get()->toArray());
                $this->sendDocument([
                    "document" => storage_path()."/Files/WaitingUsers.txt",
                ]);
            }else{
                $this->sendMessage([
                    "text" => "You have no users waiting for approve",
                ]);
            }
        }
    }
}