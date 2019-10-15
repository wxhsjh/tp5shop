<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 16:02
 */
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate{
    protected $rule = [
        'admin_name' => 'require',
        'admin_name' => 'unique:admin',
        'admin_pwd' => 'require',
        'admin_repwd' => 'require'
    ];


    protected $message = [
        'admin_name.require' => "管理员名称不能为空",
        'admin_name.unique' => "管理员名称不能重复",
        'admin_pwd.require' => "管理员密码不能为空",
        'admin_repwd.require' => "管理员确认密码不能为空"
    ];
}