<?php
namespace app\admin\controller;
use think\Db;

class Category extends Base
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

        $where=['pid'=>0];
        // if(in_array($param['status'],['0','1'],true)){
        //     $where['topic_status'] = ['eq',$param['status']];
        // }
        // if(!empty($param['wd'])){
        //     $param['wd'] = urldecode($param['wd']);
        //     $where['topic_name'] = ['like','%'.$param['wd'].'%'];
        // }

        $order='sort asc,create_time desc';
        $res = model('category')->listData($where,$order,$param['page'],$param['limit']);
   
        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);
        $this->assign('title','栏目分类管理');
        return $this->fetch('admin@category/index');
    }

    public function info()
    {
        if (Request()->isPost()) {
            $param = input('post.');
            $res = model('category')->saveData($param);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }


        $id = input('id');
        $where=[];
        $where['id'] = ['eq',$id];
        $res = model('category')->infoData($where);
        $this->assign('info',$res['info']);
        $catList = db("category")->where("pid=0")->select();
        $this->assign('catList',$catList);
        return $this->fetch('admin@category/info');
    }


    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if(!empty($ids)){
            $where=[];
            $where['id'] = ['in',$ids];
            $res = model('category')->delData($where);
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

            $res = model('Category')->fieldData($where,$col,$val);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }
}