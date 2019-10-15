<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Powermodel;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Power extends Common
{

    public function index()
    {
        $powermodel=new Powermodel();
        $powers=$powermodel->getPowers();
        return view('',["powers"=>$powers]);
    }

    public function add()
    {
        $powermodel=new Powermodel();
        if( Request::isGet()){
            $powers=$powermodel->getPowers();
            return view('',["powers"=>$powers]);
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            $validate=$this->validate(
                [
                    'power_name'=>$data['power_name'],
                    'power_pid'=>$data['power_pid']

                ],
               'app\admin\validate\Power'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            //入库
            $power=$powermodel->addPower($data);
            if($power){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
    }
}

