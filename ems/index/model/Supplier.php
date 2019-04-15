<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/4/7
 * Time: 10:25
 */

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class Supplier extends Model
{
    use SoftDelete;
    public function product()
    {
        return $this->hasMany('Product','sup_id','id');
    }
}