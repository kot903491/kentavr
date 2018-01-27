<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 21.01.18
 * Time: 17:55
 */

require_once '../config/config.php';
require_once TWIG_DIR.'Autoloader.php';
Twig_Autoloader::register();
include_once CORE_DIR.'Autoload.php';
User::checkLogin();
Route::start();