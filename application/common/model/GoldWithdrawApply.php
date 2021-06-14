<?php

namespace app\common\model;
use think\Db;

class GoldWithdrawApply extends Base {

    // 设置数据表（不含前缀）
    protected $name = 'gold_withdraw_apply';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

    // 自动完成
    protected $auto       = [];
    protected $insert     = [];
    protected $update     = [];


    public function countData($where)
    {
        $total = $this->where($where)->count();
        return $total;
    }

    public function listData($where,$order,$page=1,$limit=20,$start=0)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        $total = $this->where($where)->count();
        $list = Db::name('GoldWithdrawApply')->where($where)->order($order)->limit($limit_str)->select();

        $gold_radio = intval(config('maccms')['user']['gold_ratio']);
        $user_ids=[];
        foreach($list as $k=>&$v){
            if($v['user_id'] >0){
                $user_ids[$v['user_id']] = $v['user_id'];
            }
            $v['gold_num'] = $gold_radio*$v['num'];
        }

        if(!empty($user_ids)){
            $where2=[];
            $where['user_id'] = ['in', $user_ids];
            $order='user_id desc';
            $user_list = model('User')->listData($where2,$order,1,999);
            $user_list = mac_array_rekey($user_list['list'],'user_id');

            foreach($list as $k=>&$v){
                $list[$k]['user_name'] = $user_list[$v['user_id']]['user_name'];
            }
        }

        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }

    public function infoData($where,$field='*')
    {
        if(empty($where) || !is_array($where)){
            return ['code'=>1001,'msg'=>'参数错误'];
        }
        $info = $this->field($field)->where($where)->find();

        if(empty($info)){
            return ['code'=>1002,'msg'=>'获取数据失败'];
        }
        $info = $info->toArray();

        return ['code'=>1,'msg'=>'获取成功','info'=>$info];
    }

    public function saveData($param)
    {


        $data['user_id'] = $param['user_id'];
        $data['num'] = $param['num'];

        $user = model('User')->find(['user_id' => $data['user_id']]);
        if (!$user){
            return ['code'=>10002,'msg'=>'用户不存在'];
        }
        $gold_min = intval(config('maccms')['user']['gold_min']);
        $gold_radio = intval(config('maccms')['user']['gold_ratio']);
        if ($user['user_gold']/$gold_radio < $data['num']){
            return ['code'=>10001,'msg'=>'金币不足, 无法提现'];
        }
        if(floor($user['user_gold']/$gold_radio)<$gold_min || intval($param['num'])<$gold_min){
            return ['code'=>10005,'msg'=>'最低提现金额为'.$gold_min];
        }
        $data['remark'] = $param['remark'];

        $data['account'] = $param['account'];
        $data['realname'] = $param['realname'];
        $data['type'] = $param['type'];

        if (!in_array($data['type'], [1,2])){
            return ['code'=>10003,'msg'=>'不支持的提现方式'];
        }


        $data['created_time'] = time();
        $data['updated_time'] = time();


        if(!empty($param['id'])){
            $where=[];
            $where['id'] = ['eq',$param['id']];
            $res = $this->allowField(true)->where($where)->update($data);
        }
        else{
            $res = $this->allowField(true)->insert($data);
            $res2 = model('User')->where('user_id', $data['user_id'])->setDec('user_gold', $gold_radio*$data['num']);
            if ($res2){
                $data2 = [];
                $data2['user_id'] = $data['user_id'];
                $data2['glog_type'] = 4;
                $data2['glog_gold'] = $gold_radio*$data['num'];
                $data2['glog_remarks'] = '发起提现，';
                model('Glog')->saveData($data2);
            }
        }
        if(false === $res){
            return ['code'=>1004,'msg'=>'保存失败：'.$this->getError() ];
        }

        return ['code'=>1,'msg'=>'保存成功'];
    }

    public function success($param){
        $id = $param['id'];
        if (!$id){
            return ['code' => 10001, 'msg' => '缺少参数ID'];
        }
        $info = $this->where('id', $id)->find();
        if ($info === false){
            return ['code' => 10001, 'msg' => '申请记录不存在' ];
        }

        if ($info['status'] != 0){
            return ['code' => 10002, 'msg' => '申请已经处理过了，请不要重复操作'];
        }



        $res = $this->where('id', $id)->update(['status' => 1, 'success_time' => time(),'updated_time' => time()]);

        if ($res === false){
            return ['code' => 10004, 'msg' => '操作失败'];
        }

        return ['code' => 1, 'msg' => '操作成功'];

    }

    public function fail($param){
        $id = $param['id'];
        if (!$id){
            return ['code' => 10001, 'msg' => '缺少参数ID'];
        }
        $info = $this->where('id', $id)->find();
        if ($info === false){
            return ['code' => 10001, 'msg' => '申请记录不存在' ];
        }

        if ($info['status'] != 0){
            return ['code' => 10002, 'msg' => '申请已经处理过了，请不要重复操作'];
        }



        $res = $this->where('id', $id)->update(['status' => 2, 'fail_time' => time(),'updated_time' => time()]);
		$gold_radio = intval(config('maccms')['user']['gold_ratio']);
        $res2 = model('User')->where('user_id', $info['user_id'])->setInc('user_gold', $gold_radio*$info['num']);
        if ($res2){
            $data2 = [];
            $data2['user_id'] = $info['user_id'];
            $data2['glog_type'] = 5;
            $data2['glog_gold'] = $gold_radio*$info['num'];
            $data2['glog_remarks'] = '提现失败，原路返回账户';
            model('Glog')->saveData($data2);
        }



        if ($res === false && $res2 == false){
            return ['code' => 10004, 'msg' => '操作失败'];
        }

        return ['code' => 1, 'msg' => '操作成功'];


    }

    public function delData($where)
    {
        $res = $this->where($where)->delete();
        if($res===false){
            return ['code'=>1001,'msg'=>'删除失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'删除成功'];
    }

    public function fieldData($where,$col,$val)
    {
        if(!isset($col) || !isset($val)){
            return ['code'=>1001,'msg'=>'参数错误'];
        }

        $data = [];
        $data[$col] = $val;
        $res = $this->allowField(true)->where($where)->update($data);
        if($res===false){
            return ['code'=>1001,'msg'=>'设置失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'设置成功'];
    }

}
