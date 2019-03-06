<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 10:32
 */

namespace app\index\controller;

use app\facade\userSession;
use think\Controller;

class Home extends Controller
{
    public function index()
    {
        $userInfo = userSession::getUserInfo();
        if ($userInfo){
            $this->assign('flag',true);
            $this->assign('username',$userInfo['username']);
        }else{
            $this->assign('flag',false);
        }
        return $this->fetch('home');
    }
}