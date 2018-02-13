<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 02.02.18
 * Time: 11:25
 */

class Provision
{
    static public function addTR($i = 0)
    {
        $db = DB::connect();
        $res = $db->query('SELECT * FROM units;');
        while ($res_i = $res->fetch()) {
            $unit[] = $res_i;
        }
        $res = $db->query('SELECT * FROM currency;');
        while ($res_i = $res->fetch()) {
            $cur[] = $res_i;
        }
        $res = $db->query('SELECT * FROM term;');
        while ($res_i = $res->fetch()) {
            $term[] = $res_i;
        }
        $result = '<div><input type="text" name="data[' . $i . '][tovname]" required></div>
            <div class="num"><input type="number" name="data[' . $i . '][qt]" required></div>
            <div class="unit"><select name="data[' . $i . '][unit]">';
        foreach ($unit as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div class="cost"><input type="number" name="data[' . $i . '][cost]" step="any"></div>
            <div class="cur"><select name="data[' . $i . '][cur]">';
        foreach ($cur as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div class="term"><select name="data[' . $i . '][term]">';
        foreach ($term as $value) {
            $result .= '<option value="' . $value['id'] . '">' . $value['caption'] . '</option>';
        }
        $result .= '</select></div>
            <div><input type="text" name="data[' . $i . '][note]"></div>';
        return $result;
    }

    static public function orderAdd($id, $data)
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

    static public function createConfirmTable()
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

    static public function orderConfirm($id,$conf,$date)
    {
        switch($conf){
            case 2:
                $deadline=Provision::deadline($id,$date);
                $db=DB::connect();
                $sql='UPDATE `order` SET `conf`=(?),`dateconf`=(?),`deadline`=(?),`status`=(?) WHERE `id`=(?);';
                $stmt=$db->prepare($sql);
                $stmt->execute([$conf,$date,$deadline,1,$id]);
                break;
            case 3:
                $db=DB::connect();
                $sql='UPDATE `order` SET `conf`=(?),`dateconf`=(?) WHERE `id`=(?);';
                $stmt=$db->prepare($sql);
                $stmt->execute([$conf,$date,1,$id]);
                break;
        }
        $s=$stmt->errorInfo();
    }

    static public function createSnabTable()
    {
        $result='';
        $db=DB::connect();
        $res=$db->query('SELECT `deadline` FROM `order` WHERE `conf`=2 GROUP BY `deadline` ORDER BY `deadline` ASC;');
        while($res_i=$res->fetch()){
            $dline[]=$res_i['deadline'];
        }
        foreach($dline as $key=>$value){
            $result.='<div class="rowOrder">';
            $result.=Provision::createInputLabel($value);
            $result.='<div class="colOrderMain">'.Provision::createTovTable($value,$key).'</div>';
            $result.='<div class="colOrderDetail" id="tableDetail'.$key.'"></div>';
            $result.='</div>';
        }
        return $result;

    }

    public static function createTovTable($value,$key)
    {
        $result='<table class="bordered"><th>Товар</th><th>Кол-во</th><th>Ед.изм</th><th>Исполнитель</th>';
        $db=DB::connect();
        $sql='SELECT `order`.`tovname`,sum(`order`.`qt`) as `qt`,`units`.`caption` as `unit` from `order` ';
        $sql.='inner join `units` on `units`.`id`=`order`.`unit`';
        $sql.='where `order`.`conf`=2 and `order`.`deadline`=(?) group by `tovname`,`unit`;';
        $stmt=$db->prepare($sql);
        $stmt->execute([$value]);
        $s=$db->errorInfo();
        while($res_i=$stmt->fetch()){
            $jq="'$value','$res_i[tovname]',$key";
            $result.='<tr><td class="tovname hov"  onclick="getTableDetail('.$jq.')">'.$res_i['tovname'].'</td>';
            $result.='<td class="qt">'.$res_i['qt'].'</td><td class="unit">'.$res_i['unit'].'</td>';
            $result.='<td class="exec"><select name="dist['.$value.']['.$res_i['tovname'].']"><option value="1">Снабженец</option><option value="2">Нач.снабжения</option></select></td></tr>';
        }
        $result.='</table>';
        return $result;
    }

    public static function getTableDetail($date,$tov){
        $db=DB::connect();
        $sql='SELECT `dept`.`dept` as `dept`,sum(`order`.`qt`) as qt,`units`.`caption`as `unit`,MAX(`order`.`cost`) as `cost`,`currency`.`caption` as `curr` from `order`';
        $sql.='inner join `users` on `users`.`id`=`order`.`user`';
        $sql.='inner join `dept` on `dept`.`id`=`users`.`dept`';
        $sql.='inner join `units` on `units`.`id`=`order`.`unit`';
        $sql.='inner join `currency` on `currency`.`id`=`order`.`curr`';
        $sql.='where `order`.`conf`=2 and `order`.`deadline`=(?) and `order`.`tovname`=(?) group by dept,unit,curr;';
        $stmt=$db->prepare($sql);
            $detail='<table class="bordered">';
            $detail.='<th>Отдел</th><th>Кол-во</th><th>Ед.изм</th><th>Цена max</th><th>Валюта</th><th>Примечание</th>';
            $stmt->execute([$date,$tov]);
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
        $result='<div class="'.$class.'">'.$value.'</div>';
        return $result;
    }
}