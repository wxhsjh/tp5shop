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

class Powermodel extends Model{
    protected $pk ="power_id";
    //取所有得分类
    public function getPowers(){
        $powers=Db::table("shop_power")->select();
        return $this->getOrderPower($powers);
    }
    public function getOrderPower($powers,$pid=0,$level=0){
        $orderPower=[];
        foreach($powers as $key=>$val){
            //dump($val);
            if($val["power_pid"]==$pid){
                $val["level"]=$level;
                $orderPower[]=$val;
                $orderPower=array_merge($orderPower,$this->getOrderPower($powers,$val["power_id"],$level+1));
            }
        }
        return $orderPower;
    }
    public function addPower($data){
        $power=Db::table("shop_power")->insert($data);
        return $power;
    }
}