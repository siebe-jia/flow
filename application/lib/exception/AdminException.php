<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 21:47
 */

namespace app\lib\exception;


class AdminException extends BaseException
{
    public $code = 400;
    public $msg = '用户不存在';
    public $errorCode = 30000;
}