<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 14.02.18
 * Time: 11:40
 */

class ControllerOrder extends Controller
{
    public function actionFirst()
    {
        // TODO: Implement actionFirst() method.
        $page='get'.$this->page;
        if(method_exists($this->model, $page))
        {
            $data=$this->model->$page($this->action);
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }
    }
}