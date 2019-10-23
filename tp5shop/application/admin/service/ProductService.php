<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/16
 * Time: 8:44
 */
namespace app\admin\service;

use app\admin\model\Goods;
use think\Db;


class ProductService{
//取所有得货品
    public function getProduct($goods_id){
        $good=Goods::get($goods_id);
        $goods=$good->product;
        return $goods;
    }
    public function getAttr($goods_id){
        $goods = Goods::get($goods_id);
        $goods->attr;
        //dump($goods["attr"]);
        foreach($goods["attr"] as $key=>$val){
            if ($val["pivot"]["attr_price"]!==null){
                $attr_name[$val["attr_name"]][$val["pivot"]["goods_attr_id"]] = $val["pivot"]["attr_val"];

            }
        }
        return $attr_name;
        }
}