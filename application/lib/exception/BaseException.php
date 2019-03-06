<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 10:05
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP 状态码 404，200
    public $code = 400;
    //具体错误信息
    public $msg = '参数错误';
    //自定义错误码
    public $errorCode = 10000;
    public function __construct($params = [])
    {
        if (array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}