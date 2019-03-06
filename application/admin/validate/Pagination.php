<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/27
 * Time: 16:43
 */

namespace app\admin\validate;


class Pagination extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'limit' => 'isPositiveInteger'
    ];
    protected $message = [
        'page' => '必须是正整数',
        'limit' => '必须是正整数'
    ];
}