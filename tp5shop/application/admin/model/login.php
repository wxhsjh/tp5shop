<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 11:47
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class Login extends Model{
    public static function login($admin_name,$admin_pwd){
        $sult = Db::table("shop_admin")->field("admin_sult")->where("admin_name",$admin_name)->find();
        $admin_sult=implode($sult);
        $admin_pwd=md5(md5($admin_pwd).$admin_sult);
        $admin = Db::table("shop_admin")->field("admin_id,admin_name")->where('admin_name',$admin_name)->where('admin_pwd',$admin_pwd)->find();
        return $admin;
    }
}