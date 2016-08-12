<?php
/*
HomeWork: 3
Task: 3
Author: Korsic
 */

/*
 * Программно создайте массив, в котором перечислено не менее 50 случайных числел от 1 до 100
Сохраните данные в файл csv
Откройте файл csv и посчитайте сумму четных чисел

*/
$array = [];
for ($i = 0; $i < 50; $i++) {
    $array[$i] = mt_rand(1, 100);
}

$fp = fopen('file.csv', 'w');
fputcsv($fp, $array);
fclose($fp);


$fp = fopen("file.csv", "r");
$new_array = fgetcsv($fp, 0, ",");


echo "Сумма всех элементов массива равна: " . array_sum($new_array);