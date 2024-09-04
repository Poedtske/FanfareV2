<?php
$description=null;
!empty($description) ? : $description="*null*";
// print($description);

$json = "{*action*:*update*,*event*:{*title*:*obraham*,*date*:*2024-07-16*,*description*:*dfggfedf*,*start_time*:*10:20:00*,*end_time*:*20:10:00*,*location*:*plop*,*calendar_id*:*opkmhkie2ofr3inhc6p2i94lrc*}}";
$jsonEscaped = escapeshellarg($json); // Escape the JSON argument
$output = shell_exec("python Calendar_api.py $jsonEscaped"); // Use shell_exec to capture output
echo $output;
?>
