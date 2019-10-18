<?php
namespace app\admin\controller;
use app\admin\service\AdminService;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;

class common extends Controller{
    public function __construct()
    {
        parent::__construct();
        $cookie=Cookie::get("admin");
        $session=Session::get("admin");
        if($cookie&&!$session){
            $session=$cookie;
            Session::set("admin",$cookie);
        }
        if(!$cookie&&!$session){
            $this->error("请先登录");
        }
        if(!$this->checkPower()){
            if(request()->isAjax()){
                return ["status"=>-1,"msg"=>"没有权限操作"];
            }else{
                $this->success("你没有权限操作",'Index/index');
            }
        }
        $adminService=new AdminService();
        $mu=$adminService->getMu();
        $mu=$adminService->getMuTree($mu);
        View::share(["mu"=>$mu]);
    }
    public function checkPower(){
        $currentAdmin=Session::get("admin");
        //检测当前是否为超级管理员
        if(in_array($currentAdmin["admin_name"],config("config.super_admin"))){
            return true;
        }
        //不是超级管理员进行检测
        //取要访问的控制器方法
        $access=ucfirst(strtolower(request()->controller()))."/".strtolower(request()->action());
        if(in_array($access,config("config.no_check_power"))){
            return true;
        }
        //获取当前用户的权限
        $adminService=new AdminService();
        $mypower=$adminService->getpowerbyadminid(Session::get("admin")['admin_id']);
        if(in_array($access,$mypower)){
            return true;
        }else{
            $this->success("您没有操作权限","Index/index");
        }
    }
}