<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\Catemodel;
use app\admin\model\GoodsAttr;
use app\admin\service\GoodsService;
use app\admin\service\TypeService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Product extends Common
{

    public function index()
    {
        $goods_id=request()->get("goods_id","");
        dump($goods_id);exit;
        if(Request::isGet()){

        }
        $goodsService=new GoodsService();
        $goods=$goodsService->getgoods();
        return view("",["goods"=>$goods]);
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
        }elseif(Request::isPost()) {
            //接值
            $data = Request::except(['weight_unit', 'attr_select', 'attr_price_list'], 'post');
            $attr=Request::only('attr_id,attr_name,attr_val,attr_price');
            if(empty($attr["attr_price"])){
                $attrs=[];
                foreach($attr["attr_id"] as $k=>$v){
                    $attrs[$k]["attr_id"]=$v;
                }
                foreach($attr["attr_name"] as $k1=>$v1){
                    $attrs[$k1]["attr_name"]=$v1;
                }
                foreach($attr["attr_val"] as $k2=>$v2){
                    $attrs[$k2]["attr_val"]=$v2;
                }
            }else{
                $attrs=[];
                foreach($attr["attr_id"] as $k=>$v){
                    $attrs[$k]["attr_id"]=$v;
                }
                foreach($attr["attr_name"] as $k1=>$v1){
                    $attrs[$k1]["attr_name"]=$v1;
                }
                foreach($attr["attr_val"] as $k2=>$v2){
                    $attrs[$k2]["attr_val"]=$v2;
                }
                foreach($attr["attr_price"] as $k3=>$v3){
                    $attrs[$k3]["attr_price"]=$v3;
                }
            }
            $goods_img = $_FILES["goods_img"];
            $goodsService=new GoodsService();
            $path=$goodsService->qiniu($goods_img);
            $data['goods_img']=$path;
            $good=new \app\admin\model\Goods();
            $goods=$good->save($data);
            $goods_id=$good->goods_id;
            foreach($attrs as $key=>$val){
                $attrs=$good->attr()->attach($goods_id,$val);
            }
            if($goods&&$attrs){
                echo json_encode(["status"=>1,"msg"=>"ok"]);
            }else{
                echo json_encode(["status"=>0,"msg"=>"添加失败"]);
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

