<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/25
 * Time: 20:34
 */

namespace app\common;

use think\Controller;
use think\facade\Session;

class userSession extends Controller
{
    public function checkScope()
    {
        if (Session::has('username') && Session::has('scope')){
            $scope = Session::get('scope');
            if ($scope){
                return $scope;
            }else{
                $this->redirect('admin/LoginValidate/index');
            }
        }else{
            return false;
        }
    }
    public function getUserInfo($userInfo = [])
    {
        if (Session::has('username') && Session::has('realName')){
            $userInfo['username'] = Session::get('username');
            $userInfo['realName'] = Session::get('realName');
            if (Session::has('id')){
                $userInfo['id'] = Session::get('id');
            }
            return $userInfo;
        }else{
            return false;
        }
    }
}