<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/4
 * Time: 11:57
 */

namespace app\lib\exception;


class RecordMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的流量账号信息不存在';
    public $errorCode = 20003;
}