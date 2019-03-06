<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/2
 * Time: 11:59
 */

namespace app\admin\controller;

use app\admin\model\User as UserModel;
use app\admin\validate\IDMustInteger;
use app\admin\validate\Pagination;
use app\facade\userSession;
use app\lib\enum\ScopeEnum;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserMissException;
use think\Controller;

class User extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['only' => 'index,getUserInfo,getUserDetail']
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
        return $this->fetch('index');
    }
    public function getUserInfo()
    {
        (new Pagination())->goCheck();
        $action = input('get.');
        $result = UserModel::getUserInfo($action);
        $userInfo = $result->toArray();
        $data = [
            'code' => 200,
            'msg' => '获取待审核记录成功',
            'count' => count($userInfo),
            'data' => $userInfo
        ];
        return json($data,200);
    }
    public function getUserDetail($id)
    {
        (new IDMustInteger())->goCheck();
        $user = UserModel::getUserByID($id);
        if (!$user){
            throw new UserMissException();
        }
        $result = $user->hidden(['id','record' =>['id']])->toArray();
        $result['apply_count'] = count($result['record']);
        //return json($result,200);
        $this->assign('user',$result);
        return $this->fetch('detail');
    }
    public function delUserByID()
    {
        (new IDMustInteger())->goCheck();
        $id = input('post.id');
        $res = UserModel::delRecordByID($id);
        if (!$res){
            throw new Exception();
        }
        return json(new SuccessMessage(),200);
    }
}