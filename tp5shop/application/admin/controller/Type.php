<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\service\TypeService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;


class Type extends Common
{

    public function index()
    {
        $types=new TypeService();
        $types=$types->getTypes();
        return view('',["types"=>$types]);
    }

    public function add()
    {
        if( Request::isGet()){
            return view('');
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            dump($data);
            $type=new TypeService();
            $type=$type->addType($data);
            if($type){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
    }
}

