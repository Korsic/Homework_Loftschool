<?php
/*
HomeWork: 3
Task: 2
Author: Korsic
 */

/*
 * Создайте массив, в котором имеется как минимум 1 уровень вложенности. Преобразуйте его в JSON.  Сохраните как output.json
Откройте файл output.json. Измените данные. Сохраните как output2.json
Откройте оба файла. Найдите разницу и выведите информацию об отличающихся элементах
 */

$array = ["фрукты" => ["a" => "апельсин",
    "b" => "банан",
    "c" => "яблоко"
],
    "числа" => [1, 2, 3, 4, 5, 6],
    "дырки" => ["ААААаааААА235",
        5 => "вторая",
        "третья"
    ]
];

function array_to_json($array) {
    $fp = fopen('output.json', 'w');
    fwrite($fp, json_encode($array, JSON_UNESCAPED_UNICODE));
    fclose($fp);
}

array_to_json($array);

function change_json() {
    $array = json_decode(file_get_contents('output.json'), true);
    foreach ($array as &$array_2) {
        foreach ($array_2 as &$value) {
            if (is_numeric($value)) {
                $value += 10;
            }
        }
        unset($value);
    }
    $fp = fopen('output2.json', 'w');
    fwrite($fp, json_encode($array, JSON_UNESCAPED_UNICODE));
    fclose($fp);
}

change_json();


function key_compare_func($key1, $key2) {
    if ($key1 == $key2)
        return 0;
    else if ($key1 > $key2)
        return 1;
    else
        return -1;
}

function find_different() {
    $array_1 = json_decode(file_get_contents('output.json'), true);
    $array_2 = json_decode(file_get_contents('output2.json'), true);

    echo "Элементы в output.json, которых нет в output2.json: <br />";
    echo "Фрукты: ";
    print_r(array_diff($array_1['фрукты'], $array_2['фрукты']));
    echo "<br /> Числа: ";
    print_r(array_diff($array_1['числа'], $array_2['числа']));
    echo "<br /> Дырки: ";
    print_r(array_diff($array_1['дырки'], $array_2['дырки']));

    echo "<br /><br />";
    echo "Элементы в output2.json, которых нет в output1.json: <br />";
    echo "Фрукты: ";
    print_r(array_diff($array_2['фрукты'], $array_1['фрукты']));
    echo "<br /> Числа: ";
    print_r(array_diff($array_2['числа'], $array_1['числа']));
    echo "<br /> Дырки: ";
    print_r(array_diff($array_2['дырки'], $array_1['дырки']));
}

find_different();