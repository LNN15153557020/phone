<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/3/12
 * Time: 15:43
 */

namespace app\index\validate;
use think\Validate;

class Manger extends Validate
{
    protected $rule =[
        'manger_no|员工编号' => 'require|unique:manger',
        'manger_name|员工姓名' => 'require',
        'pass|登录密码' => 'require|min:6',
        'phone|联系方式' => 'require|unique:manger',
        'email' => 'require|unique:manger',
        'department_id|部门' => 'require',
        'role_id|角色' => 'require',
        'incumbency|职位属性' => 'require',

    ];
    protected $scene = [
        'add'  =>  ['manger_no','manger_name','pass','phone','email','department_id','role_id','incumbency'],
        'edit'  =>  ['manger_name','pass','department_id','role_id','incumbency'],
    ];
}