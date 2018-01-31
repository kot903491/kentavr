<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 21.01.18
 * Time: 17:57
 */

//Переменные расположения для сервера

define ('_DS',DIRECTORY_SEPARATOR);//системный разделитель
define ('SITE_ROOT','..'._DS);//корень сайта
define ('CONFIG_DIR',SITE_ROOT.'config'._DS);//папка конфигов
define ('CORE_DIR',SITE_ROOT.'core'._DS);//папка родительских классов
define ('CONTROLLER_DIR',SITE_ROOT.'controller'._DS);//папка контроллеров
define ('MODEL_DIR',SITE_ROOT.'model'._DS);//папка моделей
define ('VIEW_DIR',SITE_ROOT.'view'._DS);//папка вьюшек
define ('TWIG_DIR',SITE_ROOT.'Twig'._DS);
define ('CLASS_DIR',SITE_ROOT.'classes'._DS);



//Переменные расположения для html
define('SITE_DIR',_DS.'public'._DS);//корень html
define('STYLE_DIR',SITE_DIR.'style'._DS);//папка css
define('IMAGE_DIR',SITE_DIR.'image'._DS);//папка с изображениями
define ('JS_DIR',_DS.'js'._DS);

//Переменные SQL
define('SQL_SERVER','localhost');
define('SQL_USER','root');
define('SQL_PASS','qwerty');
define('SQL_PORT','3306');
define ('SQL_DBNAME','kentavr');


//соль сайта
define ('SULT','Y}6H\mp2s4x"FzlQ9je0');
