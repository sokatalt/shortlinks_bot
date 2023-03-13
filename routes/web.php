<?php

use App\Http\Controllers\ApiManager;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ReportController;
use App\Models\apiCampaigns;
use App\Models\Client;
use AshAllenDesign\ShortURL\Controllers\ShortURLController;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('form/{shortURLKey}',function($shortURLKey){
    $url =ShortURL::where('url_key',$shortURLKey)->first();
    $details = ShortURL::where('url_key',$shortURLKey)->first();
    $user = Client::find($details->user_id);
    if($user->is_enabled){
        $chack_campain = apiCampaigns::where("Campaign_number",$details->compain_id)->where("user_id",$details->user_id)->first();
        if($chack_campain->is_disabled == false){
            switch($details->compain_id){
                case 1 :
                    return view('formpage',get_defined_vars());
                case 2 :
                    return view('formpage2',get_defined_vars());
                case 3 :
                    return view('formpage3',get_defined_vars());
            }
        }else{
            return redirect()->to(config("settings.disable_destination"));
        }
    }else{
        return redirect()->to(config("settings.disable_user_destination"));
    }
});
Route::get('myleads/{login_token}',[LeadController::class,'index']);
Route::get('deleteleads',[LeadController::class,'deleteleads']);
Route::get('report',[ReportController::class,'index']);
Route::get('/{shortURLKey}', ShortURLController::class);

Route::get(config('short-url.prefix').'/{shortURLKey}', function($shortURLKey){
    $details = ShortURL::findByKey($shortURLKey);
    $user = Client::find($details->user_id);
    if($user->is_enabled){
        $chack_campain = apiCampaigns::where("Campaign_number",$details->compain_id)->where("user_id",$details->user_id)->first();
        $Campaign_id = ApiManager::getCampaignId($details->compain_id,$details->user_id);
        if($chack_campain->is_disabled == false){
            $shortURLKey =ShortURL::where('user_id',$details->user_id)->where('compain_id',$details->compain_id)->get()->last();
            ApiManager::ChangeCampaignLink($Campaign_id,url('form/'.$shortURLKey->url_key),11);
            $url = ApiManager::getCampaignLink($Campaign_id);
            return view('loading',['url'=>$url,'url2'=>$details->destination_url]);
        }else{
            $shortURLKey = ShortURL::where('user_id',$details->user_id)->where('compain_id',$details->compain_id)->get()->last();
            ApiManager::ChangeCampaignLink($Campaign_id,config("settings.disable_destination"),11);
            $url = ApiManager::getCampaignLink($Campaign_id);
            return view('loading',['url'=>$url,'url2'=>$shortURLKey->url_key]);
        }
    }else{
        return redirect()->to(config("settings.disable_user_destination"));
    }
});
Route::get('redirectpage/{shortURLKey}', function($shortURLKey){
    return view('redirectpage',['url'=>$shortURLKey]);
});
Route::post('addlead',[LeadController::class,'create']);