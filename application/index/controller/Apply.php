<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 11:07
 */

namespace app\index\controller;

use app\index\validate\ApplyValidate;
use app\facade\userSession;
use app\index\model\Record as RecordModel;
use app\index\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ApplyAddException;
use app\lib\exception\SuccessMessage;
use think\Controller;

class Apply extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['only' => 'index,apply,record']
    ];
    protected function checkLogin(){
        $scope = userSession::checkScope();
        if (!$scope){
            $this->redirect('index/Login/index');
        }else{
            if ($scope >= ScopeEnum::User){
                return true;
            }else{
                $this->error('没有权限访问');
            }
        }
    }
    public function index()
    {
        $user = userSession::getUserInfo();
        if (!$user){
            $this->redirect('index/Login/index');
        }
        $userInfo = UserModel::getByusername($user['username']);
        if (!$userInfo){
            $this->redirect('index/Login/index');
        }
        $this->assign('flag',true);
        $this->assign('userInfo',$userInfo);
        return $this->fetch('apply');
    }
    public function apply()
    {
        $user = userSession::getUserInfo();
        if (!$user){
            $this->redirect('index/Login/index');
        }
        (new ApplyValidate())->goCheck();
        $data = input('post.');
        $data['user_id'] = $user['id'];
        $record = new RecordModel();
        $record->allowField(true)->save($data);
        $id = $record->id;
        if (!$id){
            throw new ApplyAddException();
        }
        return json(new SuccessMessage(),200);
    }
    public function record(){
        $userInfo = userSession::getUserInfo();
        if (!$userInfo){
            $this->redirect('index/Login/index');
        }
        $record = RecordModel::getRecord($userInfo['id']);
        $this->assign('empty','<tr><td colspan="6" align="center">没有数据</td></tr>');
        $this->assign('record',$record);
        $this->assign('flag',true);
        $this->assign('username',$userInfo['username']);
        return $this->fetch('record');
    }
}