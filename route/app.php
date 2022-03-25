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
use think\facade\Route;


Route::get('index','index');
Route::get('accesstoken','accesstoken/getaccesstoken');
Route::get('token','token/index');
Route::get('ip','weixinip/ip');


//来自某个关键字 进行显示页面
Route::get('keyword/:name','index/keyword');
//查看文章
Route::get('article/:id','index/article');


Route::get('page/:tag/[:pageNum]','index/page');




