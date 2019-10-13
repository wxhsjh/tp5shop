<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 11:49
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class Catemodel extends Model{
    protected $pk ="cate_id";
    //取所有得分类
    public function getCates(){
        $cates=Db::table("shop_cate")->select();
        return $this->getOrderCate($cates);
    }
    public function getOrderCate($cates,$pid=0,$level=0){
        $orderCate=[];
        foreach($cates as $key=>$val){
            //dump($val);
            if($val["cate_pid"]==$pid){
                $val["level"]=$level;
                $orderCate[]=$val;
                $orderCate=array_merge($orderCate,$this->getOrderCate($cates,$val["cate_id"],$level+1));
            }
        }
        return $orderCate;
    }
    public function addCate($data){
        $cate=Db::table("shop_cate")->insert($data);
        return $cate;
    }
}