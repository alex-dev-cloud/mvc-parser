<?php

namespace core;


class Router

{
    public static function init()
    {
        $url = (isset($_GET['url'])) ? $_GET['url'] : 'home';
        $url = explode('/', $url);

        $controllerName = ucfirst($url[0]).'Controller';
        $action = (isset($url[1]) && $url[1] !== ' ') ? $url[1] : 'index';
        $file = dirname(__DIR__) . '/app/controllers/'.$controllerName.'.php';

        if (!file_exists($file)) {
            require_once dirname(__DIR__) . '/app/views/errors/404.php';
        } else {
            $controllerFullName = 'app\\controllers\\' . $controllerName;
            $controller = new $controllerFullName;
            if (!method_exists($controller, $action)){
                require_once dirname(__DIR__) . '/app/views/errors/404.php';
            } else {
                $controller->$action();
            }
        }

    }
}





