<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/4/7
 * Time: 9:36
 */

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
use app\index\validate\RolePro as validateRole;
class Rolepro extends Model
{
    use SoftDelete;
    public function product()
    {
        return $this->hasMany('Product','role_id','id');
    }
    public function addManger()
    {
        return $this->belongsTo('Manger','manger_id','id');
    }
    public function add($data)
    {
        $validateRole = new validateRole();
        if(!$validateRole->scene('add')->check($data)){
            return $validateRole->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        } else {
            return '操作失败';
        }
    }
    public function edit($data)
    {
        $validateRole = new validateRole();
        if(!$validateRole->scene('add')->check($data)){
            return $validateRole->getError();
        }
        $result = $this->save($data,['id' => $data['id']]);
        if ($result) {
            return 1;
        } else {
            return '操作失败';
        }
    }
}