<?php
/*
HomeWork: 2
Task: 1
Author: Korsic
 */

function my_function($array, $type = false) {
    foreach ($array as $value) {
        echo "<p>" . $value . "</p>";
    }
    if ($type == true) {
        return implode($array);
    }
}

$my_array = [255, "привет", "как дела"];
$str = my_function($my_array, true);
echo $str;