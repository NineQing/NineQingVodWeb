<?php

namespace app\common\model;
use think\Db;

class Danmu extends Base {

    protected $table = 'mac_danmu';

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

    /**
     * 获取弹幕列表
     */
    public function listData($where,$order,$page=1,$limit=20,$start=0,$field='*',$addition=1,$totalshow=1){
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        if($totalshow==1) {
            $total = $this->where($where)->count();
        }
        $list = Db::name('Danmu')->field($field)->where($where)->order($order)->limit($limit_str)->select();

        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }


    /**
     * 提交弹幕
     */
    public function saveData($param){
        $data = [];
        $content = $param['content'];
        $atTime = $param['at_time'];
        $vodId = $param['vod_id'];
        $userId = $param['user_id'];

        if (empty($vodId)){
            return ['code' => 10001, 'msg' => '缺少参数视频ID'];
        }

        if (empty($userId)){
            return ['code' => 10001, 'msg' => '缺少参数用户ID'];
        }

        if (empty($atTime)){
            return ['code' => 10001, 'msg' => '缺少参数视频当前播放时间，单位：秒'];
        }

        if (empty($content)){
            return ['code' => 10001, 'msg' => '缺少参数弹幕内容'];
        }

        $data['danmu_time'] = time();
        $data['at_time'] = $atTime;
        $data['content'] = $content;
        $data['vod_id'] = $vodId;
        $data['status'] = 1;
        $data['dianzan_num'] = 0;
        $data['user_id'] = $userId;

        $res = $this->allowField(true)->insert($data);
        if(false === $res){
            return ['code'=>1002,'msg'=>'保存失败：'.$this->getError() ];
        }

        return ['code'=>1,'msg'=>'保存成功'];
    }

    /**
     * 删除弹幕
     */
    public function delData(){

    }

    /**
     * 列表缓存
     */
    public function listCacheData(){

    }

    /**
     * 修改单个字段
     * @param $where
     * @param $col
     * @param $val
     * @return array
     */
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