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
use app\index\validate\Product as validatePro;
class Product extends Model
{
    use SoftDelete;
    public function manger()
    {
        return $this->belongsTo('Manger','manger_id','id');
    }
    public function Role()
    {
        return $this->belongsTo('Rolepro','role_id','id');
    }
    public function supplier()
    {
        return $this->belongsTo('Supplier','sup_id','id');
    }
    // 添加产品
    public function saveData($data)
    {
        $validatePro = new validatePro();
        if(!$validatePro->scene('add')->check($data)){
            return $validatePro->getError();
        }
        $result = $this->save($data);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
    // 编辑产品
    public function saveDataPro($data)
    {
        $validatePro = new validatePro();
//        if(!$validatePro->scene('edit')->check($data)){
//            return $validatePro->getError();
//        }
        $result = $this->save($data,['id'=>$data['id']]);
        if ($result) {
            return 1;
        } else {
            return '操作失败！';
        }
    }
}