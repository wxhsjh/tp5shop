<?php

namespace app\admin\controller;

namespace app\admin\controller;
use Qiniu\Auth as Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;


class Brand extends Common
{

    public function index()
    {
        $brands=\app\admin\model\Brand::getBrands();
        return view('',["brands"=>$brands]);
    }

    public function add()
    {
        if( Request::isGet()){
            return view('');
        }elseif(Request::isPost()){
            //接值
            $data = input("post.");
            $validate=$this->validate(
                [
                    'brand_name'=>$data['brand_name'],
                    'brand_order'=>$data['brand_order']

                ],
                'app\admin\validate\Brand'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            //七牛云
//            $file = request()->file('brand_img');
//            // 要上传图片的本地路径
//            $filePath = $file->getRealPath();
//            $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀
//            //获取当前控制器名称
//            $controllerName=$this->getContro();
//            // 上传到七牛后保存的文件名
//            $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
//            require_once APP_PATH . '/../vendor/qiniu/autoload.php';
//            // 需要填写你的 Access Key 和 Secret Key
//            $accessKey = config('ACCESSKEY');
//            $secretKey = config('SECRETKEY');
//            // 构建鉴权对象
//            $auth = new Auth($accessKey, $secretKey);
//            // 要上传的空间
//            $bucket = config('BUCKET');
//            $domain = config('DOMAINImage');
//            $token = $auth->uploadToken($bucket);
//            // 初始化 UploadManager 对象并进行文件的上传
//            $uploadMgr = new UploadManager();
//            // 调用 UploadManager 的 putFile 方法进行文件的上传
//            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//            if ($err !== null) {
//                return ["err"=>1,"msg"=>$err,"data"=>""];
//            } else {
//                //返回图片的完整URL
//                return json(["err"=>0,"msg"=>"上传完成","data"=>uploadreg($domain . $ret['key'])]);
//            }
//
//
//
//            // 需要填写你的 Access Key 和 Secret Key
//            $accessKey = "AL-kEptPtlsd9g9J-qVGoToNXvynyoZQvHuQ3X9A";
//            $secretKey = "T-JvJ64LdBHQHQjwHFZmv1kfC_e5fWCk9Dih1dsc";
//            $bucket = "face123";
//             //构建鉴权对象
//            $auth = new Auth($accessKey, $secretKey);
//            // 生成上传 Token
//            $token = $auth->uploadToken($bucket);
//            // 要上传文件的本地路径
//            $filePath = $file['tmp_name'];
//            // 上传到七牛后保存的文件名
//            $ext=pathinfo($file['name'],PATHINFO_EXTENSION);
//            $key = uniqid().".".$ext;
//            //初始化 UploadManager 对象并进行文件的上传。
//            $uploadMgr = new UploadManager();
//            // 调用 UploadManager 的 putFile 方法进行文件的上传。
//            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//            if($err==null){
//                $path="http://py0p1akt6.bkt.clouddn.com/".$ret['key'];
//                $data['brand_img']=$path;
//
//                $brand=\app\admin\model\Brand::addBrand($data);
//                echo json_encode(["status"=>1,"msg"=>"ok","path"=>$path]);
//            }else{
//                echo json_encode(["status"=>0,"msg"=>"添加失败"]);
//            }


//本地传图片
            $data = input("post.");
            $validate=$this->validate(
                [
                    'brand_name'=>$data['brand_name'],
                    'brand_order'=>$data['brand_order']

                ],
                'app\admin\validate\Brand'
            );
            if ($validate!==true) {
                $this->error($validate);
            }
            try{
                //处理上传图片
                $file = Request::file('brand_img');
                $info=$file->validate(['size'=>2048000,'ext'=>'gif,png,jpg'])->move("uploads/brand");
                if($info){
                    $data['brand_img']=request()->domain()."/uploads/brand/".str_replace('\\',"/",$info->getSaveName());
                    //入库
                    $brand=\app\admin\model\Brand::addBrand($data);
                    if($brand){
                        $this->success('添加成功','index');
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

