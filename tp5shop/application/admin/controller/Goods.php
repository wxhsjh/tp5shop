<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\BrandCate;
use app\admin\model\BrandsCate;
use app\admin\model\Catemodel;
use app\admin\model\GoodsAttr;
use app\admin\model\GoodsCate;
use app\admin\model\Photo;
use app\admin\service\GoodsService;
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
        $goods=\app\admin\model\Goods::all();
        foreach($goods as $k=>$v){
            $v->cate;
        }
        foreach($goods as $key=>$val){
            $brand=Brand::get($val["brand_id"]);
            $val["brand"]=$brand["brand_name"];
        }
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
            $goodsService=new GoodsService();
            //接值
            $data = Request::except(['weight_unit', 'attr_select', 'attr_price_list'], 'post');
            $attr=Request::only('attr_id,attr_name,attr_val,attr_price');
            $attrs=$goodsService->attr($attr);
            $goods_img = $_FILES["goods_img"];
            $path=$goodsService->qiniu($goods_img);
            $data['goods_img']=$path;
            $good=new \app\admin\model\Goods();
            //入库goods表
            $goods=$good->save($data);
            $goods_id=$good->goods_id;
            //入库goods_attr表
            foreach($attrs as $key=>$val){
                $attrs=$good->attr()->attach($val["attr_id"],$val);
            }
            //
            //入库goods_cate表
            $data1["cate_id"]=$data["cate_id"];
            $data1["goods_id"]=$goods_id;
            $goodscate=new GoodsCate();
            $goodscate=$goodscate->save($data1);
            //入库brand_cate表
            $data2["brand_id"]=$data["brand_id"];
            $data2["cate_id"]=$data["cate_id"];
            $brandcate=new BrandCate();
            $brandcate=$brandcate->save($data2);
            //相册表
            $goods=new \app\admin\model\Goods();
            $goods_img[] = $_FILES["img_url"];
            $img=[];
            foreach($_FILES["img_url"]["name"] as $k=>$v) {
                if (!empty($v)) {
                    $img["name"] = $v;
                    $img["type"] = $_FILES["img_url"]["type"][$k];
                    $img["tmp_name"] = $_FILES["img_url"]["tmp_name"][$k];
                    $img["error"] = $_FILES["img_url"]["error"][$k];
                    $img["size"] = $_FILES["img_url"]["size"][$k];
                    if (!$path = $goodsService->qiniu($img)) {
                        return ["status" => 11, "msg" => "商品详情图片上传失败"];
                    } else {
                        $photo=new Photo();
                        $photo=$photo->save(["photo_img"=>$path,"goods_id"=>$goods_id]);
                    }
                }
            }
            if($goods&&$attrs&&$goodscate&&$brandcate&&$photo){
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

