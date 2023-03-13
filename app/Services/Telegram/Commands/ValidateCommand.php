<?php

namespace App\Services\Telegram\Commands;

use App\Http\Controllers\languageController;
use App\Services\Telegram\Base\BaseCommands;
use App\Services\Telegram\RequestsInput\validateKeyInput;

class ValidateCommand extends BaseCommands
{
    const MAX_TRIES = 3;
    protected static $aliases = [ '/validate' ];
    protected static $description = 'After you send the key in message send "/validate" to validate your subscription';
    public function handle()
    {
        $bot = $this->bot;
        $update = $this->update;
        if($this->getClient()){
            $lang = languageController::getLanguage($update);
            $user = $update->callback_query->from ?? $update->message->from ?? $update->my_chat_member->from;
            validateKeyInput::requestInput($bot,$user->id);
            return $bot->sendMessage([
                'chat_id' => $update->chat()->id,
                'text' => "$lang->keyAsk",
            ]);
        }
    }
}