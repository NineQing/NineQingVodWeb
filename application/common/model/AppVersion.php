<?php
namespace app\common\model;
use think\Db;

class AppVersion extends Base {


    // 设置数据表（不含前缀）
    protected $name = 'app_version';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    protected $autoWriteTimestamp = true;

    const osAndroid = 1;
    const osIos = 2;
    const osArr = [self::osAndroid, self::osIos];


    public function listData($where,$order,$page=1,$limit=20,$start=0){
            if(!is_array($where)){
                $where = json_decode($where,true);
            }
            $limit_str = ($limit * ($page-1) + $start) .",".$limit;
            $total = $this->where($where)->count();
            $list = $this->where($where)->order($order)->limit($limit_str)->select();

            return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];

    }

    public function saveData($prame){


        $version = $prame['version'];
        $os = $prame['os'];
        $url = $prame['url'];
        $summary = $prame['summary'];
        $isRequired = $prame['is_required'];
        $type = $prame['type'];
        if (empty($version) || empty($os) && empty($url) && empty($summary)){
            return ['code' => 1001, 'msg' => '参数错误'];
        }


        if (!in_array($os, self::osArr)){
            return ['code' => 1002, 'msg' => '系统参数错误'];
        }
//        $res = $this->infoData(['version' => $version]);
//        if ($res['code'] == 1){
//            return ['code' => 1002, 'msg' => '版本号已经存在'];
//        }


        $data['type'] = $type ?  : 1;
        $data['version'] = $version;
        $data['version'] = $version;
        $data['summary'] = $summary;
        $data['url'] = $url;
        $data['os'] = $os;
        $data['is_required'] = $isRequired ? 1 : 0;
        if(!empty($prame['app_version_id'])){
            $where=[];
            $where['app_version_id'] = ['eq',$prame['app_version_id']];
            $data['update_time'] = time();
            $res = $this->allowField(true)->where($where)->update($data);
        }else{
            $data['create_time'] = time();
            $data['update_time'] = time();
            $res = $this->allowField(true)->insert($data);
        }
        if(false === $res){
            return ['code'=>1004,'msg'=>'保存失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'保存成功'];
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

    public function delData($where)
    {
        $res = $this->where($where)->delete();
        if($res===false){
            return ['code'=>1001,'msg'=>'删除失败：'.$this->getError() ];
        }

        return ['code'=>1,'msg'=>'删除成功'];
    }



}