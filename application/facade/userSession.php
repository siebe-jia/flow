<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/25
 * Time: 20:32
 */

namespace app\facade;


class userSession extends \think\Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\userSession';
    }
}