<?php
namespace App\Services\Telegram\RequestsInput;

use App\Http\Controllers\ApiManager;
use App\Http\Controllers\languageController;
use App\Models\Client;
use App\Models\Subscription;
use App\Services\Telegram\Base\BaseCommands;
use App\Services\Telegram\Commands\shortLinks\generateForm;
use Illuminate\Support\Facades\Validator;
use WeStacks\TeleBot\Handlers\RequestInputHandler;

class validateKeyInput extends RequestInputHandler
{
    const MAX_TRIES = 3;
    public function handle()
    {
        $update = $this->update;
        $bot = $this->bot;
        $data = $update->message()->toArray();
        if($update->message()->from->id != $bot->getMe()->id){
            $lang = languageController::getLanguage($update);
            $validator = Validator::make($data, [
                'text' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return $this->sendMessage([
                    'text' => "$lang->erkey"
                ]);
            }

            $this->acceptInput();
            $key = $validator->validated()['text'];
            if($key){
                $client_id = $update->user()->id;
                $last_message = $key;
                $client = Client::firstWhere('client_id', $client_id);
                if($client){
                    if ($this->hasReachedSubscriptionLimit($client)) {

                        // TODO: better if its a button
                        $this->sendMessage(["text" => "$lang->erTriesSubLimit"]);

                    } else {

                        //  Check the key (NOT NULL, NOT EMPTY, STRING, NOT COMMAND)
                        if ($last_message) {

                            if (is_string($last_message)) {

                                if (Subscription::isValidKey($last_message)) {
                                    $this->sendMessage(["text" => "$lang->validateDone"]);

                                    // disable this key, by making it to used
                                    Subscription::usedKey($last_message);

                                    // TODO: not in the right place
                                    // subscribe the client
                                    $client->update([
                                        "subscription_id" => Subscription::firstWhere('key', $last_message)->id
                                    ]);

                                    $client->resetSubscriptionTry();
                                    ApiManager::CreateCampaign($client_id,$client->id,11);
                                    $Form = new generateForm($bot,$update);
                                    $Form->handle();
                                    
                                    //$this->triggerCommand('forms');

                                } else {

                                    $this->sendMessage(["text" => "$lang->erkey"]);

                                    // add a failed try for the client
                                    $client->addSubscriptionTry();
                                    $cmd = new BaseCommands($bot,$update);
                                    $cmd->validateMessage($update);
                                }
                            } else {
                                $cmd = new BaseCommands($bot,$update);
                                $cmd->validateMessage($update);
                            }
                        } else {
                            $this->sendMessage(["text"=>"$lang->notKnowenErr"]);
                        }
                    } 
                }
            }
        }
    }
    public function hasReachedSubscriptionLimit($client): bool
    {
        return $client->subscription_tries >= self::MAX_TRIES;
    }
}