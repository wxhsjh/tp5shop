<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 16:02
 */
namespace app\admin\validate;
use think\Validate;

class Brand extends Validate{
    protected $rule = [
        'brand_name' => 'require',
        'brand_name' => 'unique:brand',
        'brand_order' => 'require'
    ];


    protected $message = [
        'brand_name.require' => "品牌名称不能为空",
        'brand_name.unique' => "品牌名称不能重复",
        'brand_order.require' => "品牌序号不能为空"
    ];
}