<?php

// Execute the Python script and capture the output including any errors
$output = shell_exec('python Spond_api.py 2>&1');

// Decode the JSON output from the Python script
$events = json_decode($output, true);

// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Failed to decode JSON: ' . json_last_error_msg() . "\n";
    echo "Output:\n" . $output . "\n"; // Provide full output for debugging
    exit;
}

if (is_array($events)) {
    foreach ($events as $event) {
        echo "Event: " . $event['title'] . " on " . $event['start'] . "\n";
    }
} else {
    echo 'Failed to retrieve events.' . "\n";
    echo "Output:\n" . $output . "\n"; // Log the full output for debugging
}
?>
