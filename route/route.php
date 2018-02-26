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

// Route::rule(地址, 代码);
// Route::rule('/abc', function(){ echo 'i miss you'; });
// Route::rule('chang', 'index/TestController/abcd');
Route::view('kan', 'admin@common/default');

Route::rule('user-create',   'admin/UsersController/create');
Route::rule('user-save',     'admin/UsersController/save');
Route::rule('user-index',    'admin/UsersController/index');
Route::rule('user-del/:id',  'admin/UsersController/delete');
Route::rule('user-edit/:id', 'admin/UsersController/edit');
Route::rule('user-update/:id','admin/UsersController/update');

Route::group(['name'=>'cate', 'prefix'=>'admin/CatesController/'], function(){

	Route::rule('create/[:id]', 'create', 'get');
	Route::rule('save',   'save',   'post');
	Route::rule('index',  'index',  'get');
	Route::rule('del/:id','delete', 'get');
    Route::rule('edit/:id','edit',  'get');
    Route::rule('update/:id','update', 'post');
});

Route::group(['name'=>'goods', 'prefix'=>'admin/GoodsController/'],function(){

	Route::rule('create', 'create', 'get');
	Route::rule('save',   'save',   'post');

});

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

return [

];
