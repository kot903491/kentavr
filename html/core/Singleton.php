<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 21:05
 */

trait Singleton
{
    private static $single=false;   //инициализируем статическую переменную

    private function __construct()  //замыкаем конструктор на нужный нам метод класса
    {
    }
    private function __clone()      //запрещаем клонирование
    {
    }
    private function __wakeup()  //запрещаем восстановление ресурсов объекта
    {
    }

    public static function connect(){
        if(self::$single===false){      //если не создавали класс
            self::$single=new PDO('mysql:host='.SQL_SERVER.';port='.SQL_PORT.';charset=utf8;dbname='.SQL_DBNAME,SQL_USER,SQL_PASS,[PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);   //то создаем
        }
        return self::$single;
    }
}