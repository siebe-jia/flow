<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 19:08
 */

namespace app\index\validate;


class ApplyValidate extends BaseValidate
{
    protected $rule = [
        'tel' => 'mobile',
        'email' => 'email',
        'department' => 'chs',
        'duration' => 'require|isPositiveInteger|between:1,6'
    ];

    protected $message = [
        'tel' => '请输入有效电话号码',
        'email' => '邮箱格式不符合',
        'department' => '请输入部门名称',
        'duration' => '请选择有效时长'
    ];
}