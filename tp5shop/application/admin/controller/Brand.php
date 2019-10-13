<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Catemodel;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Cate extends Common
{

    public function index()
    {
        $catemodel=new Catemodel();
        $cates=$catemodel->getCates();
        return view('',["cates"=>$cates]);
    }

    public function add()
    {
        $catemodel=new Catemodel();
        if( Request::isGet()){
            $cates=$catemodel->getCates();
            return view('',["cates"=>$cates]);
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            $validate=$this->validate(
                [
                    'cate_name'=>$data['cate_name'],
                    'cate_order'=>$data['cate_order'],
                    'cate_pid'=>$data['cate_pid']

                ],
                'app\admin\validate\Cate'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            //入库
            $cate=$catemodel->addCate($data);
            if($cate){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
    }
}

