<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 19:04
 */


spl_autoload_register(function ($ClassName){

    $class_dir=[CORE_DIR, CONTROLLER_DIR, MODEL_DIR, VIEW_DIR,CLASS_DIR];
    $s=false;
    foreach ($class_dir as $value){
        $f=$value.$ClassName.'.php';
        if(file_exists($f)){
            $s=true;
            include_once $f;
        }
    }
    if(!$s){
        echo 'не нашел'.$ClassName;
    }
});