<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 19:42
 */

namespace app\lib\exception;


class ApplyAddException extends BaseException
{
    public $code = 400;
    public $msg = '提交失败';
    public $errorCode = 20002;
}