<?php
/*
HomeWork: 2
Task: 9
Author: Korsic
 */

/*Создайте средствами ОС файл test.txt и поместите в него текст “Hello, world”
Напишите функцию, которая будет принимать имя файла, открывать файл и выводить содержимое на экран.
*/

function my_read_file ($name) {
    $mytextfile = file($name);
    foreach ($mytextfile as $value) {
        echo $value . "<br />";
    }
}

my_read_file('text.txt');