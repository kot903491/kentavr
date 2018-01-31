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
        $this->data['m_head']=Menu::getHead(99);
        try{
            $loader = new Twig_Loader_Filesystem($this->data['path']);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('order.tmpl');
            $this->data['content']=$template->render([]);

        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        return $this->data;
    }
}