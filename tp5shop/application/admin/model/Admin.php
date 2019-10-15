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

class Admin extends Model{
    protected $pk ="admin_id";
    //取所有的管理员
    public static function getAdmins(){
        $admins=Db::table("shop_admin")->select();
        return $admins;
    }
    public static function addAdmin($data){
        $admin=Db::table("shop_admin")->insert($data);
        return $admin;
    }
    public static function getroles(){
        $roles=Db::table("shop_role")->select();
        return $roles;
    }
}