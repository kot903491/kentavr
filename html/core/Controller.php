<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 19:24
 */

abstract class Controller
{
    protected $model;
    protected $view;
    protected $page;

    function __construct($model,$page)
    {
        $this->model=new $model;
        $this->view=new View;
        $this->page=$page;
    }
    abstract function actionIndex();
}