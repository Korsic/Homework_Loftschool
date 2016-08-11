<?php
/*
HomeWork: 2
Task: 7
Author: Korsic
 */

function good_replace ($str, $replace, $new_replace) {
    return str_replace($replace, $new_replace, $str);
}

echo good_replace("Карл у Клары украл Кораллы", "К", "") . "<br />";
echo good_replace("Две бутылки лимонада", "Две", "Три");