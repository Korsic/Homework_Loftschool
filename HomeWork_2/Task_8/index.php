<?php
/*
HomeWork: 2
Task: 8
Author: Korsic
 */

/*Напишите функцию, которая с помощью регулярных выражений, получит информацию о переданных RX пакетах из переданной строки:

Пример строки: “RX packets:950381 errors:0 dropped:0 overruns:0 frame:0. “

Если кол-во пакетов более 1000, то выдавать сообщение: “Сеть есть”

Если в переданной в функцию строке есть “:)”, то нарисовать смайл в ASCII и не выдавать сообщение из пункта №3. Смайл должен храниться в отдельной функции

*/


function good_smile() {
    echo "¯\\_(ツ)_/¯";
}

function test_rx_pack ($str) {
    $smile = "#\:\)#";
    preg_match($smile, $str, $result_temp);
    if($result_temp[0] == ":)") {
        good_smile();
    } else {
        // Проверяем на количество пакетов
        preg_match("#(packets.*?)\s#i", $str, $result_temp);
        preg_match("#\d.*#", $result_temp[0], $result);
        if ((int)$result[0] > 1000) {
            echo "Сеть есть";
        } else {
            echo "Сети нет!";
        }
    }

}

test_rx_pack ("RX packets:10011 errors:0 dropped:0 :) overruns:0 frame:0. ");