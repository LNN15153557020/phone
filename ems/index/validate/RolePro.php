<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/4/14
 * Time: 15:33
 */

namespace app\index\validate;
use think\Validate;


class RolePro extends Validate
{
    protected $rule =[
        'role_name|产品分类名称' => 'require|unique:rolepro',
    ];
    protected $scene = [
        'add'  =>  ['role_name'],
    ];
}