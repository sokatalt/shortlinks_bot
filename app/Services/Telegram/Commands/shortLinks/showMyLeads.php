<?php

namespace App\Services\Telegram\Commands\shortLinks;

use App\Models\Lead;
use App\Models\login_users_token;
use App\Services\Telegram\Base\BaseCommands;
use Illuminate\Support\Facades\Storage;
use WeStacks\TeleBot\Objects\InlineKeyboardButton;
use Illuminate\Support\Str;
use League\Csv\Writer;
use SplTempFileObject;

class showMyLeads extends BaseCommands
{
    protected static $aliases = [ '/showMyLeads' ];
    protected static $description = 'Send "/showMyLeads" to get your leads report';

    public function handle()
    {
        if($this->checkClientState() == true){
            $updates = $this->update;
            $user = $updates->callback_query->from ?? $updates->my_chat_member->from ?? $updates->message->from;
            $leads = Lead::select("name","address","phone","email","ip")
            ->where('compain_user_id',$this->getClient()->id)
            ->where('is_deleted',false);
            if($leads->count() > 0){
                $csv = Writer::createFromPath(storage_path()."/Files/$user->id.txt","w");
                $csv->insertOne(["name","address","phone","email","ip"]);
                $csv->insertAll($leads->get()->toArray());
                $this->sendDocument([
                    "document" => storage_path()."/Files/$user->id.txt",
                ]);
                $leads->update(["is_deleted" => true]);
            }else{
                $this->sendMessage([
                    "text" => "You have no leads yet",
                ]);
            }
            // Storage::put("file.txt",$csv);
        }
    }
}