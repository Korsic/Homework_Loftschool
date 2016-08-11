<?php
/*
HomeWork: 2
Task: 10
Author: Korsic
 */

/*
 * Создайте файл anothertest.txt средствами PHP. Поместите в него текст - “Hello again!”

 */

function my_create_file ($filename, $text) {
    if (file_exists($filename)) {
        unlink($filename);
    }
    $file = fopen($filename, "w");
    fwrite($file, $text);
    fclose ($file);
    }


my_create_file("anothertest.txt", "Hello again!");

echo "Файл создан!";