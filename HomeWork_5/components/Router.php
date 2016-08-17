<?php

/**
 * Created by PhpStorm.
 * User: Korsic
 * Date: 15/08/16
 * Time: 16:36
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);

    }

    /**
     * Returns request string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Получить строку запроса
        $uri = $this->getURI();

        // Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                // Если есть совпадение определяем какой контроллер и какой action обрабатывает запрос

                $segment = explode('/', $path);

                $controllerName = ucfirst(array_shift($segment) . 'Controller');

                $actionName = 'action' . ucfirst(array_shift($segment));

                // Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Создать объект
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
        }
    }


}