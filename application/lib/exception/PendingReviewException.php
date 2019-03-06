<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 10:21
 */

namespace app\lib\exception;


class PendingReviewException extends BaseException
{
    public $code = 404;
    public $msg = '待审核记录不存在';
    public $errorCode = 20000;
}