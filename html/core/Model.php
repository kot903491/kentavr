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
        $this->data['n_css']=STYLE_DIR.'normalize.css';
        $this->data['css']=STYLE_DIR.'style.css';
        $this->data['right']=true;
        $this->data['msg']='';
        if (isset($_SESSION['id'])&&isset($_SESSION['user'])&&isset($_SESSION['role']))
        {
            $this->data['auth']=true;
            $this->data['user_data']=User::userData($_SESSION['id']);
            $this->data['m_right'] = Menu::getRight((int)$_SESSION['role']);
        }
        else
        {
            $this->data['auth']=false;
            $this->data['m_right'] = Menu::getRight();
        }

        if (isset($_SESSION['msg']))
        {
            $this->data['msg']=$_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    }

    protected function control()
    {
        if (!User::checkLogin())
        {
            header('Refresh: 0; /');
            exit;
        }
        if (!User::checkRole($this->returnUrl())){
            Route::ErrorPage404();
            exit;
        }

    }

    protected function returnUrl()
    {
        $url=explode('/',$_SERVER['REQUEST_URI']);
        if (isset($url[3])){
            unset ($url[3]);
        }
        $url=implode('/',$url);
        return $url;
    }
}