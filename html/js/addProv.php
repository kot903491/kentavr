<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 01.02.18
 * Time: 0:35
 */
require_once '../config/config.php';
require_once '../core/Autoload.php';
$i=$_POST['i'];
$str=Provision::addTR($i);
echo $str;