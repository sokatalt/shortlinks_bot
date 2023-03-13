<?php

namespace App\Services\Telegram\Commands\Admin;

use App\Models\Client;
use App\Services\Telegram\Base\BaseCommands;
use League\Csv\Writer;

class showAllUsers extends BaseCommands
{
    protected static $aliases = [ '/showAllUsers' ];
    protected static $description = 'Send "/showAllUsers" to get all users';

    public function handle()
    {
        if ($this->is_admin()) {
            $updates = $this->update;
            $clients = Client::select("id","client_id","first_name","last_name","username","language","is_enabled","is_approved");
            if($clients->count() > 0){
                $csv = Writer::createFromPath(storage_path()."/Files/AllUsers.txt","w");
                $csv->insertOne(["id","client_id","first_name","last_name","username","language","is_enabled","is_approved"]);
                $csv->insertAll($clients->get()->toArray());
                $this->sendDocument([
                    "document" => storage_path()."/Files/AllUsers.txt",
                ]);
            }else{
                $this->sendMessage([
                    "text" => "You have no users yet",
                ]);
            }
        }
    }
}