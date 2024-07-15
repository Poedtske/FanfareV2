<?php
namespace App\Logging;
use Illuminate\Support\Facades\Log;

class EventLogger{
    public static function create($event,$user,$ip){
        $message="Event {$event->title} has been created: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('event')->info($message,[
            'event'=>$event
            ]);
    }

    public static function update($event,$difference,$user,$ip){
        $message="Event {$event->title} has been updated: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('event')->info($message,[
            'update'=>$difference,
            ]);
    }

    public static function delete($event,$user,$ip){
        $message="Event {$event->title} has been deleted: \nUser who did action: \nip: {$ip} \nusername: {$user->name}\nid: {$user->id}\nContext:";
        Log::channel('event')->info($message,[
            'event'=>$event
            ]);
    }

    public static function spondCreate($event){
        $message="Event {$event->title} has been created by Spond\nContext:";
        Log::channel('event')->info($message,[
            'event'=>$event
            ]);
    }

    public static function spondUpdate($event,$difference){
        $message="Event {$event->title} has been updated by Spond\nContext:";
        Log::channel('event')->info($message,[
            'update'=>$difference,
            ]);
    }

    public static function spondDelete($event,$actor){
        $message="Event {$event->title} has been deleted by {$actor}\nContext:";
        Log::channel('event')->info($message,[
            'event'=>$event
            ]);
    }

    public static function spondError($message,$object){
        Log::channel('sponderrors')->warning($message,[
            'object'=>$object
            ]);
    }

    public static function calendarCreate($json,$title){
        $message="Calendar Event {$title} has been created\nContext:";
        Log::channel('event')->info($message,[
            'json'=>$json
            ]);
    }

    public static function calendarUpdate($json,$title){
        $message="Calendar Event {$title} has been updated\nContext:";
        Log::channel('event')->info($message,[
            'json'=>$json,
            ]);
    }

    public static function calendarDelete($json,$title){
        $message="Calendar Event {$title} has been deleted\nContext:";
        Log::channel('event')->info($message,[
            'json'=>$json
            ]);
    }

    public static function calendarError($message,$json){
        Log::channel('api_errors')->warning($message,[
            'json'=>$json,
            ]);
    }
}
