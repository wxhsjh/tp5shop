<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 2019/10/13
 * Time: 11:49
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model{
    protected $pk ="admin_id";
    public function role()
    {
        return $this->belongsToMany('Role',"admin_role","role_id","admin_id");
    }

}