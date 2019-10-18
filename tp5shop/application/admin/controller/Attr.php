<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\service\AttrService;
use app\admin\service\PowerService;
use app\admin\service\TypeService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Attr extends Common
{

    public function index()
    {
        $type_id=request()->get("type_id","");
        $attrService=new AttrService();
        $groups=$attrService->getTypes();
        $group=$attrService->getType($type_id);
        $attrs=$attrService->getAttrs();
        return view('',["group"=>$group,"groups"=>$groups,"attrs"=>$attrs]);
    }

    public function add()
    {
        if( Request::isGet()){
            $type_id=request()->get("type_id","");
            $attrService=new AttrService();
            $group=$attrService->getType($type_id);
            //$type_group=explode(',', $group["type_group"]);
            $groups=$attrService->getTypes();
            return view('',["groups"=>$groups,"group"=>$group]);
        }
        elseif(Request::isPost()){
            //接值
            $data = input("post.");
            //入库
            $attr=new AttrService();
            $attr=$attr->addAttr($data);
            if($attr){
                $type=Db::table("shop_type")->where("type_id",$data["type_id"])->find();
                $attr_num=($type["attr_num"])+1;
                Db::table("shop_type")->where("type_id",$data["type_id"])->update(["attr_num"=>$attr_num]);
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }

        }
    }
    public function ajax(){
        $type_id=request()->post("type_id");
        $attrService=new AttrService();
        $group=$attrService->getType($type_id);
        $type_group=explode(',', $group["type_group"]);
        if($type_group){
            echo json_encode(["status"=>1,"msg"=>"ok","content"=>$type_group]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"no ok"]);
        }
    }
    public function ajax1(){
        $type_id=request()->post("type_id");
        $attrService=new AttrService();
        $group=$attrService->getType($type_id);
        $type_group=explode(',', $group["type_group"]);
        if($type_group){
            echo json_encode(["status"=>1,"msg"=>"ok","content"=>$type_group]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"no ok"]);
        }
    }
}

