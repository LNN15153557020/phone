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
use app\index\validate\Manger as mangerValidate;
class Manger extends Model
{
    use SoftDelete;
    public function role()
    {
        return $this->belongsTo('Role','role_id','id');
    }
    public function department()
    {
        return $this->belongsTo('Department','department_id','id');
    }
    public function transfer()
    {
        return $this->hasMany('Transfer','manger_id','id');
    }
    public function product()
    {
        return $this->hasMany('Product','manger_id','id');
    }
    public function proRole()
    {
        return $this->hasMany('Rolepro','manger_id','id');
    }
    public function checkLogin($data)
    {
        $username = $data['manger_name'];
        if (cookie('manger_name') == $data['manger_name'] ) {
            return '你已经被禁用，请稍后重试!';
        }
        $result = $this->where('manger_name',$username)->find();
        // 有无该用户
        if ($result == null) {
            return '无该员工!';
        } else {
            $name = $result['manger_name'];
        }
        // 密码判断 三次禁止登陆
        if ($result['pass'] != $data['pass']) {
            $num = session('login_num');
            if (session('login_num') == 3) {
                cookie('manger_name',$username , 1 * 60);
                return '你已被禁用30分钟';
            }
            $number = 3 - $num;
            $num = $num + 1;
            session('login_num', $num);
            return '你的剩余次数' . $number;
        } else {
            session('id', $result['id']);
            session('roleId', $result['role_id']);
            session('manger_name', $name);
            return 1;
        }
    }
    public function change($data)
    {
        $result = $this->where('id',$data['id'])->update($data);
        if($result){
            return 1;
        }else{
            return '修改密码失败！';
        }
    }
    public function changeInfo($data)
    {
        $result = $this->save($data, ["id" => $data['id']]);
        if ($result) {
            return 1;
        } else {
            return '保存失败！';
        }
    }
    // 删除
    public function delManger($id)
    {
        $result = $this->destroy($id);
        if ($result) {
            return 1;
        } else {
            return '删除失败！';
        }
    }
    // 添加
    public function addManger($data)
    {
        $mangerValidate = new mangerValidate();
        if(!$mangerValidate->scene('add')->check($data)){
            return $mangerValidate->getError();
        }

        $result = $this->save($data);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
    // 编辑
    public function editManger($data)
    {
        $mangerValidate = new mangerValidate();
        if(!$mangerValidate->scene('edit')->check($data)){
            return $mangerValidate->getError();
        }

        $result = $this->save($data,['id'=>$data['id']]);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
}