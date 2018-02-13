<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 12.02.18
 * Time: 14:43
 */
require_once '../config/config.php';
require_once '../core/Autoload.php';
if (isset($_POST['dat'])&&$_POST['tov']){
    echo Provision::getTableDetail($_POST['dat'],$_POST['tov']);
}