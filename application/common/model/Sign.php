<?php
namespace app\common\model;
use think\Db;
use think\Cache;
use app\common\util\Pinyin;

class Sign extends Base {
    // 设置数据表（不含前缀）
    protected $name = 'sign';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    protected $autoWriteTimestamp = true;

    // 自动完成
    protected $auto       = [];
    protected $insert     = [];
    protected $update     = [];

    public function saveData($data){
//        $validate = \think\Loader::validate('Sign');
        $config = config('task.sign');

        if (!$config['status']){
            return ['code' => 1001, 'msg' => '活动未开放'];
        }

        if (!$GLOBALS['user']){
            return ['code' => 1002, 'msg' => '请先登录'];
        }

        $curTimes = time();
        $date = date('Y-m-d', $curTimes);
        $res = $this->infoData(['date' => $date,'user_id'=>$GLOBALS['user']['user_id']]);
        if ($res['code'] == 1){
            return ['code' => 1003, 'msg' => '今天签过到了'];
        }

        $reword = $config['reward'];
        $add_score=0;
        if ($reword['points'] > 0){
            $user['user_id'] = $GLOBALS['user']['user_id'];
            $res = model('User')->where($user)->setInc('user_points', $reword['points']);
            if (false === $res){
                return ['code' => 1004, 'msg' => '奖励发放失败，签到失败'];
            }
            $add_score =$reword['points'];
            //积分日志
            $plog = [];

            $plog['user_id'] = $GLOBALS['user']['user_id'];
            input('user_id', $plog['user_id']);
            $plog['plog_type'] = 10;
            $plog['plog_points'] =  $reword['points'];
            $res = model('Plog')->saveData($plog);
            if ($res['code'] > 1){
                return ['code' => 1005, 'msg' => $res['msg']];
            }
        }
        $data = [
            'user_id' => cookie('user_id'),
            'date' => $date,
            'reward' => json_encode($reword)
        ];
        $data['create_time'] = time();
        $data['update_time'] = time();
        $res = $this->allowField(true)->insert($data);
        if(false === $res){
            return ['code'=>1004,'msg'=>'保存失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'保存成功','score'=>$add_score];
    }

    public function infoData($where,$field='*'){
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

}