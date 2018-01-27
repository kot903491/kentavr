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
        $result=false;
        if ($login!='' && $pass!='')
        {
            if (User::chLogin($login,$pass))
            {
                $result['auth']=true;
                User::setSession($login);
                header('Refresh: 0; /');
                exit;
            }
            else
            {
                $_SESSION['msg']='Неверный логин или пароль';
                header('Refresh: 0; '.$_SERVER['REQUEST_URI']);
                exit;
            }
        }
    }

    static public function Logout()
    {
        User::unsetSession();
        header('Refresh: 0; /');
    }

    static public function regUser($name,$pass,$role)
    {
        if (!User::findUser($name))
        {
            User::registerUser($name,$pass,$role);
        }
    }

    static public function cPass($login,$oldpass,$newpass)
    {
        if($oldpass!=$newpass) {
            if (User::findUser($login)) {
                if (User::chLogin($login,$oldpass)) {
                    User::changePassword($login, $newpass);
                }
            }
        }
    }

    static public function checkLogin()
    {
        if (isset($_COOKIE['salt'])&&isset($_SESSION['user']))
        {
            if ($_COOKIE['salt']===User::getUserSalt($_SESSION['id']))
            {
                User::setSession($_SESSION['user']);
            }
            else
            {
                User::unsetSession();
            }
        }
        else
        {
            User::unsetSession();
        }
    }

//Приватные свойства


    private static function findUser($login)
    {
        $result=false;
        $db=DB::connect();
        $sql='SELECT id FROM users WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([$login]);
        $res=$stmt->fetch();
        if ($res)
        {
            $result=true;
        }
        return $result;
    }

    private static function chLogin($l,$p)
    {
        $result=false;
        if (User::findUser($l))
        {
        $db=DB::connect();
        $sql='SELECT pass FROM users WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([$l]);
        $res=$stmt->fetch();
            if (password_verify($p,$res['pass']))
            {
                $result=true;
            }
        }
        return $result;
    }

    private static function registerUser($login,$password,$role)
    {
        $salt=User::generate_password(30);
        $pass=password_hash($password,1);
        $db=DB::connect();
        $sql='INSERT INTO users(`name`,`pass`,`salt`,`role`) VALUES((?),(?),(?),(?));';
        $stmt=$db->prepare($sql);
        $stmt->bindParam(1,$login);
        $stmt->bindParam(2,$pass);
        $stmt->bindParam(3,$salt);
        $stmt->bindParam(4,$role);
        $stmt->execute();
    }

    private static function changePassword($login,$newpass)
    {
        $salt=User::generate_password(30);
        $pass=password_hash($newpass,1);
        $db=DB::connect();
        $sql='UPDATE users SET pass=(?),salt=(?) WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->bindParam(1,$pass);
        $stmt->bindParam(2,$salt);
        $stmt->bindParam(3,$login);
        $stmt->execute();
    }

    private static function generate_password($number)
    {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*','$',
                 '<','>','/','|','+','-',
                 '{','}','`','~');
    // Генерируем пароль
    $pass = '';
    for($i = 0; $i < $number; $i++)
    {
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
    }

    private static function setSession($login)
    {

        setcookie('salt','',(time()-1),'/');
        $db=DB::connect();
        $sql='SELECT id,salt,role FROM users WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([$login]);
        $res=$stmt->fetch();
        setcookie('salt',$res['salt'],(time()+600),'/');
        $_SESSION['role']=$res['role'];
        $_SESSION['user']=$login;
        $_SESSION['id']=$res['id'];
    }

    private static function unsetSession()
    {
        setcookie('salt','',(time()-1),'/');
        if(isset($_SESSION['id']))
        {
            unset($_SESSION['id']);
        }
        if(isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
        }
        if(isset($_SESSION['role']))
        {
            unset($_SESSION['role']);
        }
    }

    private static function getUserSalt($id)
    {
        $result='';
        $db=DB::connect();
        $sql='SELECT salt FROM users WHERE id=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([(int)$id]);
        $res=$stmt->fetch();
        if ($res['salt']!='')
        {
            $result=$res['salt'];
        }
        return $result;
    }

}