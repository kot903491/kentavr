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
        exit;
    }

    static public function regUser($name,$pass,$role,$dept,$fio)
    {
        if (!User::findUser($name))
        {
            User::registerUser($name,$pass,$role,$dept,$fio);
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
        $result=false;
        if (isset($_COOKIE['salt'])&&isset($_SESSION['user']))
        {
            if ($_COOKIE['salt']===User::getUserSalt($_SESSION['id']))
            {
                User::setSession($_SESSION['user']);
                $result=true;
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
        return $result;
    }

    static public function checkRole()
    {
        $result=true;
        if (!User::chRole()){
            $result=false;
        }
        return $result;
    }

    static public function userData($id)
    {
        return User::getUserData((int)$id);
    }

    static public function findUser($login)
    {
        $result=false;
        $db=DB::connect();
        $sql='SELECT id FROM users WHERE name=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([strtolower($login)]);
        $res=$stmt->fetch();
        if ($res)
        {
            $result=true;
        }
        return $result;
    }

    static public function getRole()
    {
        $result=false;
        $db=DB::connect();
        $res=$db->query('SELECT * FROM role;');
        while($res_i = $res->fetch()){
            $result[]=$res_i;
        }
        return $result;
    }

    static public function getDept()
    {
        $result=false;
        $db=DB::connect();
        $res=$db->query('SELECT * FROM dept;');
        while($res_i = $res->fetch()){
            $result[]=$res_i;
        }
        return $result;
    }


//Приватные свойства




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

    private static function chRole()
    {

        if (isset($_SESSION['role'])){
            $url=$_SERVER['REQUEST_URI'];
            $db=DB::connect();
            $sql='SELECT access FROM menu_right WHERE url=(?);';
            $stmt=$db->prepare($sql);
            $stmt->execute([$url]);
            $res=$stmt->fetch();
            $res=explode(',',$res['access']);
            foreach($res as $value){
                $result=true;
                if ($value!='0' && $value!='99' && $value!=$_SESSION['role']){
                    $result=false;
                }

            }
        }
        return $result;
    }

    private static function registerUser($login,$password,$role,$dept,$fio)
    {
        $login=strtolower($login);
        $salt=User::generate_password(30);
        $pass=password_hash($password,1);
        $db=DB::connect();
        $sql='INSERT INTO users(`name`,`pass`,`salt`,`role`,`dept`,`fio`) VALUES((?),(?),(?),(?),(?),(?));';
        $stmt=$db->prepare($sql);
        $stmt->bindParam(1,$login);
        $stmt->bindParam(2,$pass);
        $stmt->bindParam(3,$salt);
        $stmt->bindParam(4,$role);
        $stmt->bindParam(5,$dept);
        $stmt->bindParam(6,$fio);
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
        setcookie('salt',$res['salt'],(time()+6000),'/');
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

    private static function getUserData($id)
    {
        $db=DB::connect();
        $sql='select users.fio,dept.dept from users
        inner join dept on dept.id=users.dept
        where users.id=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([(int)$id]);
        $res=$stmt->fetch();
        return $res;
    }

}