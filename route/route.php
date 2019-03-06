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

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
//前台
Route::get('index','index/Home/index');

Route::get('login','index/Login/index');
Route::post('login/user','index/Login/userLogin');
Route::get('logout/user','index/Login/logout');

Route::get('apply','index/Apply/index');
Route::post('apply/add','index/Apply/apply');
Route::get('apply/record','index/Apply/record');

Route::get('help','index/Help/index');

//后台
Route::get('admin','admin/Home/index');
Route::get('review/count','admin/Home/getPendingReview');

Route::get('admin/login','admin/Login/index');
Route::post('login/admin','admin/Login/adminLogin');
Route::get('logout/admin','admin/Login/logout');

Route::get('review/table','admin/Review/getReviewTable');
Route::get('review','admin/Review/getPendingReview');
Route::post('review/pass','admin/Review/reviewPass');
Route::post('review/refuse','admin/Review/IDMustInteger');

Route::get('user/table','admin/User/index');
Route::get('user','admin/User/getUserInfo');
Route::get('user/:id','admin/User/getUserDetail',[],['id'=>'\d+']);
Route::post('user/del','admin/User/delUserByID');

Route::get('record/table','admin/Record/index');
Route::get('record','admin/Record/getRecordInfo');
Route::get('record/:id','admin/Record/getRecordDetail',[],['id'=>'\d+']);
Route::post('record/update/:id','admin/Record/updateRecord',[],['id'=>'\d+']);
Route::post('record/del','admin/Record/delRecordByID');
return [

];
