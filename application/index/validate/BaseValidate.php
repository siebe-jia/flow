<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 19:07
 */

namespace app\index\validate;

use app\lib\exception\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    // 获取HTTP传入的参数
    // 对这些参数进行校验
    public function goCheck(){
        $params = Request::param();
        $result = $this->batch()->check($params);
        if (!$result){
            throw new ParameterException([
                'msg' => $this->error,
                'code' => 400
            ]);
        }else{
            return true;
        }
    }

    protected function isNotEmpty($value)
    {
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }
}