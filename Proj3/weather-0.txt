<?php

$z = $_GET["zip"];

sleep (2);
$url = "http://api.openweathermap.org/data/2.5/weather?zip=$z,us&units=metric&appid=86601fba2f879c89dbbfa35161f9079f"; 

$fp = fopen ( $url , "r" ); 
$contents = "";

while ( $more = fread ( $fp, 1000  ) ) {
   $contents .=  $more ;
} 

echo $contents ; 

?>