<?php
namespace App\Services;

use App\Models\Sponsor;
use Illuminate\Support\Facades\Storage;

class SponsorsService
{
    protected $sponsors;

    public function __construct()
    {
        $jsonFilePath = 'Sponsor.json'; // Ensure the path to the JSON file is correct

        // Step 1: Read the JSON file into a string
        $jsonString = file_get_contents($jsonFilePath);

        // Check if the file was read successfully
        if ($jsonString === false) {
            die('Error: Unable to read the JSON file.');
        }

        // Step 2: Decode the JSON string into a PHP array
        $this->sponsors = json_decode($jsonString, true);

        // Check if the JSON was decoded successfully
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error: Invalid JSON format. Error - ' . json_last_error_msg());
        }
    }

    private function checkForDoubleSponsor($sponsor)
    {
        $existingSponsor = Sponsor::where('title', $sponsor['naam'])->first();
        return is_null($existingSponsor);
    }

    private function addSponsors()
    {
        foreach ($this->sponsors as $s) {
            if ($this->checkForDoubleSponsor($s)) {
                $sponsor = new Sponsor();
                $sponsor->title = $s["naam"];

                // Check if the logo file exists in the specified directory
                if (Storage::disk('public')->exists('images/sponsorLogos/' . $s["logo"])) {
                    $sponsor->logo = '/storage/images/sponsorLogos/' . $s["logo"];
                } else {
                    // If the logo doesn't exist, try to copy it from the source directory
                    $sourcePath = public_path('images/logos/sponsors/' . $s["logo"]);
                    if (file_exists($sourcePath)) {
                        $fileContents = file_get_contents($sourcePath);
                        $filePath = 'images/sponsorLogos/' . $s["logo"];
                        Storage::disk('public')->put($filePath, $fileContents);
                        $sponsor->logo = '/storage/'.$filePath;
                    } else {
                        $sponsor->logo = 'error, logo file not found';
                    }
                }

                $sponsor->url = $s["link"];
                $sponsor->description = null;
                $sponsor->rank = $s["rang"];
                $sponsor->sponsored = $s["geld"];
                $sponsor->user_id = 1; // Assign a default user ID or adjust as necessary
                $sponsor->save();
            }
        }
    }

    public function run()
    {
        $this->addSponsors();
    }
}

