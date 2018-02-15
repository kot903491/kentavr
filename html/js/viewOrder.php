<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 12.02.18
 * Time: 14:43
 */
require_once '../config/config.php';
require_once '../core/Autoload.php';
if (isset($_POST['dat'])&&isset($_POST['tov'])&&isset($_POST['un'])){
    echo Provision::getTableDetail($_POST['dat'],$_POST['tov'],$_POST['un']);
}