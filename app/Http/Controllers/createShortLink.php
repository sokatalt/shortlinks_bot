<?php

namespace App\Http\Controllers;

use App\Models\UserShortUrl;
use AshAllenDesign\ShortURL\Facades\ShortURL;


class createShortLink extends Controller
{
    public static function index($url,$compain_id,$user_id){
        $res=[];
    if(str_starts_with($url,'https://')){
        $res[] =$url;
    }elseif(str_starts_with($url,'http://')){
    $res[] =str_replace('http://','https://',$url);;

    }elseif(str_starts_with($url,'www')){
        $res[] ='https://'.$url;
      }else{
        $res[] ='https://'.$url;
      }
    //   $customkey= config('settings.Url_key_prefix');
        $mykey=base64_encode($res[0]);
        $shortURLObject = ShortURL::destinationUrl($res[0])->make();
        
        $shortURLObject->compain_id = $compain_id;
        $shortURLObject->save();
        $shortURLObject->user_id =$user_id;
        $shortURLObject->save();
       
            $shortURL = $shortURLObject->default_short_url;
            $destination = $shortURLObject->destination_url;
            $usershorturl=
            UserShortUrl::create([
                'user_id'=>$user_id,
                'short_url_id'=> $shortURLObject->id,
                'user_compain_id'=>$compain_id
            ]);
            return[0=>$shortURL,1=>$destination];
    }
}
