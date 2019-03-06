<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 15:08
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}