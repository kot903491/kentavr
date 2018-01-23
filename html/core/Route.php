<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 21.01.18
 * Time: 17:57
 */


class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Main';
        $page_name = 'Index';
        $action='Index';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        // получаем имя контроллера
        if ( !empty($routes[1]) )
        {
            $controller_name = ucfirst($routes[1]);
        }
        // получаем имя страницы
        if ( !empty($routes[2]) )
        {
            $page_name = ucfirst($routes[2]);
        }
        // получаем имя экшена
        if(!empty($routes[3])){
            $action=ucfirst($routes[3]);
        }
        // добавляем префиксы
        $model_name ='Model'.$controller_name;
        $controller_name = 'Controller'.$controller_name;
        $action = 'action'.$action;

        // создаем контроллер
        $controller = new $controller_name($model_name,$page_name);

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            echo 'ошибка роутера';
        }

    }

    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}