<?php
namespace App\helpers;

use App\Models\openSessions;
use WeStacks\TeleBot\Objects\Update;

class teleSession
{
    public static function Set($key,$input,Update $update){
        $user = $update->callback_query->from ?? $update->my_chat_member->from ?? $update->message->from;
        $value = self::Get($key,$update);
        if(!$value){
            $session = new openSessions();
            $session->client_id = $user->id;
            $session->key = $key;
            $session->value = $input;
            $session->save();
        }else{
            $session = openSessions::where("client_id",$user->id)->where("key",$key)->first();
            $session->client_id = $user->id;
            $session->key = $key;
            $session->value = $input;
            $session->save();
        }
    }
    public static function Get($key,Update $update){
        $user = $update->callback_query->from ?? $update->my_chat_member->from ?? $update->message->from;
        $row = openSessions::where("client_id",$user->id)->where("key",$key)->first();
        $value = null;
        if($row){
            $value = $row->value;
        }
        return $value;
    }
    public static function remove($key,Update $update){
        $user = $update->callback_query->from ?? $update->my_chat_member->from ?? $update->message->from;
        $row = openSessions::where("client_id",$user->id)->where("key",$key)->first();
        if($row){
            $row->delete();
        }
    }
}