<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/15
 * Time: 11:26
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Role extends Model{
    public static function addRole($data){
        $role=Db::table("shop_role")->insert($data);
        return $role;
    }
    public static function getRole(){
        $roles=Db::table("shop_role")->select();
        return $roles;
    }
}