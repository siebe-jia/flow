<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 11:07
 */

namespace app\index\controller;

use app\admin\model\User as UserModel;
use app\admin\validate\LoginValidate;
use app\lib\enum\ScopeEnum;
use app\lib\exception\SuccessMessage;
use think\Controller;
use think\Exception;
use think\facade\Session;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }
    public function userLogin(){
        (new LoginValidate())->goCheck();
        $data = input('post.');
        $result = $this->ldapLogin($data);
        if (!$result){
            throw new Exception();
        }
        $user = UserModel::getByUsername($data['username']);
        if (!$user){
            $userModel = new UserModel();
            $userModel->save([
                'username' => $data['username'],
                'real_name' => $result['realName']
            ]);
            $id = $userModel->id;
        }else{
            $id = $user->id;
        }
        Session::set('id',$id);
        Session::set('username',$data['username']);
        Session::set('realName',$result['realName']);
        Session::set('scope',ScopeEnum::User);
        return json(new SuccessMessage(),201);
    }

    public function logout(){
        Session::clear();
        $this->redirect('index/Login/index');
    }

    private function ldapLogin($data)
    {
        return ['realName' => '金山'];
    }
}