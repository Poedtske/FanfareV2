<?php

namespace App\Services;
// use Symfony\Component\Process
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Logging\EventLogger;

class CalendarService {

    public static function create($event) {
        $description=empty($event->description) ? "null" : "*{$event->description}*";
        $json = "{*action*:*create*,*event*:{*title*:*{$event->title}*,*date*:*{$event->date}*,*description*:{$description},*start_time*:*{$event->start_time}*,*end_time*:*{$event->end_time}*,*location*:*{$event->location}*}}";
        EventLogger::spondError("event ",$json);
        $jsonEscaped = escapeshellarg($json); // Escape the JSON argument
        EventLogger::spondError("event escaped",$jsonEscaped);
        $output =shell_exec("python ../Calendar_api.py $jsonEscaped"); // Use shell_exec to capture output
        EventLogger::spondError("output",$output);
        return trim($output);
    }

    public static function update($event) {
        $description=empty($event->description) ? "null" : "*{$event->description}*";
        $json = "{*action*:*create*,*event*:{*title*:*{$event->title}*,*date*:*{$event->date}*,*description*:{$description},*start_time*:*{$event->start_time}*,*end_time*:*{$event->end_time}*,*location*:*$event->location*,*calendar_id*:*{$event->calendar_id}*}}";
        $json = "{*action*:*update*,*event*:{*title*:*{$event->title}*,*date*:*{$event->date}*,*description*:{$description},*start_time*:*{$event->start_time}*,*end_time*:*{$event->end_time}*,*location*:*$event->location*,*calendar_id*:*{$event->calendar_id}*}}";
        EventLogger::spondError("event ",$json);
        $jsonEscaped = escapeshellarg($json); // Escape the JSON argument
        EventLogger::spondError("event escaped",$jsonEscaped);
        $output =shell_exec("python ../Calendar_api.py $jsonEscaped"); // Use shell_exec to capture output
        EventLogger::spondError("output",$output);
    }

    public static function delete($event) {
        $json = "{*action*:*delete*,*event*:{*calendar_id*:*{$event->calendar_id}*}}";
        EventLogger::spondError("event ",$json);
        $jsonEscaped = escapeshellarg($json); // Escape the JSON argument
        EventLogger::spondError("event escaped",$jsonEscaped);
        $output =shell_exec("python ../Calendar_api.py $jsonEscaped"); // Use shell_exec to capture output
        EventLogger::spondError("output",$output);
    }
}
