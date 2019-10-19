<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\Catemodel;
use app\admin\service\TypeService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Goods extends Common
{

    public function index()
    {
        $catemodel=new Catemodel();
        $cates=$catemodel->getCates();
        return view('',["cates"=>$cates]);
    }

    public function add()
    {
        if( Request::isGet()){
            $catemodel=new Catemodel();
            $cates=$catemodel->getCates();
            $brand=new Brand();
            $brands=$brand->getBrands();
            $type=new TypeService();
            $types=$type->getTypes();
            return view('',["cates"=>$cates,"brands"=>$brands,"types"=>$types]);
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            dump($data);exit;
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

    public function ajax(){
        $type_id=request()->post("type_id");
        $attr=new Attr();
        $attrs=$attr->where("type_id",$type_id)->all();
        foreach($attrs as $key=>$val){
            if(!empty($val["attr_select"])){
                $attrs[$key]["attr_select"]=explode(',', $val["attr_select"]);
            }
        }
        if($attrs){
            echo json_encode(["status"=>1,"msg"=>"ok","attrs"=>$attrs]);
        }else{
            echo json_encode(["status"=>0,"msg"=>"no ok"]);
        }
    }
}

