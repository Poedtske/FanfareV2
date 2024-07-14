<?php
use App\Services\CalendarService;

require __DIR__ . '/vendor/autoload.php';


$event = [
            "title" => "Lincoln",
            "date" => "2025-11-11",
            "description" => null,
            "start_time" => "10:20",
            "end_time" => "20:30",
            "location" => "BEIGEM",
            "calendar_id" => null,
            "updated_at" => "2024-07-12T13:45:33.000000Z",
            "created_at" => "2024-07-12T13:45:33.000000Z",
            "id" => 3
        ];
$a=new CalendarService();
print($a->create($event));
// $json_string = '
// {
//     "0": {
//         "title": "Kermisconcert Borcht",
//         "start": "2024-08-11T09:00:00Z",
//         "end": "2024-08-11T10:00:00Z",
//         "location": "Parking sporthal Borcht"
//     },
//     "1": {
//         "title": "Zomerconcert",
//         "start": "2024-06-30T09:00:00Z",
//         "end": "2024-06-30T10:00:00Z",
//         "location": "Kerkplein"
//     }
// }
// ';

// $json_obj = json_decode($json_string, true);

// if (json_last_error() !== JSON_ERROR_NONE) {
//     echo 'Failed to decode JSON: ' . json_last_error_msg() . "\n";
//     exit;
// }
// print_r($json_obj);
