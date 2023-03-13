<?php

namespace App\Http\Controllers;

use App\Models\apiCampaigns;
use Illuminate\Http\Request;

class toggleForm extends Controller
{
    public static function disable($user_id,$campin_number){
        $campain = apiCampaigns::where("user_id",$user_id)->where("Campaign_number",$campin_number)->first();
        $campain->is_disabled = true;
        $campain->save();
    }
    public static function enable($user_id,$campain_number){
        $campain = apiCampaigns::where("user_id",$user_id)->where("Campaign_number",$campain_number)->first();
        $campain->is_disabled = false;
        $campain->save();
    }
    public static function getState($user_id,$campain_number) : bool
    {
        $campain = apiCampaigns::where("user_id",$user_id)->where("Campaign_number",$campain_number)->first();
        return $campain->is_disabled;
    }
    public static function toggle($user_id,$campain_number){
        $state = self::getState($user_id,$campain_number);
        if($state){
            self::enable($user_id,$campain_number);
        }else{
            self::disable($user_id,$campain_number);
        }
    }
}
