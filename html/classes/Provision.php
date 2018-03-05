<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 02.02.18
 * Time: 11:25
 */

class Provision
{
    public static function addTR($i = 0)
    {
        $result = '<div><input type="text" name="data[' . $i . '][tovname]" required></div>
            <div class="num"><input type="number" name="data[' . $i . '][qt]" required></div>
            <div class="unit"><select name="data[' . $i . '][unit]">';
        foreach (self::getUnits() as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div class="cost"><input type="number" name="data[' . $i . '][cost]" step="any"></div>
            <div class="cur"><select name="data[' . $i . '][cur]">';
        foreach (self::getCurrency() as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div class="term"><select name="data[' . $i . '][term]">';
        foreach (self::getTerm() as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div><input type="text" name="data[' . $i . '][note]"></div>';
        return $result;
    }

    public static function orderAdd($id, $data)
    {
        $result=true;
        $db=DB::connect();
        $dat = date("y.m.d H:m:s");
        $sql='INSERT INTO `order`(`datetime`,`user`,`tovname`,`qt`,`unit`,`cost`,`curr`,`term`,`conf`,`note`) VALUES(?,?,?,?,?,?,?,?,?,?);';
        $db->beginTransaction();
        $stmt=$db->prepare($sql);
        foreach ($data as $value) {
            if ($value['cost']==''){
                $value['cost']='0';
            }
            $stmt->execute(array($dat,$id,trim($value['tovname']),$value['qt'],$value['unit'],$value['cost'],
                $value['cur'],$value['term'],'1',trim($value['note'])));
            $s=$stmt->errorInfo();
            if($s[2]!=null){
                $result=false;
            }
        }
        if ($result){
            $db->commit();
        }
        else{
            $db->rollBack();
        }


        return $result;
    }

    public static function createConfirmTable()
    {
		$db=DB::connect();
		$sql='SELECT * FROM confirm;';
		$res=$db->query($sql);
		while($res_i=$res->fetch())
		{
			$conf[$res_i['id']]=$res_i['caption'];
		}
		
        $result='';
        $sql='SELECT `order`.id as id,`order`.`datetime`,dept.dept,`order`.tovname,`order`.qt,units.caption as unit,`order`.cost,
currency.caption as curr,term.caption as term,`order`.note from `order`
inner join users on users.id=`order`.`user`
inner join dept on dept.id = users.dept
inner join units on units.id=`order`.unit
inner join currency on currency.id=`order`.curr
inner join term on term.id=`order`.term
where `order`.conf=1 ORDER BY `order`.`datetime` ASC;';
        $res=$db->query($sql);
        while($res_i=$res->fetch())
        {
            $result.='<tr><td class="date">'.date('d.m.Y',strtotime($res_i['datetime'])).'</td><td class="dept">'.$res_i['dept'].'</td><td class="tovname">'.$res_i['tovname'].'</td>';
            $result.='<td class="qt">'.$res_i['qt'].'</td><td class="unit">'.$res_i['unit'].'</td><td class="cost">'.$res_i['cost'].'</td>';
            $result.='<td class="curr">'.$res_i['curr'].'</td><td class="term">'.$res_i['term'].'</td><td class="note">'.$res_i['note'].'</td><td><select name="conf['.$res_i['id'].']">';
			foreach($conf as $key=>$value){
				$result.='<option value='.$key.'>'.$value.'</option>';
			}
			
			$result.='</select></tr>';
        }
        return $result;
    }

    public static function orderConfirm($id,$conf,$date)
    {
        switch($conf){
            case 2:
                $deadline=self::deadline($id,$date);
                $db=DB::connect();
                $sql='UPDATE `order` SET `conf`=(?),`dateconf`=(?),`deadline`=(?),`status`=(?),`flag`=0 WHERE `id`=(?);';
                $stmt=$db->prepare($sql);
                $stmt->execute([$conf,$date,$deadline,1,$id]);
                break;
            case 3:
                $db=DB::connect();
                $sql='UPDATE `order` SET `conf`=(?),`dateconf`=(?) WHERE `id`=(?);';
                $stmt=$db->prepare($sql);
                $stmt->execute([$conf,$date,$id]);
                break;
        }
        $s=$stmt->errorInfo();
    }

    public static function createSnabTable()
    {
        self::orderFrost();
        $result='';
        $db=DB::connect();
        $res=$db->query('SELECT `deadline` FROM `order` WHERE `conf`=2 and`flag`=1 and `id_sup`=0 GROUP BY `deadline` ORDER BY `deadline` ASC;');
        while($res_i=$res->fetch()){
            $dline[]=$res_i['deadline'];
        }
        if (isset($dline)) {
            if (isset($_SESSION['exec'])) {
                unset($_SESSION['exec']);
            }
            foreach ($dline as $key => $value) {
                $result .= '<div class="rowOrder">';
                $result .= self::createInputLabel($value);
                $result .= '<div class="colOrderMain">' . self::createTovTable($value, $key) . '</div>';
                $result .= '<div class="colOrderDetail" id="tableDetail' . $key . '"></div>';
                $result .= '</div>';
            }
        }
        return $result;

    }

    public static function setExec($deadline,$tovname,$un,$exec)
    {
        return self::setExecAv($deadline,$tovname,$exec,$un);
    }

    public static function createMyProv()
    {
        $result='<input id="tab2" class="tabs" type="radio" name="tabs" checked><label class="tabs"  for="tab2">В работе</label>';
        $result.='<input id="tab1" class="tabs"  type="radio" name="tabs"><label class="tabs"  for="tab1">На утверждении</label>';
        $result.='<input id="tab3" class="tabs"  type="radio" name="tabs"><label class="tabs"  for="tab3">Отказано</label>';
        $user=(int)$_SESSION['id'];
        $db = DB::connect();
        for ($conf=1;$conf<=3;$conf++){
            $result.='<section id="content'.$conf.'" class="tabs">';
            $sql = 'SELECT `deadline` FROM `order` WHERE `user`=(?) and `conf`=(?) GROUP BY `deadline` ORDER BY `deadline` ASC;';
            $stmt = $db->prepare($sql);
            $stmt->execute([$user, $conf]);
            $s = $stmt->errorInfo();
            while ($res_i = $stmt->fetch()) {
                $result .= '<div class="rowOrder">';
                if ($res_i['deadline']!=null) {
                    $result .= self::createInputLabel($res_i['deadline']);
                }
                $result .= '<div class="colOrderAll">' . self::createMyTable($user, $res_i['deadline'], $conf) . '</div>';
                $result .= '</div>';
            }
            $result .= '</section>';
        }
        return $result;
    }

    /* создает таблицу снабженца
     *
     * @return string
     * */
    public static function createExecTable()
    {
        $result='';
        $exec=self::getExecId();
        $dline=self::getExecDeadline($exec);
        if ($dline!=null) {
            foreach ($dline as $key => $value) {
                $result .= '<div class="rowOrder">';
                $result .= self::createInputLabel($value);
                $result .= '<div class="colOrderAll">' . self::getExecTable($exec, $value) . '</div>';
                $result .= '</div>';
            }
        }
        return $result;
    }

    private static function getExecId()
    {
        if (isset($_SESSION['id'])){
            $db=DB::connect();
            $sql='SELECT `id` FROM `executor` WHERE `id_user`=(?);';
            $stmt=$db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);
            $res=$stmt->fetch();
            return $res['id'];
        }
        else{
            Route::ErrorPage404();
        }
    }

    private static function getExecTable($exec,$deadline)
    {
        $result='<table class="bordered"><tr><th colspan="5">Заказ</th><th colspan="2">Оценка</th></tr>';
        $result.='<tr><th>Наименование</th><th>Кол-во</th><th>Ед.изм</th><th>Цена max</th><th>Валюта</th>';
        $result.='<th>Цена</th><th>Валюта</th></tr>';
        $db=DB::connect();
        $sql='select `order_supply`.`id`, `order`.`tovname`,';
        $sql.='sum(`order`.`qt`) as `qt`,`units`.`caption` as `unit`,max(`order`.`cost`) as `cost`,';
        $sql.='`currency`.`caption` as `curr` from `order_supply`';
        $sql.='inner join `order` on `order`.`id_sup`=`order_supply`.`id`';
        $sql.='inner join `units` on `units`.`id`=`order`.`unit`';
        $sql.='inner join `currency` on `currency`.`id`=`order`.`curr`';
        $sql.='where `order_supply`.`exec` = (?) and `order`.`deadline`=(?)';
        $sql.='group by tovname,deadline,curr,unit,id;';
        $stmt=$db->prepare($sql);
        $stmt->execute([$exec,$deadline]);
        while($res_i=$stmt->fetch()){
            $result.='<tr><td class="tovname">'.$res_i['tovname'].'</td><td  class="qt">'.$res_i['qt'].'</td>';
            $result.='<td class="unit">'.$res_i['unit'].'</td><td class="cost">'.$res_i['cost'].'</td>';
            $result.='<td class="curr">'.$res_i['curr'].'</td>';
            $result.='<td class="cost"><input type="number" name="data[' . $res_i['id'] . '][cost]" step="any"></td>';
            $result.='<td class="curr"><select name="data[' . $res_i['id'] . '][curr]">';
            foreach (self::getCurrency() as $value) {
                $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
            }
            $result.='</select></td></tr>';
        }
        $result.='</table>';
        return $result;
    }

    private static function createTovTable($value,$key)
    {
        $result='<table class="bordered"><th>Товар</th><th>Кол-во</th><th>Ед.изм</th><th>Исполнитель</th>';
        $db=DB::connect();
        $sql='SELECT `order`.`tovname`,sum(`order`.`qt`) as `qt`,`units`.`caption` as `unit`,`order`.`unit` as `un` from `order` ';
        $sql.='inner join `units` on `units`.`id`=`order`.`unit`';
        $sql.='where `order`.`conf`=2 and `flag`=1 and `id_sup`=0 and `order`.`deadline`=(?) group by `tovname`,`unit`;';
        $stmt=$db->prepare($sql);
        $stmt->execute([$value]);
        $s=$db->errorInfo();
        while($res_i=$stmt->fetch()){
            $jq="'$value','$res_i[tovname]','$res_i[un]',$key";
            $result.='<tr><td class="tovname hov"  onclick="getTableDetail('.$jq.')">'.$res_i['tovname'].'</td>';
            $result.='<td class="qt">'.$res_i['qt'].'</td><td class="unit">'.$res_i['unit'].'</td>';
            $_SESSION['exec'][]=[$value,$res_i['tovname'],$res_i['un']];
            $result.='<td class="exec"><select name="exec[]"><option value="0">--Выберите--</option>';
            $res=$db->query('SELECT * FROM `executor`;');
            while($exec=$res->fetch()){
                $result.='<option value="'.$exec['id'].'">'.$exec['exec'].'</option>';
            }
            $result.='</select></td></tr>';
        }
        $result.='</table>';
        return $result;
    }

    public static function getTableDetail($date,$tov,$un){
        $db=DB::connect();
        $sql='SELECT `dept`.`dept` as `dept`,sum(`order`.`qt`) as qt,`units`.`caption`as `unit`,MAX(`order`.`cost`) as `cost`,`currency`.`caption` as `curr` from `order`';
        $sql.='inner join `users` on `users`.`id`=`order`.`user`';
        $sql.='inner join `dept` on `dept`.`id`=`users`.`dept`';
        $sql.='inner join `units` on `units`.`id`=`order`.`unit`';
        $sql.='inner join `currency` on `currency`.`id`=`order`.`curr`';
        $sql.='where `order`.`conf`=2 and `order`.`deadline`=(?) and `order`.`tovname`=(?) and `order`.`unit`=(?) group by dept,unit,curr;';
        $stmt=$db->prepare($sql);
            $detail='<table class="bordered">';
            $detail.='<th>Отдел</th><th>Кол-во</th><th>Ед.изм</th><th>Цена max</th><th>Валюта</th><th>Примечание</th>';
            $stmt->execute([$date,$tov,$un]);
            $s=$stmt->errorInfo();
            while($res_i=$stmt->fetch()){
                $res=$db->query('SELECT `note` FROM `order` WHERE `tovname`="'.$tov.'" and `deadline`="'.$date.'";');
                $s=$stmt->errorInfo();
                while($res_n=$res->fetch()){
                    if ($res_n['note']!=''){
                        $note[]=$res_n['note'];
                    }
                }
                if (isset($note)){
                    $note=implode(',',$note);
                }
                $detail.='<tr><td class="dept">'.$res_i['dept'].'</td><td class="qt">'.$res_i['qt'].'</td>';
                $detail.='<td class="unit">'.$res_i['unit'].'</td><td class="cost">'.round($res_i['cost'],2).'</td>';
                $detail.='<td class="curr">'.$res_i['curr'].'</td><td class="note">'.$note.'</td></tr>';
                unset ($note);
            }
            $detail.='</table>';

        return $detail;

    }

    private static function getExecDeadline($exec)
    {
        $dline=null;
        $sql='select `order`.`deadline` from `order_supply`';
        $sql.='inner join `order` on `order`.`id_sup`=`order_supply`.`id`';
        $sql.='where `order_supply`.`exec`=(?)';
        $sql.='group by `deadline`;';
        $db=DB::connect();
        $stmt=$db->prepare($sql);
        $stmt->execute([$exec]);
        while($res_i=$stmt->fetch()){
            $dline[]=$res_i['deadline'];
        }
        return $dline;
    }

    private static function deadline($id,$date)
    {
        $db=DB::connect();
        $sql='SELECT `term` FROM `order` WHERE `id`=(?);';
        $stmt=$db->prepare($sql);
        $stmt->execute([$id]);
        $res=$stmt->fetch();
        $term=$res['term'];
        $res=$db->query('SELECT `id`,`strtotime` FROM term;');
        while($res_i=$res->fetch()){
            if($res_i['id']==$term){
                if($res_i['strtotime']=='3'){
                    $wday=date('N',strtotime($date));
                    if ($wday<3){
                        $result=date('Y.m.d',strtotime('next Friday',strtotime($date)));
                    }
                    else{
                        $result=date('Y.m.d',strtotime('next Wednesday',strtotime($date)));
                    }
                }
                else{
                    $result=date('Y.m.d',strtotime($res_i['strtotime'],strtotime($date)));
                }
            }
        }
        return $result;
    }

    private static function createInputLabel($value)
    {
        $day=date('Y-m-d',strtotime('+3 day'));
        $class='colOrderDate';
        if ($day>=$value){
            $class='colOrderDate alert';
        }
        $value=date('d.m.Y',strtotime($value));
        $result='<div class="'.$class.'">'.$value.'</div>';
        return $result;
    }

    private static function orderFrost()
    {
        $db=DB::connect();
        $db->exec('UPDATE `order` SET `flag`=1,`id_sup`=0 WHERE `flag`=0;');
    }

    private static function setExecAv($deadline,$tovname,$exec,$un)
    {
        $result=true;
        $db=DB::connect();
        $sql='select `order_supply`.`id` from `order_supply`';
        $sql.='inner join `order` on `order`.`id_sup`=`order_supply`.`id`';
        $sql.='where `order`.`deadline`=(?) and `order`.`tovname`=(?)';
        $sql.='and `order`.`unit`=(?) and `order_supply`.`exec`=(?) group by `id`;';
        $stmt=$db->prepare($sql);
        $stmt->execute([$deadline,$tovname,$un,$exec]);
        $s=$stmt->errorInfo();
        $res=$stmt->fetch();
        if ($res){
            $id=$res['id'];
            $sql='UPDATE `order` SET `id_sup`=(?),`status`=2 WHERE `deadline`=(?) and `tovname`=(?) and `unit`=(?) and `flag`=1 and `id_sup`=0;';
            $stmt=$db->prepare($sql);
            $stmt->execute([$id,$deadline,$tovname,$un]);
            $s=$stmt->errorInfo();
            if($s[2]!=null){
                $result=false;
            }
        }
        else{
            $sql='INSERT INTO `order_supply` (`exec`) VALUES(?)';
            $db->beginTransaction();
            $stmt=$db->prepare($sql);
            $stmt->execute([$exec]);
            $s=$stmt->errorInfo();
            if($s[2]!=null){
                $result=false;
            }
            $id=$db->lastInsertId();
            $sql='UPDATE `order` SET `id_sup`=(?),`status`=2 WHERE `deadline`=(?) and `tovname`=(?) and `unit`=(?) and `flag`=1 and `id_sup`=0;';
            $stmt=$db->prepare($sql);
            $stmt->execute([$id,$deadline,$tovname,$un]);
            $s=$stmt->errorInfo();
            if($s[2]!=null){
                $result=false;
            }
            if ($result){
                $db->commit();
            }
            else{
                $db->rollBack();
            }
        }
        return $result;
    }

    private static function createMyTable($user,$dline,$conf)
    {
        $db=DB::connect();
        $result='<table class="bordered">';
        switch ($conf){
            case 1:
                $result.='<th>Дата заявки</th><th>Наименование</th><th>Кол-во</th><th>Ед.изм</th><th>Цена</th><th>Валюта</th>';
                $sql='SELECT `order`.`datetime`,`order`.`tovname`,`order`.`qt`,';
                $sql.='`units`.`caption` as `unit`,`order`.`cost`,`currency`.`caption` as `curr` FROM `order`';
                $sql.='INNER JOIN `units` on `units`.`id`=`order`.`unit`';
                $sql.='INNER JOIN `currency` on `currency`.`id`=`order`.`curr`';
                $sql.='WHERE `order`.`user`=(?) and `order`.`conf`=(?)';
                $stmt=$db->prepare($sql);
                $stmt->execute([$user,$conf]);
                $s=$stmt->errorInfo();
                while ($res_i=$stmt->fetch()){
                    $result.='<tr><td class="date">'.date('d.m.Y',strtotime($res_i['datetime'])).'</td>';
                    $result.='<td class="tovname">'.$res_i['tovname'].'</td><td class="qt">'.$res_i['qt'].'</td>';
                    $result.='<td class="unit">'.$res_i['unit'].'</td><td class="cost">'.$res_i['cost'].'</td>';
                    $result.='<td class="curr">'.$res_i['curr'].'</td></tr>';
                }
                break;
            case 2:
                $result.='<th>Наименование</th><th>Кол-во</th><th>Ед.изм</th><th>Статус</th>';
                $sql='SELECT `order`.`tovname`,sum(`order`.`qt`) as `qt`,';
                $sql.='`units`.`caption` as `unit`,';
                $sql.='`status`.`caption` as `status` FROM `order`';
                $sql.='INNER JOIN `units` on `units`.`id`=`order`.`unit`';
                $sql.='INNER JOIN `status` on `status`.`id`=`order`.`status`';
                $sql.='WHERE `order`.`user`=(?) and `order`.`deadline`=(?) and `order`.`conf`=(?)';
                $sql.='group by `deadline`,`tovname`,`unit`,`status`;';
                $stmt=$db->prepare($sql);
                $stmt->execute([$user,$dline,$conf]);
                $s=$stmt->errorInfo();
                while ($res_i=$stmt->fetch()){
                    $result.='<tr><td class="tovname">'.$res_i['tovname'].'</td><td class="qt">'.$res_i['qt'].'</td>';
                    $result.='<td class="unit">'.$res_i['unit'].'</td><td>'.$res_i['status'].'</td></tr>';
                }
                break;
            case 3:
                $result.='<th>Дата заявки</th><th>Наименование</th><th>Кол-во</th><th>Ед.изм</th><th>Цена</th><th>Валюта</th>';
                $sql='SELECT `order`.`datetime`,`order`.`tovname`,`order`.`qt`,';
                $sql.='`units`.`caption` as `unit`,`order`.`cost`,`currency`.`caption` as `curr` FROM `order`';
                $sql.='INNER JOIN `units` on `units`.`id`=`order`.`unit`';
                $sql.='INNER JOIN `currency` on `currency`.`id`=`order`.`curr`';
                $sql.='WHERE `order`.`user`=(?) and `order`.`conf`=(?)';
                $stmt=$db->prepare($sql);
                $stmt->execute([$user,$conf]);
                $s=$stmt->errorInfo();
                while ($res_i=$stmt->fetch()){
                    $result.='<tr><td class="date">'.date('d.m.Y',strtotime($res_i['datetime'])).'</td>';
                    $result.='<td class="tovname">'.$res_i['tovname'].'</td><td class="qt">'.$res_i['qt'].'</td>';
                    $result.='<td class="unit">'.$res_i['unit'].'</td><td class="cost">'.$res_i['cost'].'</td>';
                    $result.='<td class="curr">'.$res_i['curr'].'</td></tr>';
                }
                break;

        }
        $result.='</table>';
        return $result;
    }

    private static function getUnits()
    {
        $db = DB::connect();
        $res = $db->query('SELECT * FROM units;');
        while ($res_i = $res->fetch()) {
            $unit[] = $res_i;
        }
        return $unit;
    }

    private static function getCurrency()
    {
        $db = DB::connect();
        $res = $db->query('SELECT * FROM currency;');
        while ($res_i = $res->fetch()) {
            $cur[] = $res_i;
        }
        return $cur;
    }

    private static function getTerm()
    {
        $db = DB::connect();
                $res = $db->query('SELECT * FROM term;');
        while ($res_i = $res->fetch()) {
            $term[] = $res_i;
        }
        return $term;
    }
}