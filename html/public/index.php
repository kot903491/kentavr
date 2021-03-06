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

header('Cache-Control: no-store, private, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Expires: 0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');
Header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

session_start();
ob_start();
include_once '../main.php';
ob_end_flush();