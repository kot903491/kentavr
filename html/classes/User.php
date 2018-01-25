<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 26.01.18
 * Time: 1:37
 */

class User
{
    static public function Login($login,$pass)
    {
        $b=false;
        if ($login!='' && $pass!='')
        {
            if (User::chLogin($login,$pass))
            {
                $b=true;
            }
        }
        return $b;
    }
    private static function chLogin($l,$p)
    {
        $b=false;
        $db=DB::connect();
        $sql='SELECT * FROM users WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([$l]);
        $res=$stmt->fetch();

    }
}