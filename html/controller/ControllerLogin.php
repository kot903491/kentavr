<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 25.01.18
 * Time: 22:57
 */

class ControllerLogin extends Controller
{
    function actionFirst()
    {
        // TODO: Implement actionIndex() method.
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