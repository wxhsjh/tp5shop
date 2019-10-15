<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 16:02
 */
namespace app\admin\validate;
use think\Validate;

class Power extends Validate{
    protected $rule = [
        'power_name' => 'require',
        'power_name' => 'unique:power',
        'power_pid' => 'require'
    ];


    protected $message = [
        'power_name.require' => "权限名称不能为空",
        'power_name.unique' => "权限名称不能重复",
        'power_pid.require' => "所属权限不能为空"
    ];
}