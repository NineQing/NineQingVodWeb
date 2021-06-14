<?php
namespace app\admin\controller;
use think\Db;

class User extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function data()
    {
        $param = input();
        $param['page'] = intval($param['page']) <1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) <1 ? $this->_pagesize : $param['limit'];

        $where=[];
        if(in_array($param['status'],['0','1'],true)){
            $where['user_status'] = $param['status'];
        }
        if(!empty($param['group'])){
            $where['group_id'] = $param['group'];
        }
        if(!empty($param['wd'])){
            $param['wd'] = urldecode($param['wd']);
            $where['user_name'] = ['like','%'.$param['wd'].'%'];
        }
        if(!empty($param['pid'])){
            $param['pid'] = urldecode($param['pid']);
            $where['user_pid'] = ['like','%'.$param['pid'].'%'];
        }        
        if(!empty($param['today'])){
            $todayTime = strtotime(date('Y-m-d', time()));
            $toTime = $todayTime + 24 * 3600;
                                $where = [
                                    'user_login_today' => function($query) use($todayTime, $toTime){
                                        $query->where('user_login_today', '>=', $todayTime)->where('user_login_today', '<', $toTime);
                                    }
                                ];            
        }
        $order='user_id desc';
        $res = model('User')->listData($where,$order,$param['page'],$param['limit']);

        $group_list = model('Group')->getCache('group_list');
        foreach($res['list'] as $k=>$v){
            $res['list'][$k]['group_name'] = $group_list[$v['group_id']]['group_name'];
        }

        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);

        $this->assign('group_list',$group_list);

        $this->assign('title','会员管理');
        return $this->fetch('admin@user/index');
    }

    public function reward()
    {
        $param = input();
        $param['page'] = intval($param['page']) <1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) <1 ? $this->_pagesize : $param['limit'];

        $param['uid'] = intval($param['uid']);

        $where=[];

        if(!empty($param['level'])){
            if($param['level']=='1'){
                $where['user_pid'] = ['eq', $param['uid']];
            }
            elseif($param['level']=='2'){
                $where['user_pid_2'] = ['eq', $param['uid']];
            }
            elseif($param['level']=='3'){
                $where['user_pid_3'] = ['eq', $param['uid']];
            }
        }
        else{
            $where['user_pid|user_pid_2|user_pid_3'] = ['eq', intval($param['uid']) ];
        }

        if(!empty($param['wd'])){
            $param['wd'] = urldecode($param['wd']);
            $where['user_name'] = ['like','%'.$param['wd'].'%'];
        }

        $order='user_id desc';
        $res = model('User')->listData($where,$order,$param['page'],$param['limit']);

        $list=[];

        $where2=[];
        $where2['user_pid'] = ['eq', $param['uid']];
        $user_ids_1 = Db::name('User')->where($where2)->column('user_id');
        $level_cc_1 = count($user_ids_1);
        $where3=[];
        $where3['user_id_1'] = ['in',$user_ids_1];
        $points_cc_1 = Db::name('Plog')->where($where3)->sum('plog_points');


        $where2=[];
        $where2['user_pid_2'] = ['eq', $param['uid']];
        $user_ids_2 = Db::name('User')->where($where2)->column('user_id');
        $level_cc_2 = count($user_ids_2);
        $where3=[];
        $where3['user_id_1'] = ['in',$user_ids_2];
        $points_cc_2 = Db::name('Plog')->where($where3)->sum('plog_points');

        $where2=[];
        $where2['user_pid_3'] = ['eq', $param['uid']];
        $user_ids_3 = Db::name('User')->where($where2)->column('user_id');
        $level_cc_3 = count($user_ids_3);
        $where3=[];
        $where3['user_id_1'] = ['in',$user_ids_3];
        $points_cc_3 = Db::name('Plog')->where($where3)->sum('plog_points');


        $data=[];
        $data['level_cc_1'] = intval($level_cc_1);
        $data['level_cc_2'] = intval($level_cc_2);
        $data['level_cc_3'] = intval($level_cc_3);
        $data['points_cc_1'] = intval($points_cc_1);
        $data['points_cc_2'] = intval($points_cc_2);
        $data['points_cc_3'] = intval($points_cc_3);

        $this->assign('data',$data);
        $this->assign('list',$res['list']);
        $this->assign('total',$res['total']);
        $this->assign('page',$res['page']);
        $this->assign('limit',$res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param',$param);

        $this->assign('title','会员管理');
        return $this->fetch('admin@user/reward');
    }


    public function info()
    {
        if (Request()->isPost()) {
            $param = input('post.');
            $res = model('User')->saveData($param);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }

        $id = input('id');
        $where=[];
        $where['user_id'] = ['eq',$id];
        $res = model('User')->infoData($where);


		$config = config('maccms');
        $user = $config['user'];
        $user_level_config = $user['user_level'];
        $user_sub_count = Db::name('user')
            ->where('user_pid',$id)
            // ->whereOr('user_pid_2',$user_id)
            // ->whereOr('user_pid_3',$user_id)
            ->count();
        $data=[];
        $data['user_level'] = 1;
        foreach ($user_level_config as $k=>$v) {

            if ($user_sub_count >= $v['people_count']) {
                $data['user_level'] = str_replace("v", "", $k);
                $data['user_view_count'] = $v['view_count'];
                $data['leave_peoples'] = $v['people_count'] - $user_sub_count > 0 ? $v['people_count'] - $user_sub_count : 0;
                if ($data['leave_peoples'] == 0 and $data['user_level'] < 5) {
                    $data['leave_peoples'] = $user_level_config['v' . ($data['user_level'] + 1)]['people_count'] - $user_sub_count;
                }
            }
        }
        $used_times = model('Ulog')::where('ulog_type', 5)
            ->where('ulog_time', '>=', strtotime(date('Y-m-d') . '00:00:00'))
            ->where('ulog_time', '<=', strtotime(date('Y-m-d') . '23:59:59'))
            ->count();

        $info = $res['info'];
        $info['view_times'] = $data['user_view_count']-$used_times;
        $this->assign('info',$info);
        // $this->assign('info',$res['info']);

        $order='group_id asc';
        $where=[];
        $res = model('Group')->listData($where,$order);
        $this->assign('group_list',$res['list']);

        $this->assign('title','会员信息');
        return $this->fetch('admin@user/info');
    }

    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if(!empty($ids)){
            $where=[];
            $where['user_id'] = ['in',$ids];
            $res = model('User')->delData($where);
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

        if(!empty($ids) && in_array($col,['user_status']) && in_array($val,['0','1'])){
            $where=[];
            $where['user_id'] = ['in',$ids];

            $res = model('User')->fieldData($where,$col,$val);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }




}
