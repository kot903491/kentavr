<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 20:16
 */

class ModelMain extends Model
{
    function getIndex()
    {
        $this->data['m_head'] = Menu::getHead();
        return $this->data;
    }
}