<?php

$json_string = '
{
    "0": {
        "title": "Kermisconcert Borcht",
        "start": "2024-08-11T09:00:00Z",
        "end": "2024-08-11T10:00:00Z",
        "location": "Parking sporthal Borcht"
    },
    "1": {
        "title": "Zomerconcert",
        "start": "2024-06-30T09:00:00Z",
        "end": "2024-06-30T10:00:00Z",
        "location": "Kerkplein"
    }
}
';

$json_obj = json_decode($json_string, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Failed to decode JSON: ' . json_last_error_msg() . "\n";
    exit;
}
print_r($json_obj);
