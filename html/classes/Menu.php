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
        $sql='SELECT `caption`,`url`,`access` FROM `menu_right` ORDER BY `access` ASC';
        $res = $db->prepare($sql);
        $res->execute();
        while ($res_i=$res->fetch()){
            $access=explode(',',$res_i['access']);
            foreach($access as $value){
                if($value=='0'||($value=='99'&&$i>0)||$value==$i){
                    unset($res_i['access']);
                    $result[]=$res_i;
                    break;
                }
            }
        }
        return $result;
    }
}