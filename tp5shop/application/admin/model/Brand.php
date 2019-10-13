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

class Brand extends Model{
    protected $pk ="brand_id";
    //取所有的品牌
    public static function getBrands(){
        $brands=Db::table("shop_brand")->select();
        return $brands;
    }
    public static function addBrand($data){
        $brand=Db::table("shop_brand")->insert($data);
        return $brand;
    }
}