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

class Goods extends Model{
    protected $pk ="goods_id";
    public function attr()
    {
        return $this->belongsToMany('Attr',"goods_attr","attr_id","goods_id");
    }
    public function product()
    {
        return $this->hasMany('Product','goods_id');
    }
    public function photo()
    {
        return $this->hasMany('Photo','goods_id');
    }
    public function brand()
    {
        return $this->hasMany('Brand','goods_id');
    }
    public function cate()
    {
        return $this->belongsToMany('Cate',"goods_cate","cate_id","goods_id");
    }
}