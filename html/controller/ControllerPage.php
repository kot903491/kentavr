<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 01.02.18
 * Time: 2:21
 */

class ControllerPage extends Controller
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

    public function actionAdd()
    {
        if (method_exists($this->model,'add'))
        {
            $this->model->add($_POST);
        }
    }
    public function actionConfirm()
    {
        if (method_exists($this->model,'confirm'))
        {
            $this->model->confirm($_POST);
        }
    }
}