<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/16
 * Time: 8:44
 */
namespace app\admin\service;

use app\admin\model\Power;

class PowerService{
//取所有得分类
    public function getPowers(){
        $powers=new Power();
        $powers = $powers->all();
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
        $power=new Power();
        $power=$power->save($data);
        return $power;
    }
}