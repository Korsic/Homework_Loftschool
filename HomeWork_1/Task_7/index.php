<?php
/*
HomeWork: 1
Task: 7
Author: Korsic
 */

for ($column = 1; $column <= 10; $column++) {
    for ($line = 1; $line <= 10; $line++) {
        $result = $column * $line;
        if (!($result % 4)) { //Если число делится на 4 - то столбик и строка четные
            echo "(" . $result . ")". "&nbsp ";
        } elseif ($result % 2) {   //Если не делится на 2 - то столбик и строка нечетные
            echo "[" . $result . "]". "&nbsp ";
        } else {
            echo $result . "&nbsp ";
        }
    }
    echo "<br />";
}