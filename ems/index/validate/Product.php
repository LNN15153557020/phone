<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/4/7
 * Time: 11:32
 */

namespace app\index\validate;
use think\Validate;

class Product extends Validate
{
    protected $rule =[
        'pro_no|产品编号' => 'require|unique:product',
        'pro_name|产品名称' => 'require',
        'role_id|产品类别' => 'require',
        'quantity|产品数量' => 'require|number',
        'price|售价' => 'require|number',
        'costprice|成本价' => 'require|number',
        'sup_id|供应商' => 'require',
    ];
    protected $scene = [
        'add'  =>  ['pro_no','pro_name','role_id','quantity','price','costprice','sup_id'],
        'edit'  =>  ['pro_name','role_id','quantity','price','costprice','sup_id'],
    ];
}