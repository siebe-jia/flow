<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/26
 * Time: 14:45
 */

namespace app\admin\model;

use think\model\concern\SoftDelete;

class User extends BaseModel
{
    protected $hidden = ['update_time','delete_time'];
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function record()
    {
        return $this->hasMany('Record','user_id','id');
    }
    public function getCreateTimeAttr($value)
    {
        if ($value != null){
            return date('Y-m-d H:i',$value);
        }
        return $value;
    }
    public static function getUserInfo($action)
    {
        $page = $action['page'];
        $limit = $action['limit'];
        $page = ($page - 1) * $limit;
        if (!isset($action['key'])){
            $userInfo = self::withCount(['record'=>'apply_count'])
                ->limit($page,$limit)
                ->select();
        }else{
            $key = $action['key'];
            if(!empty($key['username'])&&empty($key['real_name'])){
                $userInfo = self::withCount(['record'=>'apply_count'])
                    ->where('username','like',$key['username'].'%')
                    ->limit($page,$limit)
                    ->select();
            }elseif(!empty($key['real_name'])&&empty($key['username'])){
                $userInfo = self::withCount(['record'=>'apply_count'])
                    ->where('real_name','like',$key['real_name'].'%')
                    ->limit($page,$limit)
                    ->select();
            }else{
                $userInfo = self::withCount(['record'=>'apply_count'])
                    ->where('username','like',$key['username'].'%')
                    ->where('real_name','like',$key['real_name'].'%')
                    ->limit($page,$limit)
                    ->select();
            }
        }
        return $userInfo;
    }
    public static function getUserByID($id)
    {
        $user = self::with(['record' => function($query){
            $query->order('create_time','DESC');
        }])->find($id);
        return $user;
    }
    public static function delRecordByID($id)
    {
        $record = self::get($id);
        $res= $record->delete();
        return $res;
    }
}