<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/3
 * Time: 16:59
 */

namespace app\lib\exception;


class UserMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的用户不存在';
    public $errorCode = 30001;
}