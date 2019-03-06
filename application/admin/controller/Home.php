<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/25
 * Time: 20:01
 */

namespace app\admin\controller;


use app\admin\model\Record as RecordModel;
use app\facade\userSession;
use app\lib\enum\ScopeEnum;
use app\lib\exception\PendingReviewException;
use think\Controller;

class Home extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['only' => 'index,getPendingReview']
    ];
    protected function checkLogin(){
        $scope = userSession::checkScope();
        if (!$scope){
            $this->redirect('admin/Login/index');
        }else{
            if ($scope >= ScopeEnum::Super){
                return true;
            }else{
                $this->error('没有权限访问');
            }
        }
    }
    public function index()
    {
        /**
         * 核对登录
         * 获取用户信息
         * 渲染输出
         */
        $userInfo = userSession::getUserInfo();
        if (!$userInfo){
            $this->redirect('admin/Login/index');
        }else{
            $this->assign('username',$userInfo['username']);
            return $this->fetch('home');
        }
    }
    public function getPendingReview(){
            $count = RecordModel::getPendingReviewCount();
            if (empty($count) && $count != 0){
                throw new PendingReviewException();
            }
            return json(['count'=>$count]);
    }
}