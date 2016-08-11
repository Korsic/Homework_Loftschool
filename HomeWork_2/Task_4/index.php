<?php
/*
HomeWork: 2
Task: 4
Author: Korsic
 */

function table_math($column, $line) {
    if (($column === (int)$column) & ($line === (int)$line)) {
        if (($column >= 1) & ($line >= 1)) {
            for ($column_tab = 1; $column_tab <= $column; $column_tab++) {
                for ($line_tab = 1; $line_tab <= $line; $line_tab++) {
                    $result = $column_tab * $line_tab;
                    echo $result . " ";
                    if ($result < 10) {
                        echo "&nbsp ";
                    }
                }
                echo "<br />";
            }
        }

    } else {
        echo "введенные параметры некорректны";
    }
}


table_math(9, 10);