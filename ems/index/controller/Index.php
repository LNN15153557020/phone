<?php

namespace app\index\controller;

use think\Controller;
use think\Model;

class Index extends Controller
{
    // 主页面
    public function index()
    {
        $mangerId = session('id');
        $result = model('Manger')->with('department')->find($mangerId);
        $loginTime = date('Y-m-d');
        $this->assign('loginTime', $loginTime);
        $this->assign('result', $result);
        return view();
    }
// 个人信息
    public function personInfo()
    {
        $mangerId = session('id');
        $result = model('Manger')->with('department', 'role')->find($mangerId);
        $this->assign('info', $result);
        return view();
    }
// 修改密码
    public function changePass()
    {
        if (request()->isAjax()) {
            $data = [
                'pass' => input("post.pass"),
                'id' => input("post.id")
            ];
            $result = model('Manger')->change($data);
            if ($result == 1) {
                $this->success('修改密码成功！', 'index/index/personInfo');
            } else {
                $this->error($result);
            }
        }
    }

    public function changeInfo()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input("post.id"),
                'manger_name' => input("post.name"),
                'phone' => input("post.phone"),
                'email' => input("post.email")
            ];
            $result = model("Manger")->changeInfo($data);
            if ($result == 1) {
                $this->success('保存成功！', 'index/index/personInfo');
            } else {
                $this->error($result);
            }
        }
    }

