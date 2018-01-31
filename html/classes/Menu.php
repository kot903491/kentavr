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

    static public function getRight($i=0)
    {
        $db=DB::connect();
        $sql='SELECT caption,url FROM menu_right where access=(?) ORDER BY id ASC';
        $res = $db->prepare($sql);
        $res->execute([0]);
        while ($res_i = $res->fetch())
        {
            $result[] = $res_i;
        }
        if ($i>0)
        {
            $sql='SELECT caption,url FROM menu_right where access=(?) ORDER BY id ASC';
            $res = $db->prepare($sql);
            $res->execute([99]);
            while ($res_i = $res->fetch())
            {
                $result[] = $res_i;
            }
            $sql='SELECT caption,url FROM menu_right where access=(?) ORDER BY id ASC';
            $res = $db->prepare($sql);
            $res->execute([$i]);
            while ($res_i = $res->fetch())
            {
                $result[] = $res_i;
            }
        }
        return $result;
    }
}