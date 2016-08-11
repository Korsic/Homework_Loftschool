<?php
/*
HomeWork: 1
Task: 6
Author: Korsic
 */

$bmw = [
    "model" => "X5",
    "speed" => "120",
    "doors" => "5",
    "year" => "2015",
    "name" => "bmw"
];
$toyota = [
    "model" => "Corolla",
    "speed" => "100",
    "doors" => "4",
    "year" => "2016",
    "name" => "toyota"
];
$opel = [
    "model" => "vectra",
    "speed" => "95",
    "doors" => "4",
    "year" => "2014",
    "name" => "opel"
];

$car = [$bmw, $toyota, $opel];

foreach ($car as $value) {
    echo "Car " .$value['name'] . "<br />";
    echo $value['model'] . " - " . $value['speed']. " - " . $value['doors']. " - " . $value['year'] . "<br /><br />";
}
