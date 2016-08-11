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
        $str_result = '';
        foreach ($array as $value) {
            $str_result .= $value;
        }
        return $str_result;
    }
}

$my_array = [255, "привет", "как дела"];
$str = my_function($my_array, true);
echo $str;