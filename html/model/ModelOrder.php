<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 14.02.18
 * Time: 11:41
 */

class ModelOrder extends Model
{
    public function __construct()
    {
        $this->control();
        parent::__construct();
        $this->data['m_head']=Menu::getHead(99);
    }

    public function getAddprovision($action)
    {

        switch ($action){
            case 'main':
                $this->data['js']['jquery']=JS_DIR.'jquery.js';
                $this->data['js']['script']=JS_DIR.'addProv.js';
                $data['action']=$_SERVER['REQUEST_URI'].'/add';
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
                break;
            case 'add':
                $this->add($_POST);
                break;
        }

    }

    public function getAppprovision($action)
    {
        switch ($action){
            case 'main':
                try{
                    $data['table']=Provision::createConfirmTable();
                    $data['action']=$_SERVER['REQUEST_URI'].'/confirm';
                    $loader = new Twig_Loader_Filesystem($this->data['path']);
                    $twig=new Twig_Environment($loader);
                    $template=$twig->loadTemplate('conforder.tmpl');
                    $this->data['content'] = $template->render($data);

                }
                catch (Exception $e){
                    die('ERROR: '.$e->getMessage());
                }
                return $this->data;
                break;
            case 'confirm':
                $this->confirm($_POST);
                break;
        }

    }

    public function getOrdernot($action)
    {
        switch ($action) {
            case 'main':
                $this->data['js']['jquery'] = JS_DIR . 'jquery.js';
                $this->data['js']['script'] = JS_DIR . 'viewOrder.js';
                try {
                    $data['table'] = Provision::createSnabTable();
                    $data['action']=$_SERVER['REQUEST_URI'].'/assign';
                    $data['msg']=$this->data['msg'];
                    $loader = new Twig_Loader_Filesystem($this->data['path']);
                    $twig = new Twig_Environment($loader);
                    $template = $twig->loadTemplate('ordernot.tmpl');
                    $this->data['content'] = $template->render($data);
                } catch (Exception $e) {
                    die('ERROR: ' . $e->getMessage());
                }
                return $this->data;
                break;
            case 'assign':
                if (isset($_POST['exec'])){
                    $this->assign($_POST['exec']);
                }
                else{
                    header('Refresh: 0;'.$this->returnUrl());
                    exit;
                }
                break;
        }
    }

    public function getMyprov()
    {
        try {
            $data['content'] = Provision::createMyProv();
            $data['msg']=$this->data['msg'];
            $loader = new Twig_Loader_Filesystem($this->data['path']);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('prov.tmpl');
            $this->data['content'] = $template->render($data);
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
        return $this->data;
    }

    public function getOrderexec($action)
    {
        switch ($action){
            case 'main':
                try{
                    $data['eval']['action']=$_SERVER['REQUEST_URI'].'/eval';
                    $data['eval']['content']=Provision::createExecTable('eval');
					$data['perf']['action']=$_SERVER['REQUEST_URI'].'/perf';
                    $data['perf']['content']=Provision::createExecTable('perf');
					$data['msg']=$this->data['msg'];
                    $loader= new Twig_Loader_Filesystem($this->data['path']);
                    $twig=new Twig_Environment($loader);
                    $template=$twig->loadTemplate('prov.tmpl');
                    $this->data['content']=$template->render($data);
                }catch (Exception $e){
                    die('ERROR: '.$e->getMessage());
                }
                return $this->data;
				break;
			case 'eval':
				if (isset($_POST['data'])){
					$_SESSION['msg']=Provision::setEvalTable($_POST['data']);
				}
				header('Refresh:0;'.$this->returnUrl());
				exit;
				break;
				case 'perf':
				if (isset($_POST['data'])){
					$_SESSION['msg']=Provision::setPerfTable($_POST['data']);
					break;
				}
				header('Refresh:0;'.$this->returnUrl());
				exit;
				break;
        }

    }

    private function add($data)
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
        header('Refresh:0;'.$this->returnUrl());
        exit;
    }

    private function confirm($data)
    {
        if (isset($data['conf'])){
            $dat = date("Y-m-d");
            foreach($data['conf'] as $key=>$value){
                if ($value!=1){
                    Provision::orderConfirm($key,$value,$dat);
                }
            }
        }
        header('Refresh:0; '.$this->returnUrl());
        exit;
    }

    private function assign($data)
    {
        $str='';
        foreach ($data as $key=>$value){
            if ($value!=0){
                if (isset($_SESSION['exec'][$key])){
                    $bool=true;
                    $exec=$_SESSION['exec'][$key];
                    if (Provision::setExec($exec[0],$exec[1],$exec[2],$value)){
                        $str.=$exec[0].' - '.$exec[1].' - '.$value.' назначено<br>';
                    }
                    else{
                        $str.=$exec[0].' - '.$exec[1].' - '.$value.' ошибка<br>';
                    }
                }
            }
        }
        $_SESSION['msg'] = $str;
        header('Refresh: 0;'.$this->returnUrl());
        exit;
    }
}