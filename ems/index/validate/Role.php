<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/3/12
 * Time: 9:46
 */

namespace app\index\validate;
use think\Validate;

class Role extends Validate
{
    protected $rule =[
        'role_name|角色名称' => 'require|unique:role',
    ];
    protected $scene = [
        'add'  =>  ['role_name'],
    ];
}