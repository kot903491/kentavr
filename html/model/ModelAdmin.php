<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 05.02.18
 * Time: 20:12
 */

class ModelAdmin extends Model
{
    public function newUsers()
    {
        $this->control();
        if(isset($_POST['uname'])&&isset($_POST['pass1'])&&isset($_POST['pass2'])){
            if ($_POST['pass1']==$_POST['pass2']){
                if(!User::findUser($_POST['uname'])){
                    User::regUser($_POST['uname'],$_POST['pass1'],$_POST['role'],$_POST['dept'],$_POST['fio']);
                    $_SESSION['msg']='Пользователь создан';
                    header('Refresh: 0; '.$_SERVER['REQUEST_URI']);
                    exit;
                }
                else{
                    $_SESSION['msg']='Такой юзер уже зарегистрирован';
                    header('Refresh: 0; '.$_SERVER['REQUEST_URI']);
                    exit;
                }
            }
            else{
                $_SESSION['msg']='Пароли не совпадают';
                header('Refresh: 0; '.$_SERVER['REQUEST_URI']);
                exit;
            }
        }
        try{
            $data['msg']=$this->data['msg'];
            $data['roles']=User::getRole();
            $data['depts']=User::getDept();
            $loader = new Twig_Loader_Filesystem($this->data['path']);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('newuser.tmpl');
            $this->data['content'] = $template->render($data);

        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        return $this->data;
    }
}