<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 23.01.18
 * Time: 20:16
 */

class ModelMain extends Model
{
    public function getFirst()
    {
        $s='<h1>Основной заголовок</h1>
        <p>Это пример текста, <a href="#" title="link">это пример ссылок</a>, а дальше просто текст-рыба.</p>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat.
            Duis aute irure dolor in <b title="bold">reprehenderit in voluptate velit</b>
            esse cillum dolore eu fugiat nulla pariatur.
            <i title="italic">Excepteur sint occaecat</i> cupidatat non proident,
            sunt in culpa qui officia deserunt.</p><hr>';
        $this->data['content']=$s;
        $this->data['m_head'] = Menu::getHead(1);
        return $this->data;
    }

    public function getTel()
    {
        $db=DB::connect();
        $res=$db->query('SELECT post,fio,tel FROM phonebook');
        $result = "<div class=\"none\"><table class='bordered'>
        <thead>
        <tr>
        <th>Должность/Отдел</th>
        <th>Ф.И.О</th>
        <th>Номер телефона</th>
        </tr>
        </thead>";
        while($res_i=$res->fetch())
        {
            $result.='<tr><td>'.$res_i['post'].'</td><td>'.$res_i['fio'].'</td><td>'.$res_i['tel'].'</td></tr>';
        }
        $result.='</table></div>';
        $this->data['content']=$result;
        $this->data['m_head'] = Menu::getHead(2);
        return $this->data;
    }

    public function getPechkin()
    {
        $db=DB::connect();
        $res=$db->query('SELECT name,number FROM pechkinbook');
        $result = "<div class=\"none\"><table class='bordered'>
        <thead>
        <tr>
        <th>Ф.И.О</th>
        <th>Номер печкина</th>
        </tr>
        </thead>";
        while ($res_i=$res->fetch())
        {
            $result.='<tr><td>'.$res_i['name'].'</td><td>'.$res_i['number'].'</td></tr>';
        }
        $result.='</table></div>';
        $this->data['content']=$result;
        $this->data['m_head'] = Menu::getHead(3);
        return $this->data;
    }


}
