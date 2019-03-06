<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/28
 * Time: 11:57
 */

namespace app\admin\validate;


class IDMustInteger extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];
    protected $message = [
        'id' => '必须是正整数'
    ];
}