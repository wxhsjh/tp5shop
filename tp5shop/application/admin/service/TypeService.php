<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/16
 * Time: 8:44
 */
namespace app\admin\service;

use app\admin\model\Type;

class TypeService{
//取所有得类型
    public function getTypes(){
        $types=new Type();
        $types = $types->all();
        return $types;
    }
    public function addType($data){
        $type=new Type();
        $type=$type->save($data);
        return $type;
    }
}