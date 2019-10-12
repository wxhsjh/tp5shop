<?php

namespace app\admin\controller;

namespace app\admin\controller;
use app\index\model\User;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class Cate extends Common
{

//    public function index()
//    {
//        return view();
//    }
//    public function show(){
//        $data = Db::name('book')->where('book_status',1)->paginate(2);
//        return view('',["data"=>$data]);
//    }

    public function add()
    {
        if( Request::isGet()){
            return view();
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            $validate=$this->validate(
                [
                    'book_name'=>$data['book_name'],
                    'book_content'=>$data['book_content']

                ],
                'app\admin\validate\Cate'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            try{
                //处理上传图片
                $file = Request::file('book_url');
                $info=$file->validate(['size'=>2048000,'ext'=>'gif,png,jpg'])->move("uploads/book");
                if($info){
                    $data['book_url']=request()->domain()."/uploads/book/".str_replace('\\',"/",$info->getSaveName());
                    //入库
                    $book = Db::name('book')->insert($data);
                    if($book){
                        $this->success('添加成功','show');
                    }else{
                        $this->error('添加失败');
                    }
                }
            }catch(Exception $e){
                return ($e->getMessage());
            }


        }
    }
}

