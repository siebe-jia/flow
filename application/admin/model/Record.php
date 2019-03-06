<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 9:17
 */

namespace app\admin\model;

use think\model\concern\SoftDelete;

class Record extends BaseModel
{
    protected $hidden = ['user_id','update_time','delete_time'];
    protected $update = ['expire_time','update_time'];
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function user()
    {
        return $this->belongsTo('User','user_id','id');
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
            return date('Y-m-d H:i',$value);
        }
        return $value;
    }
    public function getConditionAttr($value)
    {
        $review = [0 => '审核中',1 => '通过',2 => '未通过'];
        return $review[$value];
    }
    protected function setExpireTimeAttr($value)
    {
        return strtotime($value);
    }

    public static function getPendingReviewCount()
    {
        $count = self::where('condition','=',0)
            ->count();
        return $count;
    }
    public static function getPendingReview()
    {
        $review = self::with(['user'])
            ->where('condition','=',0)
            ->order('create_time','asc')
            ->select();
        return $review;
    }

    public static function getRecordInfo($action)
    {
        $page = $action['page'];
        $limit = $action['limit'];
        $page = ($page - 1) * $limit;
        if (!isset($action['key'])){
            $recordInfo = self::with(['user'])
                ->limit($page,$limit)
                ->select();
        }else{
            $key = $action['key'];
            if(!empty($key['account'])){
                $recordInfo = self::with(['user'])
                    ->where('account','like',$key['account'].'%')
                    ->limit($page,$limit)
                    ->select();
            }else{
                $recordInfo = self::with(['user'])
                    ->limit($page,$limit)
                    ->select();
            }
        }
        return $recordInfo;
    }
    public static function getRecordByID($id)
    {
        $user = self::with(['user'])->find($id);
        return $user;
    }

    public static function delRecordByID($id)
    {
        $record = self::get($id);
        $res= $record->delete();
        return $res;
    }
}