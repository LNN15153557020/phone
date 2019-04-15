<?php
/**
 * Created by PhpStorm.
 * User: 宁宁
 * Date: 2019/3/11
 * Time: 15:17
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;
use app\index\validate\Department as departValidate;
class Department extends Model
{
    use SoftDelete;
    public function mangerD()
    {
        return $this->hasMany('Manger','department_id','id');
    }
    public function hasRole()
    {
        return $this->hasMany('Role','department_id','id');
    }
    public function saveDepart($data)
    {
        $departValidate = new departValidate();
        if(!$departValidate->scene('edit')->check($data)){
            return $departValidate->getError();
        }
        $result = $this->save($data,['id' => $data['id']]);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
    public function addDepart($data)
    {
        $departValidate = new departValidate();
        if(!$departValidate->scene('edit')->check($data)){
            return $departValidate->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
}