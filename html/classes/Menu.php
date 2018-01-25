<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 24.01.18
 * Time: 0:55
 */

class Menu
{
    static public function getHead($m=0)
    {
        $db=DB::connect();
        $res=$db->query('SELECT caption,url from menu_main ORDER BY id ASC');
        $i=1;
        $result='';
        while ($res_i=$res->fetch())
        {
            $result.='<li><a href="'.$res_i['url'].'"';
            if ($m==$i)
            {
                $result.=' class="active"';
            }
            $result.='>'.$res_i['caption'].'</a></li>';
            $i++;
        }
        return $result;
    }

    static public function getRight()
    {
        $db=DB::connect();
        $res=$db->query('SELECT caption,url FROM menu_right ORDER BY id ASC');
        while ($res_i=$res->fetch())
        {
            $result[]=$res_i;
        }
        return $result;
    }
}