<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/15
 * Time: 21:14
 */
namespace app\admin\service;
use app\admin\model\Admin;
use app\admin\model\Role;

class AdminService{
    public function getAdmins(){
        //取所有的管理员
        $admins=new Admin();
        return $admins->all();
    }
    public function addAdmin($data){
        $admin= new Admin;
        $admin = $admin->save($data);
        return $admin;
    }
    public function getroles(){
        $roles=new Role();
        return $roles->all();
    }
}