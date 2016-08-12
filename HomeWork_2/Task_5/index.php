<?php
/*
HomeWork: 2
Task: 5
Author: Korsic
 */

function check_palindrom($str) {
    //Удаляем из строки пробелы и приводим к нижнему регистру
    $str = str_replace(" ", "", $str);
    $str = mb_strtolower($str);

    ### Проверяем строку на палиндромность вручную
    /*$lench = iconv_strlen($str);
    $lench_circle = (int)ceil($lench / 2);
    $i = 0;
    while ($i < $lench_circle) {
        if (mb_substr($str, $i, 1) != mb_substr($str, $lench - 1 - $i, 1)) {
            return false;
        }
        $i++;
    }*/
    ### Проверяем строку на палиндромность с помощью реверса массива
    preg_match_all('/./us', $str, $str_ar);
    if ($str == implode(array_reverse($str_ar[0]))) {
        return true;
    }
    return false;
}

function russian_speak($value) {
    if ($value == true) {
        echo "Строка палиндромная";
    } else {
        echo "Строка не палиндромная";
    }
}

russian_speak(check_palindrom("А роза уПАЛА на лапУ азора"));