<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;


class Login extends Controller
{
    public function login()
    {
        if( Request::isGet()){
            return view();
        }elseif(Request::isPost()){
            //验证验证码
//            $code = Request::post('code');
//            $captcha = new Captcha();
//            if( !$captcha->check($code))
//            {
//                $this->error('验证码错误');
//            }
            //接值
            $admin_name = Request::post('admin_name');
            $admin_pwd = Request::post('admin_pwd');
            $save=Request::post('save')?1:0;
            //验证值
            $data = [
                'admin_name'  => $admin_name,
                'admin_pwd'  => $admin_pwd
            ];
            $validate = Validate::make([
                'admin_name'  => 'require|length:5,15',
                'admin_pwd'  => 'require'
            ]);
            if (!$validate->check($data)) {
                $this->error('用户名或密码不符合规定');
            }
            //数据库查询
            $admin=\app\admin\model\Login::login($admin_name,$admin_pwd);
            if($admin){
                if ($save) {
                    Cookie::set("admin",$admin,7*24*3600,"/admin");
                }
                Session::set('admin',$admin);
                $this->success('登录成功','Index/index');
            }else{
                $this->error('登录失败');
            }
        }
    }
    public function loginout()
    {
        Session::delete('admin');
        Cookie::delete('admin');
        $this->success("退出成功","login");
    }
}


