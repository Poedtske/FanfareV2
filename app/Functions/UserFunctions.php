<?php
namespace App\Functions;


use Illuminate\Support\Facades\Log;

class UserFunctions{

    public static function log($message,$user){
        Log::channel('user')->info($message,[
            'email'=>$user->email,
            'id'=>$user->id
            ]);
    }
    public static function warning($message,$email){
        Log::channel('user')->warning($message,[
            'email'=>$email,
            ]);
    }
}
