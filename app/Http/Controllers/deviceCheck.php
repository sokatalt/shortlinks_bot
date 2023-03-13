<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Jenssegers\Agent\Agent as AgentAgent;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;


class deviceCheck extends Controller
{
    public function index(){

     return    Lead::get();
        // User::create([
        //     'name'=>'admin',
        //     'email'=>'Hdhajgshsj@gmail.com',
        //     'password'=>Hash::make('2000@@Soka'),
        //     'is_admin'=>'1'

        // ]);

        return  Str::uuid()->toString();
        // $device = Agent::isPhone();
        $mykey= config('settings.BotRedirectUrl');
dd($mykey);
                $device = new AgentAgent();

        dd($device->platform());
    
       }
       public function test2(){
        

    //   if ( $device->isDesktop()){
    //     return "hellooooooooooooooooooooooo";
    //   }else{

    //   }

    return "hello";
       }
}
