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
        $this->data['right']=true;
        $this->data['m_right'] = Menu::getRight();
        if (isset($_SESSION['id'])&&isset($_SESSION['user'])&&isset($_SESSION['role']))
        {
            $this->data['auth']=true;
            $this->data['user_data']=User::userData($_SESSION['id']);
        }
        else
        {
            $this->data['auth']=false;
        }

        if (isset($_SESSION['msg']))
        {
            $this->data['auth_msg']=$_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    }
}