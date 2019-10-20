<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/15
 * Time: 21:14
 */
namespace app\admin\service;
use app\admin\model\Goods;
use think\facade\Session;

class GoodsService{
    public function getgoods(){
        //取所有的商品
        $goods=new Goods();
        return $goods->all();
    }
    //添加商品
    public function qiniu($goods_img){
        // 要上传图片的本地路径
        $filePath = $goods_img['tmp_name'];
        $ext=pathinfo($goods_img['name'],PATHINFO_EXTENSION);//后缀
// 上传到七牛后保存的文件名
        $key = uniqid().".".$ext;
// 需要填写你的 Access Key 和 Secret Key
        $accessKey = 'AL-kEptPtlsd9g9J-qVGoToNXvynyoZQvHuQ3X9A';//你的accessKey
        $secretKey = 'T-JvJ64LdBHQHQjwHFZmv1kfC_e5fWCk9Dih1dsc';//你的secretKey
// 构建鉴权对象
        $auth = new Auth($accessKey,$secretKey);
// 要上传的空间
        $bucket = 'goods-img-img';
        $token = $auth->uploadToken($bucket);
// 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr=new UploadManager();
        // var_dump($filePath);exit;
// 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret,$err)=$uploadMgr->putFile($token, $key, $filePath);
        if($err==null) {
            $path = "http://pzo3uvcyg.bkt.clouddn.com/" . $ret['key'];
        }
        return $path;
    }

}