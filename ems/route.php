<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::group('phone',function (){
   Route::rule('login','index/login/login','post|get');
   Route::rule('index','index/index/index','post|get');
   Route::rule('personInfo','index/index/personInfo','post|get');
   Route::rule('role','index/index/role','post|get');
   Route::rule('manger','index/index/mangerList','post|get');
   Route::rule('editManger','index/index/editManger','post|get');
   Route::rule('transfer','index/index/transfer','post|get');
   Route::rule('department','index/index/department','post|get');
   Route::rule('product','index/index/productList','post|get');
   Route::rule('add_pro','index/index/addPro','post|get');
   Route::rule('edit_pro','index/index/editProduct','post|get');
   Route::rule('product_role','index/index/productRole','post|get');
});
