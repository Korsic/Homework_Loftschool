<?php
/*
HomeWork: 2
Task: 3
Author: Korsic
 */

function calcEverything($math, ...$numbers) {
    //Проверяем входные данные на числа
    foreach ($numbers as $value) {
        if (!is_numeric($value)) {
            exit("Введенные данные содержат не численные значения");
        }
    }
    if (!isset($numbers[0])) {
        exit("Введенные данные не содержат чисел");
    }
    switch ($math) {
        case '+':
            return array_sum($numbers);
        case '-':
            return (-1 * array_sum($numbers));
        case '*':
            $result = 1;
            foreach ($numbers as $value) {
                $result *= $value;
            }
            return $result;
        case '/':
            $result = 1;
            if (in_array(0, $numbers)) {
                exit("Деление на ноль невозможно");
            } else {
                foreach ($numbers as $value) {
                    $result /= $value;
                }
            }
            return $result;
        default:
            exit("Вы ввели некорректное математическое действие");
    }
}

echo calcEverything('/',1,2);