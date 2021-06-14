<?php
namespace app\api\controller\v1;
use think\Controller;

class Gbook extends Base
{
    var $_config;
    public function __construct()
    {
        parent::__construct();
        //关闭中
        if($GLOBALS['config']['gbook']['status'] == 0){
            return $this->error('gbook is close');
        }
    }


    public function getIndex(){
        $param = input();
        $page = 1;
        $limit = 20;
        if(!empty($param['page'])){
        	$page = $param['page'];
        }
        if(!empty($param['limit'])){
        	$limit = $param['limit'];
        }
        $res = model('Gbook')->listData([],'gbook_time desc',$page,$limit);
        if ($res['code'] == 1){
            $data = [
                'limit' => $res['limit'],
                'page' => $res['page'],
                'total' => $res['total'],
                'list' => $res['list'],
            ];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
    }

    public function postIndex(){
        $res = $this->saveData();
        if ($res['code'] == 1){
            //cookie('gbook_timespan', 't', $GLOBALS['config']['gbook']['timespan']);
            return $this->success();
        }else{
            return $this->error($res['msg']);
        }
    }

    public function deleteIndex(){
        $id = input('id');
        if (!$id){
            $this->error('缺少参数ID');
        }
        $param = [
            'gbook_id' => $id
        ];
        $res = model('Gbook')->delData($param);
        if ($res['code'] == 1){
            return $this->success();
        }else{
            return $this->error();
        }
    }



    public function saveData() {
        $param = input();

        if($GLOBALS['config']['gbook']['verify'] == 1){
            if(!captcha_check($param['verify'])){
                return ['code'=>1002,'msg'=>'验证码错误'];
            }
        }

        if($GLOBALS['config']['gbook']['login'] ==1){
            // 判断是否登陆
            if(empty(cookie('user_id'))){
                return ['code' => 1003, 'msg' => '登录后才可以发表留言'];
            }
            $res = model('User')->checkLogin();
            if($res['code']>1) {
                return ['code' => 1003, 'msg' => '登录后才可以发表留言'];
            }
        }

        if(empty($param['gbook_content'])){
            return ['code'=>1004,'msg'=>'留言内容不能为空'];
        }

        $cookie =cookie('gbook_timespan');
        if(!empty(cookie('gbook_timespan'))){
            return ['code'=>1005,'msg'=>'请不要频繁操作'];
        }

        $pattern = '/[^\x00-\x80]/';
        if(!preg_match($pattern,$param['gbook_content'])){
            return ['code'=>1005,'msg'=>'内容必须包含中文,请重新输入'];
        }
        $param['gbook_content']= htmlentities(mac_filter_words($param['gbook_content']));
        $param['gbook_reply'] = '';

        if(empty(cookie('user_id'))){
            $param['gbook_name'] = '游客';
        }
        else{
            $param['gbook_name'] = cookie('user_nick_name');
            $param['user_id'] = intval(cookie('user_id'));
        }
        $param['gbook_name'] = htmlentities($param['gbook_name']);

        if($GLOBALS['config']['gbook']['audit'] ==1){
            $param['gbook_status'] = 0;
        }

        $ip = sprintf('%u',ip2long(request()->ip()));
        if($ip>2147483647){
            $ip=0;
        }
        $param['gbook_ip'] = $ip;

        $res = model('Gbook')->saveData($param);

        if($res['code']>1){
            return $res;
        } else{
            cookie('gbook_timespan', '1',$GLOBALS['config']['gbook']['timespan'] );
            $res['code']=2;
            if($GLOBALS['config']['gbook']['audit'] ==1){
                $res['msg'] = '谢谢，我们会尽快审核你的发言！';
            }
            else{
                $res['msg'] = '感谢你的留言！';
            }
            return $res;
        }
    }

}
