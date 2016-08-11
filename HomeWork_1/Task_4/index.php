<?php
/*
HomeWork: 1
Task: 4
Author: Korsic
 */

$age = 28;

if (($age >= 18) & ($age <= 65)) {

    echo "Вам   еще работать   и   работать";
} elseif ($age > 65) {
    echo "Вам   пора   на   пенсию";
} elseif (($age >= 1) &($age <=17)) {
    echo "Вам   ещё   рано   работать";
} else {
    echo "Неизвестный   возраст";
}
