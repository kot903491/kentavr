<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 01.02.18
 * Time: 0:35
 */
$i=$_POST['i'];
$result='<div><input type="text" name="data['.$i.'][\'tovname\']" required></div>
            <div class="num"><input type="number" name="data['.$i.'][\'qt\']" required></div>
            <div class="unit"><select name="data['.$i.'][\'unit\']">
                    <option>шт</option>
                    <option>кг</option>
                    <option>комплект</option>
                    <option>литр</option>
                </select></div>
            <div class="cost"><input type="number" name="data['.$i.'][\'cost\']" required></div>
            <div class="cur"><select name="data['.$i.'][\'cur\']">
                    <option>тенге</option>
                    <option>рубль</option>
                    <option>доллар</option>
                    <option>евро</option>
                </select></div>
            <div class="term"><select name="data['.$i.'][\'term\']">
                    <option>1-3 дня</option>
                    <option>Неделя</option>
                    <option>2 недели</option>
                    <option>Месяц</option>
                </select></div>
            <div><input type="text" name="data['.$i.'][\'note\']"></div>';
echo $result;