<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\users_wait_approve;
use Illuminate\Http\Request;

class approveController extends Controller
{
    public static function askApprove($user,$chat_id){
        $is_exist = users_wait_approve::firstWhere("user_id",$user->id);
        $user = Client::find($user->id);
        if($is_exist || $user->is_approved == true){
            return false;
        }else{
            $usersWait = new users_wait_approve;
            $usersWait->user_id = $user->id;
            $usersWait->client_id  = $user->client_id;
            $usersWait->first_name  = $user->first_name;
            $usersWait->last_name  = $user->last_name;
            $usersWait->username  = $user->username;
            $usersWait->chat_id  = $chat_id;
            $result = $usersWait->save();
            return $result;
        }
    }
    public static function getWaitingUsers(){
        $usersWait = users_wait_approve::all();
        return $usersWait;
    }
    public static function giveApprove($user_id){
        $user = Client::find($user_id);
        if($user && $user->is_approved == false){
            $chat_id = "";
            $userWait = users_wait_approve::firstWhere("user_id",$user->id);
            $chat_id = $userWait->chat_id;
            $user->is_approved = true;
            $result = $user->save();
            if($result){
                $userWait->delete();
                return $chat_id;
            }else{
                return false;
            }
        }
    }
    public static function rejectApprove($user_id){
        $user = Client::find($user_id);
        if($user && $user->is_approved == false){
            $userWait = users_wait_approve::find($user->id);
            $delRes = $userWait->delete();
            return $delRes;
        }
    }
}
