<?php
namespace App\Services;

use App\Exceptions\EventAlreadyPresent;
use App\Models\Event;
use App\Logging\EventLogger;

use DateTime;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\isTrue;


// class that is responsible for interacting with the SpondApi
class SpondService{
    protected $apiPath;
    protected $data;

    // function that is called when SpondService is created
    public function __construct($apiPath){
        $this->apiPath = $apiPath;
        print('SpondService is created');
    }

    // calls the apiCall function written in pyton
    // converts the string into json
    // returns an array with events
    private function apiCall(){
        // Execute the Python script and capture the output, including any errors
        $output = shell_exec('python ' . escapeshellarg($this->apiPath) . ' 2>&1');

        // Ensure the output is interpreted as UTF-8
        $output = mb_convert_encoding($output, 'UTF-8', 'auto');

        // Decode the JSON output from the Python script
        $events = json_decode($output, true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "ERROR: Failed to decode JSON: " . json_last_error_msg() . "\n";
            echo "Output:\n" . $output . "\n"; // Provide full output for debugging
            EventLogger::spondError("ERROR: Failed to decode JSON: ",json_last_error_msg());
            return false;
        }

        // Handle the events as needed
        if ($events) {
            return $events;
        } else {
            echo "Failed to retrieve events.\n";
            echo "Output:\n" . $output . "\n"; // Log the full output for debugging
            EventLogger::spondError("ERROR: Failed to retrieve events: ",$output);
            return false;
        }
    }


    // updates the oldEvent in the database with data from the new event.
    private function update($oldEvent, $newEvent)
    {
        $changedFields = [];

        if ($oldEvent->title !== $newEvent['title']) {
            $changedFields['title'] = ['old' => $oldEvent->title, 'new' => $newEvent['title']];
            $oldEvent->title = $newEvent['title'];
        }
        if ($oldEvent->description !== $newEvent['description']) {
            $changedFields['description'] = ['old' => $oldEvent->description, 'new' => $newEvent['description']];
            $oldEvent->description = $newEvent['description'];
        }
        if ($oldEvent->date !== $newEvent['date']) {
            $changedFields['date'] = ['old' => $oldEvent->date, 'new' => $newEvent['date']];
            $oldEvent->date = $newEvent['date'];
        }
        if ($oldEvent->start_time !== $newEvent['startTime']) {
            $changedFields['start_time'] = ['old' => $oldEvent->start_time, 'new' => $newEvent['startTime']];
            $oldEvent->start_time = $newEvent['startTime'];
        }
        if ($oldEvent->end_time !== $newEvent['endTime']) {
            $changedFields['end_time'] = ['old' => $oldEvent->end_time, 'new' => $newEvent['endTime']];
            $oldEvent->end_time = $newEvent['endTime'];
        }
        if ($oldEvent->location !== $newEvent['location']) {
            $changedFields['location'] = ['old' => $oldEvent->location, 'new' => $newEvent['location']];
            $oldEvent->location = $newEvent['location'];
        }

        if (!empty($changedFields)) {
            $oldEvent->save();

            // Log the changes
            $changes = json_encode($changedFields, JSON_PRETTY_PRINT);
            EventLogger::spondUpdate($oldEvent,$changes);
        }
    }



    // looks at the date of the already existing event
    // and deletes it if it's in the past
    private function checkDelete($event){
        // Parse the event date
        $eventDate = Carbon::parse($event->date);

        $tempEvent=$event;

        // Check if the event date is in the past
        if ($eventDate->isPast()) {
            // Delete the event if the date is in the past
            $tempEvent=$event;
            if($event->poster){
                $path = str_replace('/storage/', '', $event->poster);
                // Check if the file exists and delete it
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            $event->delete();
            EventLogger::spondDelete($tempEvent,"Spond");

            return false;
        }
        return true;
    }


    // function that checks if there is another event with the same spond_id in the data base, if so it will update that event and return false, if there isn't it will return true
    private function checkForDoubleEvent($event){
        $existingEvent = Event::where('spond_id', $event['spond_id'])
                              ->first();

        if(!is_Null($existingEvent)) {
            $allowed=self::checkDelete($existingEvent);
            if($allowed)
                self::update($existingEvent,$event);
            return false;
        }else{
            return true;
        }
    }


    // function that validates an event, it checks if there is another event with the same spond_id in the database by calling the checkForDoubleEvent function
    // if there is one, it will update that event and return false, if there isn't one it will return true and the event will be created.
    private function validateEvent($event){
        $validate=self::checkForDoubleEvent($event);
        return $validate ? true : false;
    }

    private function dateSplitter($date){
        // Remove the 'Z' character and split by 'T'
        $dateParts = explode('T', str_replace('Z', '', $date));

        // Separate date and time parts
        $datePart = $dateParts[0]; // Date part (e.g., 2024-06-30)
        $timePart = $dateParts[1]; // Time part (e.g., 09:00:00)

        // Create a DateTime object from the time part
        $time = new DateTime($timePart);

        // Add 2 hours to the DateTime object
        $time->modify('+2 hours');

        // Format the time part to 'H:i:s' (hours, minutes, seconds)
        $adjustedTime = $time->format('H:i');

        // Combine the adjusted date and time parts back
        $adjustedDateTime = [$datePart,$adjustedTime];

        return $dateParts;
    }


    private function checkEvents(){
        $spondEvents = self::apiCall();
        if (!$spondEvents) {
            return [];
        }
        $eventArray = [];
        foreach ($spondEvents as $spondEvent) {
            // formatting date and start date
            $start = self::dateSplitter($spondEvent['start']);
            $end = self::dateSplitter($spondEvent['end']);
            $date = $start[0];
            $startTime = $start[1];
            $endTime = $end[1];

            // making the event
            $e['spond_id']=$spondEvent['ID'];
            $e['title'] = $spondEvent['title'];
            $e['description'] = isset($spondEvent['description']) ? $spondEvent['description'] : '';
            $e['date'] = $date;
            $e['startTime'] = $startTime;
            $e['endTime'] = $endTime;
            $e['location'] = $spondEvent['location'];

            // checking the name and date for duplicates & updating if there are
            $allowed = self::validateEvent($e);
            if ($allowed) {
                $eventArray[] = $e;
            }
        }
        echo count($eventArray);
        return $eventArray;
    }

    private function deleteEvents()
    {
        $events = Event::all();
        foreach ($events as $event) {
            $eventDate = Carbon::parse($event->date);
            $updatedAt = Carbon::parse($event->updated_at);

            // Check if the event date is in the past or if the event has a SpondId and hasn't been updated today
            if ($eventDate->isPast() || ($event->SpondId && !$updatedAt->isToday())) {
                // Delete the event if the date is in the past or it hasn't been updated today
                $tempEvent = $event;
                if ($event->poster) {
                    $path = str_replace('/storage/', '', $event->poster);
                    // Check if the file exists and delete it
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
                $event->delete();
                EventLogger::spondDelete($tempEvent,"Autocheck");
            }
        }
    }


    public function run(){
        $events = self::checkEvents();
        foreach ($events as $e) {
            $event = new Event();
            $event->spond_id=$e['spond_id'];
            $event->title = $e['title'];
            $event->description = $e['description'];
            $event->date = $e['date'];
            $event->start_time = $e['startTime'];
            $event->end_time = $e['endTime'];
            $event->location = $e['location'];
            $event->save();
            EventLogger::spondCreate($event);
        }
        self::deleteEvents();
    }
}
