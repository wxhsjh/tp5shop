<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\service\AdminService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Admin extends Common
{
    public function index()
    {
        $admins=new AdminService();
        $admins=$admins->getAdmins();
        return view('',["admins"=>$admins]);
    }
    public function add()
    {
        if( Request::isGet()){
            $admins=new AdminService();
            $admins=$admins->getAdmins();
            $roles=new AdminService();
            $roles=$roles->getroles();
            return view('',["admins"=>$admins,"roles"=>$roles]);
        }elseif(Request::isPost()){
            //接值
            $admin_action_list=request()->post("admin_role","");
            $data["admin_name"] = request()->post("admin_name","");
            $admin_pwd=request()->post("admin_pwd","");
            $admin_repwd=request()->post("admin_repwd","");
            $validate=$this->validate(
                [
                    'admin_name'=>$data['admin_name'],
                    'admin_pwd'=>$admin_pwd,
                    'admin_repwd'=>$admin_repwd

                ],
                'app\admin\validate\Admin'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            if($admin_pwd!==$admin_repwd){
                $this->error("确认密码错误");
            }
            $admin_sult=substr(uniqid(),-4);
            $data["admin_pwd"]=md5(md5($admin_pwd).$admin_sult);
            $data["admin_sult"]=$admin_sult;
            //入库
            $admins=new AdminService();
            $admin=$admins->addAdmin($data);
            $admin_id=Db::table("shop_admin")->where("admin_name",$data["admin_name"])->find();
            foreach($admin_action_list as $key=>$val){
                $shop_admin_role=Db::table("shop_admin_role")
                    ->insert(["admin_id"=>$admin_id["admin_id"],"role_id"=>$val]);
            }
            if($admin&&$shop_admin_role){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
    }
}

