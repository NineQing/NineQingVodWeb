<?php
namespace app\admin\controller;
use think\Db;

class Ad extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $param = input();
        $param['page'] = intval($param['page']) <1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) <1 ? $this->_pagesize : $param['limit'];

        $where=[];


        $order='sort asc,create_time desc';
        $res = model('Ad')->listData($where,$order,$param['page'],$param['limit']);
   
        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);
        $this->assign('title','广告管理');
        return $this->fetch('admin@Ad/index');
    }

    public function info()
    {
        if (Request()->isPost()) {
            $param = input('post.');
            $res = model('Ad')->saveData($param);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }


        $id = input('id');
        $where=[];
        $where['id'] = ['eq',$id];
        $res = model('Ad')->infoData($where);
        $this->assign('info',$res['info']);
        $typeList = model("Adtype")->where(["status"=>1])->select();
        $this->assign('typeList',$typeList);
        return $this->fetch('admin@ad/info');
    }

    
    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if(!empty($ids)){
            $where=[];
            $where['id'] = ['in',$ids];
            $res = model('Ad')->delData($where);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }


    public function field()
    {
        $param = input();
        $ids = $param['ids'];
        $col = $param['col'];
        $val = $param['val'];

        if(!empty($ids) && in_array($col,['status']) && in_array($val,['0','1'])){
            $where=[];
            $where['id'] = ['in',$ids];

            $res = model('Ad')->fieldData($where,$col,$val);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }

}