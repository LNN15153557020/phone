<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/3/14
 * Time: 16:41
 */

namespace app\index\validate;
use think\Validate;

class Department extends Validate
{
    protected $rule =[
        'department_id|部门编号' => 'require|unique:department',
        'department_name|部门名称' => 'require|unique:department',
    ];
    protected $scene = [
        'edit'  =>  ['department_name'],
    ];
}