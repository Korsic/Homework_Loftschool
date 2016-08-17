<?php

/**
 * Created by PhpStorm.
 * User: Korsic
 * Date: 15/08/16
 * Time: 20:34
 */
class Db
{
    public static function getConnection()
    {
        $db = null;
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $db = new PDO("mysql:host={$params['host']};dbname={$params['dbname']}",$params['user'],$params['password']);
        return $db;
    }
}