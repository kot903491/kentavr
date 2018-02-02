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
        $c=1;
        $d=0;
        $sql='INSERT INTO provision(`datetime`,`user`,`tovname`,`qt`,`unit`,`cost`,`curr`,`term`,`conf`,`note`) VALUES((?),(?),(?),(?),(?),(?),(?),(?),(?),(?));';
        $db->beginTransaction();
        $stmt=$db->prepare($sql);
        foreach ($data as $value) {
            $stmt->bindParam(1, $dat);
            $stmt->bindParam(2, $id);
            $stmt->bindParam(3, $value['tovname']);
            $stmt->bindParam(4, $value['qt']);
            $stmt->bindParam(5, $value['unit']);
            if ($value['cost'] != '') {
                $stmt->bindParam(6, $value['cost']);
            } else {
                $stmt->bindParam(6, $d);
            }
            $stmt->bindParam(7, $value['cur']);
            $stmt->bindParam(8, $value['term']);
            $stmt->bindParam(9, $c);
            $stmt->bindParam(10, $value['note']);
            $stmt->execute();
            $id++;
            $s=$db->lastInsertId();
            if($s==0){
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
}