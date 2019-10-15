<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Powermodel;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Role extends Common
{

    public function index()
    {
        $roles=\app\admin\model\Role::getRole();
        return view('',["roles"=>$roles]);
    }

    public function add()
    {
        $powermodel=new Powermodel();
        if( Request::isGet()){
            $powers=$powermodel->getPowers();
            return view('',["powers"=>$powers]);
        }elseif(Request::isPost()){
            //接值
            $data["role_name"] = request()->post("role_name","");
            $power=request()->post("power","");
            $powers=implode(",",$power);
            $data["role_power_list"]=$powers;
            //入库
            $role=\app\admin\model\Role::addRole($data);
            $role_id=Db::table("shop_role")->where("role_name",$data["role_name"])->find();
            foreach($power as $key=>$val){
                $power_id=Db::table("shop_power")->where("power_name",$val)->find();
                $shop_role_power=Db::table("shop_role_power")
                    ->insert(["role_id"=>$role_id["role_id"],"power_id"=>$power_id["power_id"]]);
            }
            if($role&&$shop_role_power){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
    }
}

