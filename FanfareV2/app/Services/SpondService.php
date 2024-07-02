<?php
namespace App\Services;

use App\Exceptions\EventAlreadyPresent;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use DateTime;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\isTrue;
use Carbon\Carbon;

// class that is responsible for interacting with the SpondApi
class SpondService{
    protected $apiPath;
    protected $data;

    // function that is called when SpondService is created
    public function __construct($apiPath){
        $this->apiPath = $apiPath;
        Log::debug("SpondService is created");
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
            Log::debug("Error in json");
            return false;
        }

        // Handle the events as needed
        if ($events) {
            return $events;
        } else {
            echo "Failed to retrieve events.\n";
            echo "Output:\n" . $output . "\n"; // Log the full output for debugging
            Log::debug("Error in events, it is empty");
            return false;
        }
    }


    // updates the oldEvent in the database with data from the new event.
    private function update($oldEvent,$newEvent){

        $oldEvent->title=$newEvent['title'];
        $oldEvent->description=$newEvent['description'];
        $oldEvent->date=$newEvent['date'];
        $oldEvent->start_time=$newEvent['startTime'];
        $oldEvent->end_time=$newEvent['endTime'];
        $oldEvent->location=$newEvent['location'];
        $oldEvent->save();
        print('Update');

    }


    // looks at the date of the already existing event
    // and deletes it if it's in the past
    private function checkDelete($event){
        // Parse the event date
        $eventDate = Carbon::parse($event->date);

        // Check if the event date is in the past
        if ($eventDate->isPast()) {
            // Delete the event if the date is in the past
            $event->delete();
            return false;
        }
        return true;
    }


    // function that checks if there is another event with the same name and date in the data base, if so it will update that event and return false, if there isn't it will return true
    private function checkForDoubleEvent($event){
        $existingEvent = Event::where('title', $event['title'])
                              ->first();
        // echo $event['title'];
        // echo $event['date'];
        // echo $existingEvent->title;
        // echo $existingEvent->date;
        if(!is_Null($existingEvent)) {
            $allowed=self::checkDelete($existingEvent);
            if($allowed)
                self::update($existingEvent,$event);
            return false;
        }else{
            return true;
        }
    }


    // function that validates an event, it checks if there is another event with the same name and date in the database by calling the checkForDoubleEvent function
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
        $adjustedTime = $time->format('H:i:s');

        // Combine the adjusted date and time parts back
        $adjustedDateTime = [$datePart,$adjustedTime];

        return $adjustedDateTime;
    }


    private function checkEvents(){
        $events = self::apiCall();
        if (!$events) {
            return [];
        }
        $eventArray = [];
        foreach ($events as $event) {
            // formatting date and start date
            $start = self::dateSplitter($event['start']);
            $end = self::dateSplitter($event['end']);
            $date = $start[0];
            $startTime = $start[1];
            $endTime = $end[1];

            // making the event
            $e['title'] = $event['title'];
            $e['description'] = isset($event['description']) ? $event['description'] : '';
            $e['date'] = $date;
            $e['startTime'] = $startTime;
            $e['endTime'] = $endTime;
            $e['location'] = $event['location'];

            // checking the name and date for duplicates & updating if there are
            $allowed = self::validateEvent($e);
            if ($allowed) {
                $eventArray[] = $e;
            }
        }
        echo count($eventArray);
        return $eventArray;
    }

    public function run(){
        $events = self::checkEvents();
        foreach ($events as $e) {
            $event = new Event();
            $event->title = $e['title'];
            $event->description = $e['description'];
            $event->date = $e['date'];
            $event->start_time = $e['startTime'];
            $event->end_time = $e['endTime'];
            $event->location = $e['location'];
            $event->save();
        }
    }
}

// $a=new SpondService('Spond_api.py');
// $a->run();
