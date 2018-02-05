<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 01.02.18
 * Time: 2:29
 */

class ModelPage extends Model
{
    public function getAddprovision()
    {
        $this->control();
        $this->data['m_head']=Menu::getHead(99);
        $data['row']=Provision::addTR();
        $data['msg']=$this->data['msg'];
        try{
            $loader = new Twig_Loader_Filesystem($this->data['path']);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('order.tmpl');
            $this->data['content'] = $template->render($data);

        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        return $this->data;
    }

    public function add($data)
    {
        if (isset($data['data']))
        {
            $data=$data['data'];
            $id=$_SESSION['id'];
            if(Provision::orderAdd($id,$data))
            {
                $_SESSION['msg']='Заявка отправлена на утверждение';
            }
            else
            {
                $_SESSION['msg']='Ошибка при отправке заявки, попробуйте заново';
            }


        }
        else
            {
                $_SESSION['msg']='Ошибка! Нет данных для записи';
            }
            header('Refresh:0;/page/addprovision');
    }
}