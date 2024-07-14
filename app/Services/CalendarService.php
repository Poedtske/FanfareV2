<?php

namespace App\Services;
// use Symfony\Component\Process
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Logging\EventLogger;

class CalendarService {

    public static function create($event) {
        $event = [
            "title" => $event->title,
            "date" => $event->date,
            "description" => $event->description,
            "start_time" => $event->start_time,
            "end_time" => $event->end_time,
            "location" => $event->location,
            "calendar_id" => null,
        ];
        // EventLogger::spondError("event ",$event);

        // print(self::writeJson("create", $event));
        self::writeJson("create", $event);

        sleep(5);

        return self::apiCall();
    }

    public static function update($e) {
        EventLogger::spondError("event ",$e);

        $event = [
            "title" => $e->title,
            "date" => $e->date,
            "description" => $e->description,
            "start_time" => $e->start_time,
            "end_time" => $e->end_time,
            "location" => $e->location,
            "calendar_id" => $e->calendar_id,
        ];
        EventLogger::spondError("event ",$event);
        self::writeJson("update", $event);
        sleep(5);
        self::apiCall();
    }

    public static function delete($e) {

        $event = [
            "title" => $e->title,
            "date" => $e->date,
            "description" => $e->description,
            "start_time" => $e->start_time,
            "end_time" => $e->end_time,
            "location" => $e->location,
            "calendar_id" => $e->calendar_id,
        ];
        self::writeJson("delete", $event);
        sleep(5);
        self::apiCall();
    }

    protected static function writeJson($action, $eventData)
    {
        $filePath='Calendar.json';
        // Prepare JSON data to send to Python script
        $jsonData = json_encode([
            'action' => $action,
            'event' => $eventData,
        ]);

        // Open the file in append mode
        $file = fopen($filePath, 'a');
        if ($file) {
            // Write the JSON data to the file followed by a newline character
            if (fwrite($file, $jsonData . "\n") === false) {
                echo "Error writing to file";
            } else {
                echo "File written successfully";
            }
            // Close the file
            fclose($file);
        } else {
            echo "Error opening file";
        }
    }
    private static function apiCall(){
        // Execute the Python script and capture the output, including any errors
        $output = shell_exec('python ' . escapeshellarg('../Calendar_api.py') . ' 2>&1');

        // Ensure the output is interpreted as UTF-8
        $output = mb_convert_encoding($output, 'UTF-8', 'auto');

        // Decode the JSON output from the Python script
        EventLogger::spondError("TEST ",$output);
        $calendarId = json_decode($output, true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "ERROR: Failed to decode JSON: " . json_last_error_msg() . "\n";
            echo "Output:\n" . $output . "\n"; // Provide full output for debugging
            EventLogger::spondError("ERROR: Failed to decode JSON: ",json_last_error_msg());

            return false;
        }

        // Handle the events as needed
        if ($calendarId) {
            return $calendarId;
        } else {
            echo "Failed to retrieve events.\n";
            echo "Output:\n" . $output . "\n"; // Log the full output for debugging
            EventLogger::spondError("ERROR: Failed to retrieve events: ",$output);
            return false;
        }
    }
}

// $µ=new CalendarService();
// $µ->create('gi');
