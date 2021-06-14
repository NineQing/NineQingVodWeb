<?php
namespace app\admin\controller;
use think\Db;

class Cash extends Base
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
        if($param['status']!=''){
            $where['status'] = ['eq',$param['status']];
        }
        if(!empty($param['uid'])){
            $where['user_id'] = ['eq',$param['uid'] ];
        }
//        if(!empty($param['wd'])){
//            $where['cash_bank_no'] = ['like','%'.$param['wd'].'%' ];
//        }

        $order='id desc';
        $res = model('GoldWithdrawApply')->listData($where,$order,$param['page'],$param['limit']);
		$gold_radio = intval(config('maccms')['user']['gold_ratio']);
        foreach ($res['list'] as &$item){
            $item['gold_num'] = $gold_radio*$item['num'];
        }
        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);

        $this->assign('title','提现管理');
        return $this->fetch('admin@cash/index');
    }

    public function del()
    {
        $param = input();
        $ids = $param['ids'];
        $all = $param['all'];
        if(!empty($ids)){
            $where=[];
            $where['id'] = ['in',$ids];
            if($all==1){
                $where['id'] = ['gt',0];
            }
            $res = model('GoldWithdrawApply')->delData($where);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }
//
//    public function audit()
//    {
//        $param = input();
//        $ids = $param['ids'];
//        if(!empty($ids)){
//            $where=[];
//            $where['cash_id'] = ['in',$ids];
//            $res = model('GoldWithdrawApply')->auditData($where);
//            if($res['code']>1){
//                return $this->error($res['msg']);
//            }
//            return $this->success($res['msg']);
//        }
//        return $this->error('参数错误');
//    }

    public function successApply(){
        $id = input('ids');
        $where['id'] = $id;
        $res = model('GoldWithdrawApply')->success($where);
        if($res['code']>1){
            return $this->error($res['msg']);
        }
        return $this->success($res['msg']);
    }

    public function failApply(){
        $id = input('ids');
        $where['id'] = $id;
        $res = model('GoldWithdrawApply')->fail($where);
        if($res['code']>1){
            return $this->error($res['msg']);
        }
        return $this->success($res['msg']);
    }
}
