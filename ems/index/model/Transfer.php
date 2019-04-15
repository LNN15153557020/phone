<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/3/14
 * Time: 9:08
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;


class Transfer extends Model
{
    use SoftDelete;
    public function mangers()
    {
        return $this->belongsTo('Manger','manger_id','id');
    }
}