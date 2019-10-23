<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Attr;

use app\admin\model\Goods;
use app\admin\model\GoodsAttr;
use app\admin\service\GoodsService;
use app\admin\service\ProductService;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Product extends Common
{

    public function index()
    {
        $goods_id = request()->param("goods_id", "");
        $productservice=new ProductService();
        $attr=$productservice->getAttr($goods_id);
        $product=$productservice->getProduct($goods_id);
        foreach($product as $key=>$val){
            $arr=explode("|",$val["goods_attr"]);
            $goodsattr=GoodsAttr::where("goods_id",$goods_id)->all($arr)->toArray();
            //dump($goodsattr);
            $pro=array_column($goodsattr,'attr_val','goods_attr_id');
           // dump($pro);
            $price=array_column($goodsattr,'attr_price','goods_attr_id');
            $price=array_sum($price);
            $attrs=implode("+",$pro);
            $val["goods_attr"]=$attrs;
            $val["price"]=$price;
        }
        $goods=Goods::get($goods_id);
        return view("", ["attr" => $attr,"goods" => $goods,"product" => $product]);
    }
    public function add()
    {
        $goods_id = request()->get("goods_id", "");
        if (Request::isGet()) {
            $productservice=new ProductService();
            $attr=$productservice->getAttr($goods_id);
            return view("", ["attr" => $attr,"goods_id" => $goods_id]);
        }elseif(Request::isPost()) {
            //接值
            $data=input("post.");
            foreach($data["attr_name"] as $key=>$val){
                $val["goods_attr"]=implode("|",$val["goods_attr"]);
                $attr[]=$val;
                }
            $product=Goods::find($goods_id);
            $products=$product->product()->saveAll($attr);
            if($products){
                $this->success('添加成功',url('index',["goods_id"=>$goods_id]));
            }else{
                $this->error('添加失败');
            }
            }
    }
}

