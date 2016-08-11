<?php
/*
HomeWork: 1
Task: 8
Author: Korsic
 */

$str = "Привет мой свет как у тебя дела";
echo $str . "<br /><br />";

$words = explode(" ", $str);

foreach ($words as $value) {
    echo $value . "<br />";
    }

//rsort($words); //Разворот массива нативной функцией

# Разворачиваем массив вручную циклом while
$count = count($words);
$count_circle = (int)ceil($count/2);
$i = 0;
while ($i<$count_circle) {
    $temp = $words[$i]; //Берем элемент с начала массива
    $words[$i] = $words[$count - 1 - $i];  //В начало массива записываем элемент из конца
    $words[$count - 1 - $i] = $temp; //В конец массива записываем элемент из начала
    $i++;
}
echo "<br />";

# Склеиваем строку обратно с разделителем точкой
$str_result = '';
$i = 0;
while ($i<$count-1) {
    $str_result .= $words[$i] . ".";
    $i++;
}
$str_result .= $words[$count-1];
echo $str_result;
