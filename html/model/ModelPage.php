<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 01.02.18
 * Time: 2:29
 */

class ModelPage extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->data['m_head']=Menu::getHead(99);
    }
}