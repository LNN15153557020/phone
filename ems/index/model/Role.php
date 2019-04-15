<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/2/17
 * Time: 16:33
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;
use app\index\validate\Role as roleValidate;

class Role extends Model
{
    use SoftDelete;
    public function manger()
    {
        return $this->hasMany('Manger','role_id','id');
    }
    public function department()
    {
        return $this->belongsTo('department','department_id','id');
    }
    public function roleEdit($data)
    {
        $roleValidate = new roleValidate();
        if(!$roleValidate->scene('add')->check($data)){
            return $roleValidate->getError();
        }
        $result = $this->save($data,['id' => $data['id']]);
        if ($result) {
            return 1;
        } else {
            return '信息编辑失败！';
        }
    }
    public function add($data)
    {
        $roleValidate = new roleValidate();
        if(!$roleValidate->scene('add')->check($data)){
            return $roleValidate->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        } else {
            return '添加失败！';
        }
    }
}