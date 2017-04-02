<?php

$type = isset($_GET['type']) ? $_GET['type'] : NULL;
$rad = isset($_GET['rad']) ? $_GET['rad'] : NULL;
$mylat = isset($_GET['mylat']) ? $_GET['mylat'] : 28.6100;
$mylong = isset($_GET['mylong']) ? $_GET['mylong'] : 77.2300;


$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$mylat},{$mylong}&radius={$rad}&types={$type}&sensor=false&name=&key=AIzaSyB4NnJJ3j7worhvvcBfDTeNuH2QyTbaKHU";


$json = file_get_contents($url);
$data = json_decode($json, TRUE);
$arr = $data["results"];


foreach($arr as $num)
{
$row["Name"] = $num["name"];
$row["Address"] = $num["vicinity"];
$row["Latitude"] = $num["geometry"]["location"]["lat"];
$row["Longitude"] = $num["geometry"]["location"]["lng"];
$row["Distance"] = distance($row["Latitude"], $row["Longitude"], $mylat, $mylong);
$row["Distance"] = (floor($row["Distance"]*10))/10;
$output[] = $row;
}

function distance($lat1, $lon1, $lat2, $lon2)
{
$theta = $lon1 - $lon2;
$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$km = $dist * 60 * 1.1515 * 1.609344;
return $km;
}


print(json_encode($output));
?>