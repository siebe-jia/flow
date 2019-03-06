<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 15:37
 */

namespace app\admin\validate;


class LoginValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|isNotEmpty',
        'password' => 'require|isNotEmpty'
    ];

    protected $message = [
        'username' => '用户名只能由多位数字组成',
        'password' => '密码不能为空'
    ];

}