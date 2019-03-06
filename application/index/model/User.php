<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 16:57
 */

namespace app\index\model;


class User extends BaseModel
{
    protected $hidden = ['id','create_time','update_time','delete_time'];
}