<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/16
 * Time: 8:44
 */
namespace app\admin\service;

use app\admin\model\Attr;
use app\admin\model\Type;
use think\Db;


class AttrService{
//取所有得分类
    public function getTypes(){
        $types=new Type();
        $types = $types->all();
        return $types;
    }
    public function getType($type_id){
        $type=new Type();
        $type = $type->get($type_id);
        return $type;
    }
    //取所有的属性
    public function getAttrs(){
        $attrs=Db::table('shop_attr')
            ->alias('a')
            ->join(['shop_type'=>'t'],'a.type_id=t.type_id')
            ->select();
        return $attrs;
    }
    public function addAttr($data){
        $attr=new Attr();
        $attr=$attr->save($data);
        return $attr;
    }
}