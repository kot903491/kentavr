<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 25.01.18
 * Time: 23:08
 */

class ModelLogin extends Model
{
    function getIndex()
    {
        $this->data['m_head']=Menu::getHead();
        $this->data['l']=true;
        $this->data['content'] = 'login.tmpl';
        return $this->data;
    }

    function getLogin()
    {
        if (isset($_POST['signIn']))
        {
            if($_POST['login']!='' && $_POST['pass']!='')
            {
                $login = htmlspecialchars($_POST['login']);
                $pass = htmlspecialchars($_POST['pass']);
                User::Login($login,$pass);

            }
        }
    }
}