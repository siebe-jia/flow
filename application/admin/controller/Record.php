<?php
/**
 * Created by PhpStorm.
 * User: jakin
 * Date: 2019/3/2
 * Time: 12:03
 */

namespace app\admin\controller;

use app\admin\model\Record as RecordModel;
use app\admin\validate\IDMustInteger;
use app\admin\validate\Pagination;
use app\facade\userSession;
use app\index\validate\ApplyValidate;
use app\lib\enum\ScopeEnum;
use app\lib\exception\RecordMissException;
use app\lib\exception\SuccessMessage;
use think\Controller;
use think\Exception;

class Record extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['only' => 'index,getUserInfo,getUserDetail']
    ];
    protected function checkLogin(){
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
    public function index()
    {
        return $this->fetch('index');
    }
    public function getRecordInfo()
    {
        (new Pagination())->goCheck();
        $action = input('get.');
        $record = RecordModel::getRecordInfo($action);
        if ( $record->isEmpty()){
            $data = [
                'code' => 200,
                'msg' => '获取流量账号信息失败',
                'count' => 0,
                'data' => []
            ];
            return json($data,400);
        }
        $result = $record->hidden(['user'=>['create_time','id']])->toArray();
        foreach ($result as $key => $value){
            foreach ($value['user'] as $k => $v){
                $result[$key][$k] = $v;
            }
            unset($result[$key]['user']);
        }
        $data = [
            'code' => 200,
            'msg' => '获取流量账号信息成功',
            'count' => count($result),
            'data' => $result
        ];
        return json($data,200);
    }
    public function getRecordDetail($id)
    {
        (new IDMustInteger())->goCheck();
        $record = RecordModel::getRecordByID($id);
        if (!$record){
            throw new RecordMissException();
        }
        $result = $record->hidden(['user' =>['id','create_time']])->toArray();
        foreach ( $result['user'] as $k => $v){
                $result[$k] = $v;
        }
        unset($result['user']);
        $duration = [0 => '1个月',1 => '2个月',2 => '3个月'];
        $condition = [0 => '审核中',1 => '通过',2 => '未通过'];
        $this->assign('duration',$duration);
        $this->assign('condition',$condition);
        $this->assign('record',$result);
        return $this->fetch('detail');
    }
    public function updateRecord($id)
    {
        (new ApplyValidate())->goCheck();
        $data = input('post.');
        $record = RecordModel::get($id);
        $record->allowField(true)->save($data);
        $res= $record->id;
        if (!$res){
            throw new Exception();
        }
        return json(new SuccessMessage(),200);
    }
    public function delRecordByID()
    {
        (new IDMustInteger())->goCheck();
        $id = input('post.id');
        $res = RecordModel::delRecordByID($id);
        if (!$res){
            throw new Exception();
        }
        return json(new SuccessMessage(),200);
    }
}