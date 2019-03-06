<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/2/27
 * Time: 11:29
 */

namespace app\admin\controller;

use app\admin\model\Record as RecordModel;
use app\admin\validate\ReviewPass;
use app\admin\validate\IDMustInteger;
use app\facade\userSession;
use app\lib\enum\ScopeEnum;
use app\lib\exception\SuccessMessage;
use app\lib\exception\PendingReviewException;
use app\lib\exception\ReviewException;
use think\Controller;

class Review extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['only' => 'getReviewTable']
    ];
    protected function checkLogin()
    {
        $scope = userSession::checkScope();
        if (!$scope){
            $this->redirect('admin/Login/index');
        }else{
            if ($scope >= ScopeEnum::Super){
                return true;
            }else{
                $this->error('没有权限访问');
            }
        }
    }
    public function getReviewTable()
    {
        return $this->fetch('review');
    }
    public function getPendingReview()
    {
        $count = RecordModel::getPendingReviewCount();
        if (empty($count) && $count != 0){
            throw new PendingReviewException();
        }
        $review = RecordModel::getPendingReview();
        if ($review->isEmpty()){
            throw new ReviewException();
        }
        $review->hidden(['user.id','user.create_time']);
        $record = $review->toArray();
        foreach ($record as $key => $value){
            foreach ($value['user'] as $k => $v){
                $record[$key][$k] = $v;
            }
            unset($record[$key]['user']);
        }
        $data = [
            'code' => 200,
            'msg' => '获取待审核记录成功',
            'count' => $count,
            'data' => $record
        ];
        return json($data,200);
    }
    public function reviewPass(){
        (new  ReviewPass())->goCheck();
        $data = input('post.');
        $record = RecordModel::get($data['id']);
        if (!$record){
            throw new PendingReviewException();
        }
        $data['condition'] = 1;
        $record->save($data);
        return json(new SuccessMessage(),200);
    }
    public function reviewRefuse()
    {
        (new IDMustInteger())->goCheck();
        $id = input('post.id');
        $record = RecordModel::get($id);
        if (!$record){
            throw new PendingReviewException();
        }
        $data['condition'] = 2;
        $record->save($data);
        return json(new SuccessMessage(),200);
    }
}