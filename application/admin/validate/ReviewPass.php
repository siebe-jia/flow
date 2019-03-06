<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/27
 * Time: 20:17
 */

namespace app\admin\validate;


class ReviewPass extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'account' => 'require|isNotEmpty|isPositiveInteger',
        'password' => 'require|isNotEmpty|alphaDash',
        'expire_time' => 'require|isNotEmpty|date'
    ];
    protected $message = [
        'id' => '必须是正整数',
        'account' => '由多位正整数组成',
        'password' => '由多位字母和数字组成',
        'expire_time' => '例如：2019-02-27 20:00:00'
    ];
}