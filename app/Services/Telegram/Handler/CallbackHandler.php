<?php

namespace App\Services\Telegram\Handler;

use App\helpers\teleSession;
use App\Http\Controllers\ApiManager;
use App\Http\Controllers\approveController;
use App\Http\Controllers\createShortLink;
use App\Http\Controllers\languageController;
use App\Http\Controllers\toggleForm;
use App\Models\apiCampaigns;
use App\Models\Client;
use App\Services\Telegram\Commands\shortLinks\generateForm;
use App\Services\Telegram\Commands\shortLinks\showMyLeads;
use App\Services\Telegram\Commands\shortLinks\showReports;
use App\Services\Telegram\Commands\StartCommand;
use App\Services\Telegram\Commands\SubscribeCommand;
use App\Services\Telegram\Commands\ValidateCommand;
use WeStacks\TeleBot\Handlers\UpdateHandler;

class CallbackHandler extends UpdateHandler
{
    public function trigger(): bool
    {
        $update = $this->update;
        return isset($update->callback_query);
    }

    public function handle()
    {
        $update = $this->update;
        $bot = $this->bot;
        $client_id = Client::firstWhere("client_id",$update->callback_query->from->id)->id ?? "";
        $lang = languageController::getLanguage($update);
        $cb = $update->callback_query->data;
        if($this->checkClientState()){
            if($cb === "GenerateForm1"){
                $shortlink = createShortLink::index(config("settings.default_destination"),1,$client_id)[0];
                $this->sendMessage(["text"=>$shortlink]);
            }
            elseif($cb === "GenerateForm2"){
                $shortlink = createShortLink::index(config("settings.default_destination"),2,$client_id)[0];
                $this->sendMessage(["text"=>$shortlink]);
            }elseif($cb === "GenerateForm3"){
                $shortlink = createShortLink::index(config("settings.default_destination"),3,$client_id)[0];
                $this->sendMessage(["text"=>$shortlink]);
            }elseif(str_contains($cb,"ToggleForm")){
                $formNumber = str_replace("ToggleForm","",$cb);
                toggleForm::toggle($client_id,$formNumber);
                $cmd = new generateForm($bot,$update);
                $cmd->handle();
            }elseif($cb === "getLeads"){
                $cmd = new showMyLeads($bot,$update);
                $cmd->handle();
            }elseif($cb === "showReports"){
                $cmd = new showReports($bot,$update);
                $cmd->handle();
            }elseif($cb == "reportToday"){
                $report = ApiManager::getReport($client_id,1);
                foreach($report as $cell){
                    $campain_number = apiCampaigns::firstWhere("Campaign_id",$cell->{"id"})->Campaign_number;
                    $this->sendMessage(["text"=>"Campaign $campain_number  visits:".$cell->{"clicks"}."  leads:".$cell->{"leads"}."  bad traffic:".$cell->{"bots"}."\n"]);
                }
            }elseif($cb == "report7Day"){
                $report = ApiManager::getReport($client_id,3);
                foreach($report as $cell){
                    $campain_number = apiCampaigns::firstWhere("Campaign_id",$cell->{"id"})->Campaign_number;
                    $this->sendMessage(["text"=>"Campaign $campain_number  visits:".$cell->{"clicks"}."  leads:".$cell->{"leads"}."  bad traffic:".$cell->{"bots"}."\n"]);
                }
            }
        }
        if($cb == "ask_approve"){
            $user = Client::firstWhere("client_id",$update->callback_query->from->id);
            $chat_id = $update->callback_query->message->chat->id;
            $result = approveController::askApprove($user,$chat_id);
            if($result){
                $this->sendMessage(["text"=>"$lang->willApprove"]);
            }else{
                $this->sendMessage(["text"=>"$lang->waitApprove"]);
            }
        }elseif($cb === "subscribe"){
            $cmd = new SubscribeCommand($bot,$update);
            $cmd->handle();
        }elseif($cb !== "reChooseLang" && strpos($cb,"Lang") > 0){
            $langName = str_replace("Lang","",$cb);
            languageController::setLanguage($langName,$update);
            $cmd = new StartCommand($bot,$update);
            $cmd->handle();
        }elseif($cb === "reChooseLang"){
            teleSession::remove("lang",$update);
            $cmd = new StartCommand($bot,$update);
            $cmd->handle();
        }elseif($cb === "validate"){
            $cmd = new ValidateCommand($bot,$update);
            $cmd->handle();
        }elseif($cb === "StratCp"){
            $cmd = new generateForm($bot,$update);
            $cmd->handle();
        }
        $bot->answerCallbackQuery([
            "callback_query_id" => $update->callback_query->id,
            "show_alert" => false,
        ]);
    }
    public function checkClientState() : bool
    {
        $request_client_id = $this->update->callback_query->from->id ?? $this->update->my_chat_member->from ?? $this->update->message->from->id;
        $client = Client::firstWhere("client_id", $request_client_id);
        if(!$client){
            return false;
        // }elseif($client->subscription->expire_at < Carbon::now()){
        //     return false;
        // }elseif($client->subscription->is_enabled == false){
        //     return false;
        }elseif($client->is_approved == false){
            return false;
        }elseif($client->is_enabled == false){
            return false;
        }
        return true;
    }
}