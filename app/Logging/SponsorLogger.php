<?php
namespace App\Logging;
use Illuminate\Support\Facades\Log;

class SponsorLogger{
    public static function create($sponsor,$user,$ip){
        $message="Sponsor {$sponsor->title} has been created: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('sponsor')->info($message,[
            'sponsor'=>$sponsor
            ]);
    }

    public static function update($sponsor,$difference,$user,$ip){
        $message="Sponsor {$sponsor->title} has been updated: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('sponsor')->info($message,[
            'update'=>$difference,
            ]);
    }

    public static function delete($sponsor,$user,$ip){
        $message="Sponsor {$sponsor->title} has been deleted: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('sponsor')->info($message,[
            'sponsor'=>$sponsor
            ]);
    }

    public static function changeState($sponsor,$user,$state,$ip){
        $message="Sponsor {$sponsor->title} has been {$state}: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('sponsor')->info($message,[
            'sponsor'=>$sponsor
            ]);
    }
}
