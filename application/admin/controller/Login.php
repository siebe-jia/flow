<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 9:39
 */

namespace app\admin\controller;


use app\admin\model\Admin as AdminModel;
use app\admin\validate\LoginValidate;
use app\lib\enum\ScopeEnum;
use app\lib\exception\AdminException;
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

    public function adminLogin(){
        (new LoginValidate())->goCheck();
        $data = input('post.');
        $user = AdminModel::getByUsername($data['username']);
        if (!$user){
            throw new AdminException();
        }
        $result = $this->ldapLogin($data);
        if (!$result){
            throw new Exception();
        }
        Session::set('username',$user->username);
        Session::set('realName','空');
        Session::set('scope',ScopeEnum::Super);
        return json(new SuccessMessage(),201);
    }

    public function logout(){

    }

    private function ldapLogin($data)
    {
        return true;
    }
}