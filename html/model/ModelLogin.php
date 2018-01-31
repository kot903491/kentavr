<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 25.01.18
 * Time: 23:08
 */

class ModelLogin extends Model
{
    public function getFirst()
    {
        if(isset($_POST['signIn']))
        {
            $this->getLogin();
        }
        $this->data['m_head']=Menu::getHead();
        try{
            $loader = new Twig_Loader_Filesystem($this->data['path']);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('login.tmpl');
            $this->data['content']=$template->render(['auth_msg'=>$this->data['auth_msg']]);

        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        return $this->data;
    }

    public function getLogout()
    {
        User::Logout();
    }

    private function getLogin()
    {
        if ($_POST['login'] != '' && $_POST['pass'] != '')
        {
            $login = htmlspecialchars($_POST['login']);
            $pass = htmlspecialchars($_POST['pass']);
            User::Login($login, $pass);
        }
    }

}