<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                "manger_name" => input("post.username"),
                "pass" => input("post.password"),
            ];
            $result = model('Manger')->checkLogin($data);
            if ($result == 1) {
                $this->success('登陆成功', 'index/index/index');
            } else {
                $this->error($result);
            }
        }
        session('login_num',1);
        return view();
    }
    public function outLogin()
    {
        session(null);
        if(session('username')){
            $this->error("退出失败");
        }else{
            $this->success("退出成功！",'index/login/login');
        }
    }
}
