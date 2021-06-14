<?php

namespace app\api\controller\v1;
use think\Log;
/**
 * 回会话验证模块
 * Class Auth
 * @package app\api\controller\v1
 */
class Auth extends Base {

    /**
     * 微信或QQ登录
     * type 1 微信登录  2 QQ登录
     * openid
     */
    public function postWxlogin()
    {
        $post = input();
        if (empty($post['openid']))$this->error('缺少参数');
        if ($post['type'] == 1){
            $row = \app\common\model\User::get(['user_openid_weixin'=>$post['openid']]);
        }else{
            $row = \app\common\model\User::get(['user_openid_qq'=>$post['openid']]);
        }

        if (is_null($row)){
            $config = config('maccms');


            if ($config['user']['status'] == 0 || $config['user']['reg_open'] == 0) {
                return ['code' => 1001, 'msg' => '未开放注册'];
            }

            $ip = sprintf('%u',ip2long(request()->ip()));
            if($ip>2147483647){
                $ip=0;
            }

            if( $GLOBALS['config']['user']['reg_num'] > 0){
                $where2=[];
                $where2['user_reg_ip'] =['eq',$ip];
                $cc = model('user')->where($where2)->count();
                if($cc >= $GLOBALS['config']['user']['reg_num'])
                    $this->error('每IP每日限制注册' . $GLOBALS['config']['user']['reg_num'] . '次');

            }

            $fields = [];


            $fields['user_nick_name'] = $this->getRandomUsername();
            $fields['user_name'] = mt_rand(100000000000,999999999999);
            $fields['user_pwd'] = md5($fields['user_name']);
            $fields['group_id'] = 2;
            $fields['user_points'] = intval($config['user']['reg_points']);
            $fields['user_status'] = intval($config['user']['reg_status']);
            $fields['user_reg_time'] = time();
            $fields['user_reg_ip'] = $ip;
            if ($post['type'] == 1){
                $fields['user_openid_weixin'] = (string)$post['openid'];
            }else{
                $fields['user_openid_qq'] = (string)$post['openid'];
            }

            $nid = model('user')->insertGetId($fields);
            if (empty($nid))
                $this->error('注册失败');

            $row = \app\common\model\User::get(['user_id'=>$nid]);
        }
        if ($post['type'] == 1){
            $param = [
                'openid' =>  $post['openid'],
                'col' =>  'user_openid_weixin',
            ];
        }else{
            $param = [
                'openid' =>  $post['openid'],
                'col' =>  'user_openid_qq',
            ];
        }

        $res = model('User')->login($param);
        $code = $res['code'];
        if($code == 1){
            $this->success();
        }else{
            $this->error($res['msg']);
        }

//        if($row['group_id'] > 2 &&  $row['user_end_time'] < time()) {
//            $row['group_id'] = 2;
//            $update['group_id'] = 2;
//        }
//
//        $random = md5(rand(10000000, 99999999));
//        $ip = sprintf('%u',ip2long(request()->ip()));
//        if($ip>2147483647){
//            $ip=0;
//        }
//        $update['user_random'] = $random;
//        $update['user_login_ip'] = $ip;
//        $update['user_login_time'] = time();
//        $update['user_login_num'] = $row['user_login_num'] + 1;
//        $update['user_last_login_time'] = $row['user_login_time'];
//        $update['user_last_login_ip'] = $row['user_login_ip'];
//
//
//        $res = \app\common\model\User::where(['user_id'=>$row['user_id']])->update($update);
//        if ($res === false) {
//            $this->error('更新登录信息失败');
//        }
//
//        //用户组
//        $group_list = model('Group')->getCache('group_list');
//        $group = $group_list[$row['group_id']];
//
//        cookie('user_id', $row['user_id'],['expire'=>2592000] );
//        cookie('user_name', $row['user_name'],['expire'=>2592000] );
//        cookie('user_nick_name', $row['user_nick_name'],['expire'=>2592000] );
//        cookie('group_id', $group['group_id'],['expire'=>2592000] );
//        cookie('group_name', $group['group_name'],['expire'=>2592000] );
//        cookie('user_check', md5($random . '-' . $row['user_id'] ),['expire'=>2592000] );
//        cookie('user_portrait', mac_get_user_portrait($row['user_id']),['expire'=>2592000] );

    }


    /**
     * 登陆接口
     */
    public function postLogin(){

        if (Request()->isPost()) {
            $param = input();
            $res = model('User')->login($param);
            $code = $res['code'];
            if($code == 1){
                $this->success();
            }else{
                $this->error($res['msg']);
            }
        }else{
            $this->errorNotFountd('Not Found');
        }
    }


    /**
     * 注册接口
     */
    public function postRegister(){
        if (Request()->isPost()) {
            $param = input();
            // $param['uid']  = cookie('invite_by_user_id');
            Log::mylog('注册用户参数：', $param, 'reg');
            $res = model('User')->register($param);
            $code = $res['code'];
            if($code == 1){
                $this->success();
            }else{
                $this->error($res['msg']);
            }
        }else{
            $this->errorNotFountd('Not Found');
        }
    }

    /**
     * 退出登陆
     */
    public function deleteLogout(){
        $res = model('User')->logout();
        return $this->success();
    }

    public function getRegisterSms()
    {
        $param = input();
        $res = model('User')->reg_msg($param);
        if($res['code'] == 1){
            $this->success();
        }else{
            $this->error($res['msg']);
        }
    }
    
        public function getRandomUsername(){
        static $times = 0;
        if ($times >= 1000){
            throw new \Exception('出错了！');
        }
        $times++;
        $prefix = $GLOBALS['config']['user']['reg_autoname_prefix'];
        // $name = uniqid($prefix);
        // $name = substr($name,0,strlen($prefix)+5);
        $name = $prefix.mac_get_rndstr($times+4);

        return $name;
    }

}
