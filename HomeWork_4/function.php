<?php
/**
 * Created by PhpStorm.
 * User: Korsic
 * Date: 14/08/16
 * Time: 00:12
 */

function check_username($username) {
    $db = new mysqli("localhost", "root", "root", 'homework4');
    if ($db->connect_errno) {
        exit("ошибка подключения к БД, повторите запрос");
    }
    $result = $db->query("select * from users where username = '$username' LIMIT 0,1");
    $record = $result->fetch_assoc();
    return $record;
}



