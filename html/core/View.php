<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 20:26
 */

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.
    /*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
    function render($data)
    {
        try{
            $loader = new Twig_Loader_Filesystem($data['path']);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate($data['tmpl']);
            echo $template->render($data);
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }

}