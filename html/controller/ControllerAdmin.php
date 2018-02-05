<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 05.02.18
 * Time: 19:59
 */

class ControllerAdmin extends Controller
{
    public function actionFirst()
    {
        // TODO: Implement actionFirst() method.
        $page='get'.$this->page;
        if(method_exists($this->model, $page))
        {
            $data=$this->model->$page();
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }
    }
    public function actionNew()
    {
        $page='new'.$this->page;
        if(method_exists($this->model, $page))
        {
            $data=$this->model->$page();
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }
    }
}