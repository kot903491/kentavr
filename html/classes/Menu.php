<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 24.01.18
 * Time: 0:55
 */

class Menu
{
    public static function getHead()
    {
        $db=DB::connect();
        $res=$db->query('SELECT * from menu ORDER BY id ASC');
        while ($res_i=$res->fetch())
        {
            $result[]=$res_i;
        }
        return $result;
    }
}