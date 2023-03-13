<?php

namespace App\Http\Controllers;

use App\Models\apiCampaigns;

class ApiManager extends Controller
{
    public static function sendCurlJson(array $data){
        $url = config("settings.Binom_url");
        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $postdata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = json_decode(curl_exec($ch));
        curl_close($ch);
        return $res;
    }
    private static function AddCampaignData($campaign_id,$user_id,$number){
        $apiInfo = new apiCampaigns;
        $apiInfo->user_id = $user_id;
        $apiInfo->Campaign_id = $campaign_id;
        $apiInfo->Campaign_number = $number;
        $apiInfo->save();
    }
    public static function CreateCampaign($client_id,$user_id,$numberOfDomains){
        $apiKey = config("settings.Binom_apiKey");
        $addGroup = [
            "api_key" => $apiKey,
            "action" => "group@add",
            "payload" => [
                "name" => $client_id." Campaign Group",
                "type" => "CAMPAIGN",
            ],
        ];
        $GroupId = self::sendCurlJson($addGroup)->{"id"};
        $numOfCampain = 3;
        $randomDomain = rand(1,$numberOfDomains);
        for($i=0; $i != $numOfCampain;$i++){   
            $apiData = [
                "api_key" => $apiKey,
                "action" => "campaign@add",
                "payload" => [
                    "name" => $client_id,
                    "sources_id" => config("settings.Traffic_SourceID"),
                    "group_id" => $GroupId,
                    "domain" => $randomDomain,
                    "routing" => [
                        "paths" => [
                            [
                                "name" => "PATH",
                                "split" => 222,
                                "landings" => [
                                    ["type" => "DIRECT", "split" => 333, "number" => 1],
                                ],
                                "offers" => [
                                    [
                                        "type" => "OFFER_DIRECT_URL",
                                        "split" => 666,
                                        "number" => 1,
                                        "url" => "http://noUrl",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
            $res = self::sendCurlJson($apiData);      
            self::AddCampaignData($res->{"id"},$user_id,$i+1);
        }
    }
    public static function ChangeCampaignLink($campaign_id,$Link,$numberOfDomains){
        $apiKey = config("settings.Binom_apiKey");
        $randomDomain = rand(1,$numberOfDomains);
        $apiData = [
            "api_key" => $apiKey,
            "action" => "campaign@edit",
            "payload" => [
                "id" => $campaign_id,
                "domain" => $randomDomain, 
                "routing" => [
                    "paths" => [
                        [
                            "name" => "PATH",
                            "split" => 222,
                            "landings" => [
                                ["type" => "DIRECT", "split" => 333, "number" => 1],
                            ],
                            "offers" => [
                                [
                                    "type" => "OFFER_DIRECT_URL",
                                    "split" => 666,
                                    "number" => 1,
                                    "url" => $Link,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $res = self::sendCurlJson($apiData);
        return $res;
    }
    public static function getCampaignLink($campaign_id){
        $url = config("settings.Binom_url");
        $apiKey = config("settings.Binom_apiKey");
        $ch = curl_init($url."?api_key=".$apiKey."&action=campaign@get&id=".$campaign_id); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = json_decode(curl_exec($ch));
        curl_close($ch);
        return $res->{"url"};
    }
    public static function getGroupId($user_id){
        $url = config("settings.Binom_url");
        $apiKey = config("settings.Binom_apiKey");
        $campaign_id = self::getCampaignId(1,$user_id);
        $ch = curl_init($url."?api_key=".$apiKey."&action=campaign@get&id=".$campaign_id); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = json_decode(curl_exec($ch));
        curl_close($ch);
        return $res->{"group_id"};
    }
    public static function getReport($user_id,$date){
        $url = config("settings.Binom_url2");
        $apiKey = config("settings.Binom_apiKey");
        $group_id = self::getGroupId($user_id);
        $ch = curl_init("$url?page=Campaigns&status=1&group=$group_id&traffic_source=all&date=$date&timezone=+2:00&api_key=$apiKey"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = json_decode(curl_exec($ch));
        curl_close($ch);
        return $res;
    }
    public static function getCampaignId($campain_id,$user_id){
        $CampaignsInfo = apiCampaigns::where("user_id",$user_id)
        ->where("Campaign_number",$campain_id)->first();
        return $CampaignsInfo->Campaign_id;
    }
}