//    角色
    public function role()
    {
        if (isset($_GET['page'])) {
            $pageinit = $_GET['page'];
        } else {
            $pageinit = 1;
        }
        if (request()->isAjax()) {
            $id = input("post.id");
            $result = model("Role")->with('manger')->where('id',$id)->paginate(1);
            $page = $result->render();
            $data = [
                "data" => $result,
                "pageinit" => $pageinit,
            ];
            return json($data);
        }
        $result = model('Role')->order("id", "asc")->select();
        $department = model("Department")->select();
        $this->assign('data', $result);
        $this->assign('page',null);
        $this->assign('department',$department);
        return view();
    }
    // 伴随更改
    public function changeRole()
    {
        if (request()->isAjax()){
            $id = input("post.id");
            $data = model("Role")->where('department_id',$id)->where('id','>',1)->select();
            return $data;
        }
    }
    public function roleEditInfo()
    {
        if (request()->isAjax()) {
            $id = input("post.id");
            $data = model("Role")->with('department')->find($id);
            return $data;
        }
    }
    // 编辑
    public function roleEdit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input("post.id"),
                'role_name' => input("post.roleName"),
                'role_desc' => input("post.roleDesc")
            ];
            $result = model("Role")->roleEdit($data);
            if ($result == 1) {
                $this->success('编辑成功','index/index/role');
            } else {
                $this->error($result);
            }
        }
    }
   // 添加
    public function roleAdd()
    {
        if (request()->isAjax()) {
            $data = [
                'department_id' => input('post.department'),
                'role_name' => input("post.name"),
                'role_desc' => input("post.desc")
            ];
            $result = model("Role")->add($data);
            if ($result == 1) {
                $this->success('添加成功','index/index/role');
            } else {
                $this->error($result);
            }
        }
    }
  // 员工管理
    public function mangerList()
    {
        if(isset($_GET["page"])){
            $pageinit = $_GET["page"];
        }else{
            $pageinit = 1;
        }
        $role = session('roleId');
//        echo $role;
//        return;
        if ($role == 1) {
            $data = model('Manger')->with('department','role')->order('id','asc')->paginate(2);
        } else if ($role == 4) {
            $data = model('Manger')->with('department','role')->where('department_id',1)->order('id','asc')->paginate(4);
        } else if ($role == 5) {
            $data = model('Manger')->with('department','role')->where('department_id',2)->order('id','asc')->paginate(4);
        }
        $page = $data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('pageinit',$pageinit);
        return view();
    }
    // 删除
    public function delManger()
    {
        if (request()->isAjax()) {
            $id = input("post.id");
            $result = model("Manger")->delManger($id);
            if ($result == 1) {
                $this->success('删除成功！','index/index/mangerList');
            } else {
                $this->error($result);
            }
        }
    }
    // 添加
    public function addManger()
    {
        if (request()->isAjax()) {
            $createTime = date('Y-m-d');
            $data = [
                'manger_no' => input("post.no"),
                'manger_name' => input("post.name"),
                'pass' => input("post.pass"),
                'phone' => input("post.phone"),
                'email' => input("post.email"),
                'department_id' => input("post.department"),
                'role_id' => input("post.role"),
                'jobyear' => input("post.year"),
                'sex' => input("post.sex"),
                'address' => input("post.address"),
                'marry' => input("post.marry"),
                'incumbency' => input("post.incumbency"),
                'create_date' => $createTime
            ];
            $result = model("Manger")->addManger($data);
            if ($result == 1) {
                $this->success('添加成功！', 'index/index/mangerList');
            } else {
                $this->error($result);
            }
        }
        $department = model("Department")->select();
        $role = model("Role")->where('id','>',1)->select();
        $this->assign('department',$department);
        $this->assign('role',$role);
        return view();
    }
    // 编辑
    public function editManger()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input("post.id"),
                'manger_no' => input("post.no"),
                'manger_name' => input("post.name"),
                'pass' => input("post.pass"),
                'phone' => input("post.phone"),
                'email' => input("post.email"),
                'department_id' => input("post.department"),
                'role_id' => input("post.role"),
                'jobyear' => input("post.year"),
                'sex' => input("post.sex"),
                'address' => input("post.address"),
                'marry' => input("post.marry"),
                'incumbency' => input("post.incumbency")
            ];
            $result = model('Manger')->editManger($data);
            if ($result == 1) {
                $this->success('操作成功！','index/index/mangerList');
            } else {
                $this->error($result);
            }
        }
        if ($_GET['id']) {
            $id = $_GET['id'];
        }
        $data = model("Manger")->find($id);
        $department = model("Department")->select();
        $role = model("Role")->where('id','>',1)->select();
        $this->assign('data',$data);
        $this->assign('department',$department);
        $this->assign('role',$role);
        return view();
    }
    // 设置(调动)
    public function transfer()
    {
        if (request()->isAjax()) {
            $info = [
                "id" => input("post.id"),
                "states" => 1,
            ];
            $res = model('Transfer')->save($info,['id' => $info['id']]);
            if ($res) {
                $this->success('操作成功！','index/index/transfer');
            } else {
                $this->error('操作失败！');
            }
        }
        if(isset($_GET["page"])) {
            $pageinit = $_GET["page"];
        } else {
            $pageinit = 1;
        }
        $transferData = model("Transfer")->with('mangers')->order('id', 'asc')->paginate(2);
        $page = $transferData->render();
        $this->assign('page', $page);
        $this->assign('pageinit', $pageinit);
        $this->assign('transferData', $transferData);
        $department = model("Department")->select();
        $role = model("Role")->where('id','>',1)->select();
        $manger = model("Manger")->where('id','>',1)->select();
        $this->assign('manger',$manger);
        $this->assign('department',$department);
        $this->assign('role',$role);
        return view();
    }
    public function getManger()
    {
        if (request()->isAjax()) {
            $id = input("post.id");
            $data = model("Manger")->find($id);
            $role = model("Role")->where('id', $data['role_id'])->select();
            $department = model("Department")->where('id', $data['department_id'])->select();
            $info = [
                "data" => $data,
                "role" => $role[0],
                "department" => $department[0]
            ];
            return json($info);
        }
    }
    public function editTran()
    {
        if (request()->isAjax()) {
            $data = [
                "id" => input("post.id"),
                "department_id" => input("post.department"),
                "role_id" => input("post.role")
            ];
            $tranData = [
                "manger_id" => input("post.id"),
                "states" => 0,
                "tr_desc" => input("post.desc")
            ];
            $result = model('Manger')->save($data,['id' => $data['id']]);
            $res = model("Transfer")->save($tranData);
            if ($result && $res) {
                $this->success('操作成功！','index/index/transfer');
            } else {
                $this->error('操作失败！');
            }
        }
    }

    //部门设置
    public function department()
    {
        if (request()->isAjax()) {
            $id = input("post.id");
            $result = model("Department")->find($id);
            return $result;
        }
        if(isset($_GET["page"])){
            $pageinit = $_GET["page"];
        }else{
            $pageinit = 1;
        }
        $data = model("Department")->order('id','asc')->paginate(4);
        $page = $data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('pageinit',$pageinit);
        return view();
    }
    public function getDepInfo()
    {
        if (request()->isAjax()) {
            $id = input("post.id");
            $result = model("Manger")->with("role")->where('department_id',$id)->select();
            return $result;
        }
    }
    public function getModify()
    {
        if (request()->isAjax()) {
            $data = [
                "id" => input("post.id"),
                "department_name" => input("post.name"),
                "department_desc" => input("post.desc")
            ];
            $result = model("Department")->saveDepart($data);
            if ($result == 1) {
                $this->success('操作成功！','index/index/department');
            } else {
                $this->error($result);
            }
        }
    }
    public function addDepart()
    {
        $data = [
            "department_id" => input("post.no"),
            "department_name" => input("post.name"),
            "department_desc" => input("post.desc")
        ];
        $result = model('Department')->addDepart($data);
        if ($result == 1) {
            $this->success('操作成功！','index/index/department');
        } else {
            $this->error($result);
        }
    }
    public function productList()
    {
        if(isset($_GET["page"])) {
            $pageinit = $_GET["page"];
        } else {
            $pageinit = 1;
        }
        $data = model("Product")->with('manger','Role')->order('id', 'desc')->paginate(2);
        $page = $data->render();
        $this->assign('page', $page);
        $this->assign('pageinit', $pageinit);
        $this->assign('data', $data);
        return view();
    }
    public function addPro()
    {
        if (request()->isAjax()) {
            $data = [
                "manger_id" => session('id'),
                "sup_id" => input('post.supplier'),
                "pro_no" => input('post.no'),
                "salenumber" => 0,
                "pro_name" => input('post.name'),
                "role_id" => input('post.role'),
                "quantity" => input("post.number"),
                "costprice" => input('post.costPrice'),
                "price" => input("post.price"),
                "model" => input("post.model"),
                "add_time" => date('Y-m-d')
            ];
            $result = model('Product')->saveData($data);
            if ($result == 1) {
                $this->success('添加成功','index/index/productList');
            } else {
                $this->error($result);
            }
        }
        $dataSup = model('Supplier')->select();
        $dataRole = model('Rolepro')->select();
        $this->assign('supplier',$dataSup);
        $this->assign('role',$dataSup);
        return view();
    }
    //伴随供应商
    public function changeProRole()
    {
        $id = input('post.id');
        $roleId = model('Supplier')->find($id);
        $data = model('Rolepro')->find($roleId['role_id']);
        return $data;
    }
    public function infoPro()
    {
        $id = input('post.id');
        $data = model('Product')->with('supplier','Role')->find($id);
        return $data;
    }
    // 编辑产品
    public function editProduct()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input("post.id"),
                "sup_id" => input('post.supplier'),
                "pro_no" => input('post.no'),
                "pro_name" => input('post.name'),
                "role_id" => input('post.role'),
                "quantity" => input("post.number"),
                "costprice" => input('post.costPrice'),
                "price" => input("post.price"),
                "model" => input("post.model"),
            ];
            $result = model('Product')->saveDataPro($data);
            if ($result == 1) {
                $this->success('操作成功','index/index/productList');
            } else {
                $this->error($result);
            }
        }
        $id = $_GET['id'];
        $data = model('Product')->with('Role','supplier')->find($id);
        $dataSup = model('Supplier')->select();
        $this->assign('data',$data);
        $this->assign('supplier',$dataSup);
        return view();
    }
