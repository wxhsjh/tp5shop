<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 16:02
 */
namespace app\admin\validate;
use think\Validate;

class Cate extends Validate{
    protected $rule = [
        'cate_name' => 'require',
        'cate_name' => 'unique:cate',
        'cate_order' => 'require',
        'cate_pid' => 'require'
    ];


    protected $message = [
        'cate_name.require' => "分类名称不能为空",
        'cate_name.unique' => "分类名称不能重复",
        'cate_order.require' => "分类序号不能为空",
        'cate_pid.require' => "所属分类不能为空"
    ];
}