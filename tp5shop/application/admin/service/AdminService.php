<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/15
 * Time: 21:14
 */
namespace app\admin\service;
use app\admin\model\Admin;
use app\admin\model\AdminRole;
use app\admin\model\Power;
use app\admin\model\Role;
use think\facade\Session;

class AdminService{
    public function getAdmins(){
        //取所有的管理员
        $admins=new Admin();
        return $admins->all();
    }
    //添加管理员
    public function addAdmin($data){
        $admin= new Admin;
        $admin = $admin->save($data);
        return $admin;
    }
    //获取所有角色
    public function getroles(){
        $roles=new Role();
        return $roles->all();
    }
    //取当前管理员id的所有权限
    public function getpowerbyadminid($admin_id){
        $adminrole=new AdminRole();
        $role_id=$adminrole->where("admin_id",$admin_id)->column("role_id");
        $role=new Role();
        $role=$role->all($role_id);
        $mypower=[];
        foreach($role as $key=>$val){
            $mypower=array_merge($mypower,$val->power->toArray());
        }
        $myaccess=[];
        foreach($mypower as $k=>$v){
            array_push($myaccess,ucfirst(strtolower($v['power_controller']))."/".strtolower($v['power_action']));
        }
        $myaccess=array_unique($myaccess);
        return $myaccess;

    }
    //取左侧菜单
    public function getMu(){
        $currentAdmin=Session::get("admin");
        //检测当前是否为超级管理员
        if(in_array($currentAdmin["admin_name"],config("config.super_admin"))) {
            $power=new Power();
            $mu=$power->where("power_ismu",1)->all()->toArray();
        }else{
            $admin_id=Session::get("admin")["admin_id"];
            $admin=new Admin();
            $admin=$admin->get($admin_id);
            $mu=[];
            foreach($admin->role as $key=>$val){
                $mu=array_merge($mu,$val->power->where("power_ismu",1)->toArray());
            }
        }
        return $mu;
    }
    public function getMuTree($mu,$pid=0){
        $muTree=[];
        foreach($mu as $key=>$val){
            if($val["power_pid"]==$pid){
                if($son=$this->getMuTree($mu,$val['power_id'])){
                    $val["son"]=$son;
                }
                $muTree[]=$val;
            }
        }
        return $muTree;
    }
}