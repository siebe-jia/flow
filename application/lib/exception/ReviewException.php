<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/27
 * Time: 16:07
 */

namespace app\lib\exception;


class ReviewException extends BaseException
{
    public $code = 404;
    public $msg = '暂无待审核记录';
    public $errorCode = 20001;
}