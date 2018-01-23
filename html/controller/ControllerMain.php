<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 19:48
 */

class ControllerMain extends Controller
{
    public function actionIndex()
    {
        // TODO: Implement Action_Index() method.
        $page='get'.$this->page;
        if(method_exists($this->model, $page)){
            $data=$this->model->$page();
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            echo 'не нашел Model->'. $page;
        }
    }
}