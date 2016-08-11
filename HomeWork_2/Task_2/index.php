<?php
/*
HomeWork: 2
Task: 2
Author: Korsic
 */

function my_function($array, $math) {
    if (!is_array($array)) {    //Проверяем входной массив
        echo "Вы ввели не массив в качестве входного параметра";
    } else {
        // Проверяем входной массив на числовые параметры
        foreach ($array as $value) {
            if (!is_numeric($value)) {
                exit("Введенный массив содержит не численные значения");
            }
        }
        if (!isset($array[0])) { // Проверяем на пустой массив
            exit("Вы ввели пустой массив");
        }
        // Делаем расчеты
        $result = 0;
        switch ($math) {
            case '+':
                $result = array_sum($array);
                break;
            case '-':
                $result -= array_sum($array);
                break;
            case '*':
                $result = 1;
                foreach ($array as $value) {
                    $result *= $value;
                }
                break;
            case '/':
                $result = 1;
                if (in_array(0, $array)) {
                    exit("Деление на ноль невозможно");
                } else {
                    foreach ($array as $value) {
                        $result /= $value;
                    }
                }
                break;
            default:
                exit("Вы ввели некорректное математическое действие");
        }
        echo "Результат \"" . $math . "\" всех элементов массива = " . $result;
    }
}

$array = [2, 2, 3, 10];
my_function($array, '/');