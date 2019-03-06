<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/1
 * Time: 19:32
 */

namespace app\index\model;


class Record extends BaseModel
{
    protected $hidden = ['id','user_id','update_time','delete_time'];
    public static function getRecord($user_id)
    {
        $record =self::where('user_id','=',$user_id)
            ->order('create_time','DESC')
            ->select();
        return $record;
    }
    public function getExpireTimeAttr($value)
    {
        if ($value != null){
            return date('Y-m-d H:i:s',$value);
        }
        return $value;
    }
    public function getCreateTimeAttr($value)
    {
        if ($value != null){
            return date('Y-m-d',$value);
        }
        return $value;
    }
    public function getConditionAttr($value)
    {
        $review = [0 => '审核中',1 => '通过',2 => '未通过'];
        return $review[$value];
    }
}