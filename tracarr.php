<?php

$json = file_get_contents('php://input');



$data = json_decode($json, true);



$id=$data["id"];

$lat=$data["latitude"];

$lon=$data["longitude"];

$page = file_get_contents("http://67.219.110.154:5055/?id=$id&lat=$lat&lon=$lon");

?>
