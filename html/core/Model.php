<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 19:55
 */

abstract class Model
{
    protected $data;
    function __construct()
    {
        $this->data['path']=VIEW_DIR;
        $this->data['tmpl']='main.tmpl';
        $this->data['title']='Кентавр';
        $this->data['css']=STYLE_DIR.'style.css';
    }
}