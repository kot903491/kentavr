<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 21.01.18
 * Time: 17:53
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
ob_start();
include_once '../main.php';
ob_end_flush();