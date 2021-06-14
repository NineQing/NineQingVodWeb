<?php


namespace app\admin\controller;


class Groupchat extends Base
{
    /*消息通知列表页面*/
    public function index()
    {
        $param = input();
        $param['page'] = intval($param['page']) <1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) <1 ? $this->_pagesize : $param['limit'];

        $where=[];


        $order='id asc';
        $res = model('GroupChat')->listData($where,$order,$param['page'],$param['limit']);

        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);
        $this->assign('title','群聊列表');
        return $this->fetch('admin@groupchat/index');
    }
    public function info()
    {
        if (Request()->isPost()) {
            $param = input('post.');
            $res = model('GroupChat')->saveData($param);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }


        $id = input('id');
        $where=[];
        $where['id'] = ['eq',$id];
        $res = model('GroupChat')->infoData($where);
        $this->assign('info',$res['info']);
        return $this->fetch('admin@groupchat/info');
    }

    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if(!empty($ids)){
            $where=[];
            $where['id'] = ['in',$ids];
            $res = model('GroupChat')->delData($where);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }
}