//    产品角色
    public function productRole()
    {
        if (request()->isAjax()) {
            $data = [
                "id" => input('post.id'),
                "role_name" => input("post.name")
            ];
            $result = model('Rolepro')->edit($data);
            if ($result == 1) {
                $this->success('操作成功', 'index/index/productRole');
            } else {
                $this->error($result);
            }
        }
        $data = model('Rolepro')->with('addManger')->order('id','desc')->select();
        $this->assign('data',$data);
        return view();
    }
    public function editRolePro()
    {
        if (request()->isAjax()) {
            $id = input('post.id');
            $data = model('Rolepro')->find($id);
            return $data;
        }
    }
    public function addRolePro()
    {
        if (request()->isAjax()) {
            $data = [
                "role_name" => input('post.name'),
                "manger_id" => session('id'),
                "add_time" => date('Y-m-d')
            ];
            $result = model('Rolepro')->add($data);
            if ($result == 1) {
                $this->success('操作成功', 'index/index/productRole');
            } else {
                $this->error($result);
            }
        }
    }
    public function deleteRolePro()
    {
        if (request()->isAjax()) {
            $id = input('post.id');
            $result = model('Rolepro')->where('id','=',$id)->delete();
            if ($result) {
                $this->success('操作成功', 'index/index/productRole');
            } else {
                $this->error('操作失败');
            }
        }
    }
    public function showInfo()
    {
        if (request()->isAjax()) {
            $id = input('post.id');
            $result = model('Product')->with('supplier')->where('role_id','=',$id)->select();
            return $result;
        }
    }
}

