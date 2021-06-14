<?php

namespace app\admin\controller;

class Appversion extends Base {

    var $_pre;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $param = input();
        $list = [];
        $res = model('AppVersion')->listData($param, ['version desc']);
        if ($res['code'] == 1){
            $list = $res['list'];
        }
        $this->assign('list',$list);
        $this->assign('title','定时任务管理');

        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);


        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);

        $this->assign('title','App版本管理');
        return $this->fetch('admin@appversion/index');
    }

    public function info()
    {
        $param = input();
        $param['app_version_id'] = $param['id'];
        if (Request()->isPost()) {

            $res = model('AppVersion')->saveData($param);
            if($res['code'] > 1){
                return $this->error($res['msg']);
            }

            return $this->success('保存成功!');
        }
        $where = [];
        $where['app_version_id'] = $param['id'];
        $res = model('AppVersion')->infoData($where);
        $info = $res['info'];
        $this->assign('info',$info);
        $this->assign('title','版本信息');
        return $this->fetch('admin@appversion/info');
    }

    public function del()
    {
        $param = input();
        $where=[];
        $where['app_version_id'] = ['in',$param['ids']];
        $res = model('AppVersion')->delData($where);
        if($res['code'] > 1){
            return $this->error('删除失败，请重试!');
        }

        return $this->success('删除成功!');
    }



}