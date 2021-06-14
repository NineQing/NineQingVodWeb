<?php

namespace app\common\model;
use think\Db;

class AppInstallRecord extends Base {

    protected $table = 'mac_app_install_record';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

    // 自动完成
    protected $auto = [];
    protected $insert = [];
    protected $update = [];

    public function countData($where) {
        $total = $this->where($where)->count();
        return $total;
    }

    /**
     * 提交记录
     */
    public function saveData($param){
        $data = [];
        $clientIp = $param['client_ip'];
        $inviteUserId = $param['invite_user_id'];
        $osVersion = $param['os'];

        $data['client_ip'] = $clientIp;
        $data['invite_user_id'] = $inviteUserId ? :0;
        $data['update_time'] = time();

        if (!empty($param['id'])){
            // 修改
            $where=[];
            $where['app_install_record_id'] = ['eq',$data['app_install_record_id']];
            $res = $this->allowField(true)->where($where)->update($data);
        }else{
            // 保存
            $data['is_pull'] = 0;
            $datap['os'] = $osVersion;
            $data['create_time'] = time();
            $res = $this->allowField(true)->insert($data);
        }


        if(false === $res){
            return ['code'=>1002,'msg'=>'保存失败：'.$this->getError() ];
        }

        return ['code'=>1,'msg'=>'保存成功'];
    }



}
