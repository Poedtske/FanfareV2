<?php
namespace App\Functions;

use Illuminate\Support\Facades\Log;
use App\Models\Sponsor;



// function crudLogger($object,$user){
//     Log::channel('crud')->info('Event deleted',[
//         'user_id'=>$user->id,
//         'user_name'=>$user->name,
//         'event'=>$object
//         ]);
// }

// function camelcaseTransformer($name){
//     // Remove special characters, replace spaces with underscores, and convert to lowercase
//     $name=explode('.',$name);
//     $extension=$name[1];
//     $name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $name[0]));

//     // Split the string by underscores or spaces
//     $words = preg_split('/[_\s]/', $name, -1, PREG_SPLIT_NO_EMPTY);

//     // Capitalize the first letter of each word except the first one
//     $camelCaseName = '';
//     foreach ($words as $key => $word) {
//         if ($key === 0) {
//             // Keep the first word lowercase
//             $camelCaseName .= $word;
//         } else {
//             // Capitalize subsequent words
//             $camelCaseName .= ucfirst($word);
//         }
//     }

//     return $camelCaseName.'.'.$extension;
// }

// function rankFilter($sponsor) {
//     $number = $sponsor->sponsored;

//     // Retrieve the current sponsor with rank 1
//     $hoofdSponsor = Sponsor::where('rank', 1)->first();

//     // If there's no sponsor with rank 1, this means we can proceed without demotion
//     if ($hoofdSponsor === null) {
//         $sponsor->rank = 1;
//         $sponsor->save();
//         return 1;
//     }

//     // If the sponsor has the highest 'sponsored' value
//     if ($number > $hoofdSponsor->sponsored) {
//         // Demote the current rank 1 sponsor to rank 2 if it's not the same sponsor
//         if ($sponsor->id != $hoofdSponsor->id) {
//             $hoofdSponsor->rank = 2;
//             $hoofdSponsor->save();
//         }

//         // Promote the new sponsor to rank 1
//         $sponsor->rank = 1;
//         $sponsor->save();
//         return 1;
//     } else {
//         // If the sponsor doesn't have the highest value, rank accordingly
//         if ($number < 50) {
//             return 4;
//         } elseif ($number < 100) {
//             return 3;
//         } elseif ($number < $hoofdSponsor->sponsored) {
//             return 2;
//         } else {
//             // Default case should not happen because it covers all possibilities
//             return 1;
//         }
//     }
// }

// function firstRankChecker() {
//     // Retrieve the current sponsor with rank 1
//     $hoofdSponsor = Sponsor::where('rank', 1)->first();

//     // Retrieve the sponsor with the highest 'sponsored' value
//     $highestSponsored = Sponsor::orderBy('sponsored', 'desc')->first();

//     // Check if there is a sponsor with rank 1 and if the highest sponsored sponsor should be promoted
//     if ($hoofdSponsor && $highestSponsored && $highestSponsored->sponsored > $hoofdSponsor->sponsored) {
//         // Demote the current rank 1 sponsor to rank 2
//         $hoofdSponsor->rank = 2;
//         $hoofdSponsor->save();

//         // Promote the sponsor with the highest sponsored value to rank 1
//         $highestSponsored->rank = 1;
//         $highestSponsored->save();
//     } elseif ($highestSponsored && !$hoofdSponsor) {
//         // If there is no sponsor currently with rank 1, promote the highest sponsored sponsor
//         $highestSponsored->rank = 1;
//         $highestSponsored->save();
//     }
// }


class CrudFunctions{

    public static function camelcaseTransformer($name){
        // Remove special characters, replace spaces with underscores, and convert to lowercase
        $name=explode('.',$name);
        $extension=$name[1];
        $name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $name[0]));

        // Split the string by underscores or spaces
        $words = preg_split('/[_\s]/', $name, -1, PREG_SPLIT_NO_EMPTY);

        // Capitalize the first letter of each word except the first one
        $camelCaseName = '';
        foreach ($words as $key => $word) {
            if ($key === 0) {
                // Keep the first word lowercase
                $camelCaseName .= $word;
            } else {
                // Capitalize subsequent words
                $camelCaseName .= ucfirst($word);
            }
        }

        return $camelCaseName.'.'.$extension;
    }

    public static function rankFilter($sponsor) {
        $number = $sponsor->sponsored;

        // Retrieve the current sponsor with rank 1
        $hoofdSponsor = Sponsor::where('rank', 1)->first();

        // If there's no sponsor with rank 1, this means we can proceed without demotion
        if ($hoofdSponsor === null) {
            $sponsor->rank = 1;
            $sponsor->save();
            return 1;
        }

        // If the sponsor has the highest 'sponsored' value
        if ($number > $hoofdSponsor->sponsored) {
            // Demote the current rank 1 sponsor to rank 2 if it's not the same sponsor
            if ($sponsor->id != $hoofdSponsor->id) {
                $hoofdSponsor->rank = 2;
                $hoofdSponsor->save();
            }

            // Promote the new sponsor to rank 1
            $sponsor->rank = 1;
            $sponsor->save();
            return 1;
        } else {
            // If the sponsor doesn't have the highest value, rank accordingly
            if ($number < 50) {
                return 4;
            } elseif ($number < 100) {
                return 3;
            } elseif ($number < $hoofdSponsor->sponsored) {
                return 2;
            } else {
                // Default case should not happen because it covers all possibilities
                return 1;
            }
        }
    }

    public static function firstRankChecker() {
        // Retrieve the current sponsor with rank 1
        $hoofdSponsor = Sponsor::where('rank', 1)->first();

        // Retrieve the sponsor with the highest 'sponsored' value
        $highestSponsored = Sponsor::orderBy('sponsored', 'desc')->where('active',true)->first();

        // Check if there is a sponsor with rank 1 and if the highest sponsored sponsor should be promoted
        if ($hoofdSponsor && $highestSponsored && $highestSponsored->sponsored > $hoofdSponsor->sponsored||$hoofdSponsor->active==false) {
            // Demote the current rank 1 sponsor to rank 2
            $hoofdSponsor->rank = 2;
            $hoofdSponsor->save();

            // Promote the sponsor with the highest sponsored value to rank 1
            $highestSponsored->rank = 1;
            $highestSponsored->save();
        } elseif ($highestSponsored && !$hoofdSponsor) {
            // If there is no sponsor currently with rank 1, promote the highest sponsored sponsor
            $highestSponsored->rank = 1;
            $highestSponsored->save();
        }
    }
}

