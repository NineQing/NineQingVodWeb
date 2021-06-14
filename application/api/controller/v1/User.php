<?php

namespace app\api\controller\v1;
use aliyun\Alipay;
use think\Log;
use app\common\model\Vlog;
use think\Db;
use Wechat\Wxpay;

class User extends Base {

    public function __construct()
    {
        parent::__construct();
        // $this->checkLogin();

    }

    public function getDetail(){


        $this->checkLogin();

        $res = $GLOBALS['user'];
        $res['user_pwd'] = null;


        if ($res['group'] && $res['group']['group_popedom']){
            foreach ($res['group']['group_popedom'] as &$val){
                $val = array_values($val);
            }
        }

        if (!empty($res['user_portrait'])){
            $res['user_portrait'] = $res['user_portrait'] .'?s='.time();
        }

        // $data = $res;

        // $config = config('maccms');
        // $user = $config['user'];
        // $leave_times = 0;
        // if(!empty($user['everyday_times']) and $user['everyday_times']>0){
        //     $used_times = model('Ulog')::where('ulog_type',5)
        //         ->where('ulog_time','>=',strtotime(date('Y-m-d').'00:00:00'))
        //         ->where('ulog_time','<=',strtotime(date('Y-m-d').'23:59:59'))
        //         ->count();

        //     $leave_times = $user['everyday_times']-$used_times;
        // }else{
        //     $leave_times = $res['view_times'];
        // }
        // $data['leave_times'] = $leave_times;

        // return $this->success($data);
        $data = $res;
        $user_id = $res['user_id'];

        $config = config('maccms');
        $user = $config['user'];
        $user_level_config = $user['user_level'];
        // dump($user_level_config);
        $user_login_today = Db::name('user')
            ->where('user_id',$user_id)
            ->value('user_login_today');
		$todayTime = strtotime(date('Y-m-d', time()));
		$toTime = $todayTime + 24 * 3600;
		if($user_login_today < $todayTime){
			$user_login_today_update = Db::name('user')
				->where('user_id',$user_id)
				->update(['user_login_today' => time()]);
			}
        $user_sub_count = Db::name('user')
            ->where('user_pid',$user_id)
            // ->whereOr('user_pid_2',$user_id)
            // ->whereOr('user_pid_3',$user_id)
            ->count();
        $data['user_level']=1;
        foreach ($user_level_config as $k=>$v){
        	if($user_sub_count>=$v['people_count']){
                $data['user_level'] = str_replace("v","",$k);
                $data['user_view_count'] = $v['view_count'];
                $data['leave_peoples'] =$v['people_count']-$user_sub_count>0?$v['people_count']-$user_sub_count:0;
                if($data['leave_peoples'] == 0 and $data['user_level']<5){
                    $data['leave_peoples'] = $user_level_config['v'.($data['user_level']+1)]['people_count']-$user_sub_count;
                }
            }

        }
        $data['leave_times'] = getUserVideoTimes($user_id);
        return $this->success($data);
    }

    public function postIndex()
    {
        $this->checkLogin();
        $param = input();
        if (Request()->isPost()) {
            $res = model('User')->fieldData(['user_id' => $GLOBALS['user']['user_id']] ,$param);
            if ($res['code'] == 1) {
                $this->success($res['msg']);
                exit;
            }
            return $this->error($res['msg']);
            exit;
        }

        return $this->success();
    }

    public function postBuy()
    {
        $this->checkLogin();
        $param = input();
        if (Request()->isPost()) {
            $flag = input('param.flag', 'card');
            if ($flag == 'card') {
                $card_no = htmlspecialchars(urldecode(trim($param['card_no'])));
                $card_pwd = htmlspecialchars(urldecode(trim($param['card_pwd'])));

                $res = model('Card')->useData($card_no, $card_pwd, $GLOBALS['user']);
                if ($res['code'] == 1){
                    $data = [
                        'msg' => $res['msg']
                    ];
                    return $this->success($data);
                }else{
                    return $this->error($res['msg']);
                }
            } else {
                return $this->error('暂不支持该方式充值');
                $price = input('param.price');
                if (empty($price)) {
                    return json(['code' => 1001, 'msg' => '参数错误']);
                }

                if ($price < $GLOBALS['config']['pay']['min']) {
                    return json(['code' => 1002, 'msg' => '最小充值金额不能低于' . $GLOBALS['config']['pay']['min'] . '元']);
                }

                $data = [];
                $data['user_id'] = $GLOBALS['user']['user_id'];
                $data['order_code'] = 'PAY' . mac_get_uniqid_code();
                $data['order_price'] = $price;
                $data['order_time'] = time();
                $data['order_points'] = intval($GLOBALS['config']['pay']['scale'] * $price);
                $res = model('Order')->saveData($data);
                $res['data'] = $data;
                return json($res);
            }
        }

        return $this->errorNotFountd();
    }

    public function getGroups()
    {
        $group_list = model('Group')->getCache();

        $data = [
            'list' => $group_list
        ];

        return $this->success($data);


    }

    public function postGroup(){
        $param = input();
        $res = model('User')->upgrade($param);
        if ($res['code'] == 1){
            $data = [
                'msg' => $res['msg']
            ];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
        return json($res);
        return $this->errorNotFountd();
    }

    /**
     * pay_type  1 积分  2支付宝 3微信
     */
    public function postBuypopedom()
    {
        $param = input();
        $data = [];
        $data['ulog_mid'] = intval($param['mid']) <=0 ? 1:$param['mid'];
        $data['ulog_rid'] = intval($param['id']);
        $data['ulog_sid'] = intval($param['sid']);
        $data['ulog_nid'] = intval($param['nid']);
        $config_user = config('maccms.user');
        if (!in_array($param['mid'], ['1','2']) || !in_array($param['type'], ['1','4','5']) || empty($data['ulog_rid']) ) {
            return $this->error('参数错误');
        }
        $data['ulog_type'] = $param['type'];
        $data['user_id'] = $GLOBALS['user']['user_id'];
        $data['ulog_end_time'] = ['>',time()];

        $where = [];
        if($param['type']=='1'){
            $where['art_id'] = $data['ulog_rid'];
            $res = model('Art')->infoData($where);
            if ($res['code'] > 1) {
                return $this->error($data['msg']);
            }
            $col = 'art_points_detail';
            if($GLOBALS['config']['user']['art_points_type']=='1'){
                $col='art_points';
                $data['ulog_sid']=0;
                $data['ulog_nid']=0;
            }
        }
        else{
            $where['vod_id'] = $data['ulog_rid'];
            $res = model('Vod')->infoData($where);
            if ($res['code'] > 1) {
                return $this->error($data['msg']);
            }
            $col = 'vod_points_' . ($param['type'] == '4' ? 'play' : 'down');
            if($GLOBALS['config']['user']['vod_points_type']=='1'){
                //$col='vod_points';
                $data['ulog_sid']=0;
                $data['ulog_nid']=0;
            }
        }
//        $data['ulog_points'] = intval($config_user['trysee_points']);

        $res = model('Ulog')->infoData($data);


        if ($res['code'] == 1) {
            return $this->error('您已经购买过此条数据，无需再次支付，请刷新页面重试');
        }

        if ($param['pay_type'] == 1 && $config_user['trysee_points'] > $GLOBALS['user']['user_points']) {
            return $this->error('对不起,查看此页面数据需要[' . $config_user['trysee_points'] . ']积分，您还剩下[' . $GLOBALS['user']['user_points'] . ']积分，请先充值！');
        } else {
            switch ($param['pay_type']){
                case 1:
                    $where = [];
                    $where['user_id'] = $GLOBALS['user']['user_id'];
                    $res = model('User')->where($where)->setDec('user_points',$data['ulog_points']);
                    if ($res === false) {
                        return $this->error('对不起,更新用户积分信息失败，请刷新重试！');
                    }

                    //积分日志
                    $data2 = [];
                    $data2['user_id'] = $GLOBALS['user']['user_id'];
                    $data2['plog_type'] = 8;
                    $data2['plog_points'] = $data['ulog_points'];
                    model('Plog')->saveData($data2);
                    //分销日志
//            model('User')->reward($data['ulog_points']);
                    $end_time = config('maccms.user.trysee_time');
                    $data['ulog_end_time'] = time() + ($end_time * 60 * 60);
                    $res = model('Ulog')->saveData($data);
                    return $this->success();
                    break;
                case 2:
                    $data2 = [];
                    $data2['user_id'] = $GLOBALS['user']['user_id'];
                    $data2['order_code'] = 'PAY' . mac_get_uniqid_code();
                    $data2['order_price'] = floatval(bcdiv($data['ulog_points'],$config_user['gold_ratio'],2));
                    $data2['order_time'] = time();
                    $data2['order_points'] = 0;
                    $data2['order_type'] = 1;
                    $data2['ulog_data'] = json_encode($data);
                    $data2['order_pay_type'] = '微信';
                    $res = model('Order')->saveData($data2);
                    if (!$res)
                        $this->error('下单失败');
                    $notify = request()->domain().'/api.php/v1.payment/wechatnotify';
                    $result = (new Wxpay())->create($data2['order_price'],$data2['order_code'],'视频点播',$notify);
                    if ($result === false)
                        $this->error('微信支付失败');
                    $this->success(['result'=>$result,'order_no'=>$data2['order_code']],'微信支付参数');
                    break;
                case 3:
                    $data3 = [];
                    $data3['user_id'] = $GLOBALS['user']['user_id'];
                    $data3['order_code'] = 'PAY' . mac_get_uniqid_code();
                    $data3['order_price'] = bcdiv($data['ulog_points'],$config_user['gold_ratio'],2);
                    $data3['order_time'] = time();
                    $data3['order_points'] = 0;
                    $data3['order_type'] = 1;
                    $data2['ulog_data'] = json_encode($data);
                    $data3['order_pay_type'] = '支付宝';
                    $res = model('Order')->saveData($data3);
                    if (!$res)
                        $this->error('下单失败');
                    $GLOBALS['config']['pay']['alipay']['notify_url'] = $this->request->domain().'.api.php/v1.payment/alipaynotify';
                    try {
                        $result= Alipay::create('app',$GLOBALS['config']['pay']['alipay'])->setBizContent($data3['order_price'], '视频点播', $data3['order_code'])->send();
                    }catch (\Exception $e){
                        $this->error($e->getMessage());
                    }
                    $this->success(['result'=>$result,'order_no'=> $data3['order_code']],'支付宝支付参数');
                    break;
            }

        }
    }
//    public function postBuypopedom()
//    {
//        $param = input();
//        $data = [];
//        $data['ulog_mid'] = intval($param['mid']) <=0 ? 1:$param['mid'];
//        $data['ulog_rid'] = intval($param['id']);
//        $data['ulog_sid'] = intval($param['sid']);
//        $data['ulog_nid'] = intval($param['nid']);
//
//        if (!in_array($param['mid'], ['1','2']) || !in_array($param['type'], ['1','4','5']) || empty($data['ulog_rid']) ) {
//            return $this->error('参数错误');
//        }
//        $data['ulog_type'] = $param['type'];
//        $data['user_id'] = $GLOBALS['user']['user_id'];
//
//        $where = [];
//        if($param['type']=='1'){
//            $where['art_id'] = $data['ulog_rid'];
//            $res = model('Art')->infoData($where);
//            if ($res['code'] > 1) {
//                return $this->error($data['msg']);
//            }
//            $col = 'art_points_detail';
//            if($GLOBALS['config']['user']['art_points_type']=='1'){
//                $col='art_points';
//                $data['ulog_sid']=0;
//                $data['ulog_nid']=0;
//            }
//        }
//        else{
//            $where['vod_id'] = $data['ulog_rid'];
//            $res = model('Vod')->infoData($where);
//            if ($res['code'] > 1) {
//                return $this->error($data['msg']);
//            }
//            $col = 'vod_points_' . ($param['type'] == '4' ? 'play' : 'down');
//            if($GLOBALS['config']['user']['vod_points_type']=='1'){
//                //$col='vod_points';
//                $data['ulog_sid']=0;
//                $data['ulog_nid']=0;
//            }
//        }
//        $data['ulog_points'] = intval($res['info'][$col]);
//
//        $res = model('Ulog')->infoData($data);
//        if ($res['code'] == 1) {
//            return $this->error('您已经购买过此条数据，无需再次支付，请刷新页面重试');
//        }
//
//        if ($data['ulog_points'] > $GLOBALS['user']['user_points']) {
//            return $this->error('对不起,查看此页面数据需要[' . $data['ulog_points'] . ']积分，您还剩下[' . $GLOBALS['user']['user_points'] . ']积分，请先充值！');
//        } else {
//            $where = [];
//            $where['user_id'] = $GLOBALS['user']['user_id'];
//            $res = model('User')->where($where)->setDec('user_points',$data['ulog_points']);
//            if ($res === false) {
//                return $this->error('对不起,更新用户积分信息失败，请刷新重试！');
//            }
//
//            //积分日志
//            $data2 = [];
//            $data2['user_id'] = $GLOBALS['user']['user_id'];
//            $data2['plog_type'] = 8;
//            $data2['plog_points'] = $data['ulog_points'];
//            model('Plog')->saveData($data2);
//
//            //分销日志
////            model('User')->reward($data['ulog_points']);
//
//            $res = model('Ulog')->saveData($data);
//            return $this->success();
//        }
//    }


    public function postOrder(){
        $this->checkLogin();
        $param = input();
        $flag = input('param.flag');
        if ($flag == 'card') {

            return $this->error('禁止调用');

            $card_no = htmlspecialchars(urldecode(trim($param['card_no'])));
            $card_pwd = htmlspecialchars(urldecode(trim($param['card_pwd'])));

            $res = model('Card')->useData($card_no, $card_pwd, $GLOBALS['user']);

        } else {
            $price = input('param.price');
            if (empty($price)) {
                return $this->error( '参数错误' . $GLOBALS['config']['pay']['min'] . '元', 1001);
            }

            if ($price < $GLOBALS['config']['pay']['min']) {
                return $this->error( '最小充值金额不能低于' . $GLOBALS['config']['pay']['min'] . '元', 1002);
            }

            $data = [];
            $data['user_id'] = $GLOBALS['user']['user_id'];
            $data['order_code'] = 'PAY' . mac_get_uniqid_code();
            $data['order_price'] = $price;
            $data['order_time'] = time();
            $data['order_points'] = intval($GLOBALS['config']['pay']['scale'] * $price);
            $res = model('Order')->saveData($data);
            $res['data'] = $data;

            return $this->success($res['data']);
        }
        return $this->error('接口错误');
    }

    public function getOrder(){
        $param = input();

        //订单号
        $order_code = htmlspecialchars(urldecode(trim($param['order_code'])));
        // 订单ID
        $order_id = intval((trim($param['order_id'])));


        //核实订单
//        $where['order_id'] = $order_id;
        $where['order_code'] = $order_code;
        $where['user_id'] = $GLOBALS['user']['user_id'];
        $res = model('Order')->infoData($where);
        if ($res['code'] > 1) {
            return $this->error('获取单据失败');
        }
        return $this->success($res['info']);

    }

    public function getFavs()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : intval($param['page']);
        $param['limit'] = intval($param['limit']) < 20 ? 20 : intval($param['limit']);

        $where = [];
        $where['user_id'] = $GLOBALS['user']['user_id'];
        $where['ulog_type'] = 2;
        $order = 'ulog_id desc';
        $res = model('Ulog')->listData($where, $order, $param['page'], $param['limit']);
        if ($res['code'] == 1){
            $data = [
                'total' => $res['total'],
                'page' => $res['page'],
                'limit' => $res['limit'],
                'list' => $res['list'],
            ];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
    }

    public function postUlog(){
        $param = input();
        $data = [];
        $data['ulog_mid'] = intval($param['mid']);
        $data['ulog_rid'] = intval($param['id']);
        $data['ulog_type'] = intval($param['type']);
        $data['ulog_sid'] = intval($param['sid']);
        $data['ulog_nid'] = intval($param['nid']);
        $data['user_id'] = $GLOBALS['user']['user_id'];

        if ($data['ulog_mid'] == 1 && $data['ulog_type'] > 3) {
            $where2 = [];
            $where2['vod_id'] = $data['ulog_rid'];
            $res = model('Vod')->infoData($where2);
            if ($res['code'] > 1) {
                return $this->error($res['msg']);
            }
            $flag = $data['ulog_type'] == 4 ? 'play' : 'down';
            $data['ulog_points'] = $res['info']['vod_points_' . $flag];
        }
        $data['ulog_points'] = intval($data['ulog_points']);
        $res = model('Ulog')->infoData($data);
        if ($res['code'] == 1) {
           return $this->success();
        }
        if ($data['ulog_points'] == 0) {
            $res = model('Ulog')->saveData($data);
            if ($res['code'] == 1){
                return $this->success();
            }else{
                return $this->error($res['msg']);
            }
        } else {
            return $this->error('收费收据需单独记录');
            $res = ['code' => 2001, 'msg' => '收费收据需单独记录'];
        }
        return $this->success($res);
    }

    public function deleteUlog()
    {
        $param = input();
        $ids = $param['ids'];
        $type = $param['type'];
        $all = $param['all'];

        if (!in_array($type, array('1', '2', '3', '4', '5'))) {
            return json(['code' => 1001, 'msg' => '参数错误']);
        }

        if (empty($ids) && empty($all)) {
            return json(['code' => 1001, 'msg' => '参数错误']);
        }

        $arr = [];
        $ids = explode(',', $ids);
        foreach ($ids as $k => $v) {
            $v = intval(abs($v));
            $arr[$v] = $v;
        }

        $where = [];
        $where['user_id'] = $GLOBALS['user']['user_id'];
        $where['ulog_type'] = $type;
        if ($all != '1') {
            $where['ulog_rid'] = array('in', implode(',', $arr));
        }
        $return = model('Ulog')->delData($where);
        if ($return['code'] == 1){
            return $this->success();
        }else{
            return $this->error($return['msg']);
        }
        return $this->success();
    }


    public function getPay()
    {
        $this->checkLogin();
        $param = input();

        //订单号
        $order_code = htmlspecialchars(urldecode(trim($param['order_code'])));
        // 订单ID
        $order_id = intval((trim($param['order_id'])));
        // 支付方式
        $payment = strtolower(htmlspecialchars(urldecode(trim($param['payment']))));

        if (empty($order_code) && empty($order_id) && empty($payment)) {
            return $this->error('参数错误');
        }

        if ($GLOBALS['config']['pay'][$payment]['appid'] == '') {
            return $this->error('该支付选项未开启');
        }

        //核实订单
//        $where['order_id'] = $order_id;

        $where['order_code'] = $order_code;
        $where['user_id'] = $GLOBALS['user']['user_id'];
        $res = model('Order')->infoData($where);
        if ($res['code'] > 1) {
            return $this->error('获取单据失败');
        }
        if ($res['info']['order_status'] == 1) {
            return $this->error('该单据已支付完成');
        }

//        $this->assign('order', $res['info']);
        //跳转到相应页面
//        $this->assign('param',$param);

        $cp = 'app\\common\\extend\\pay\\' . ucfirst($payment);
        if (class_exists($cp)) {
            $c = new $cp;
            $payment_res = $c->submit($GLOBALS['user'], $res['info'], $param);
        }else{
            return $this->error('支付方式有误');
        }

        return $this->success();
    }


    public function postGoldWithdrawApply(){
        $this->checkLogin();
        $num = input('num');
        if (!$num){
            return $this->error('缺少参数提现数量');
        }

        $remark = input('remark');
        $type = input('type');
        if (!$type){
            return $this->error('请选择提现方式：1. 支付宝 2. 微信');
        }
        $realname = input('realname');
        $account = input('account');
        if (!$account){
            return $this->error('请输入账户');
        }
        if (!$realname){
            return $this->error('请输入真实姓名');
        }

        $param = [
            'user_id' => $GLOBALS['user']['user_id'],
            'num' => $num,
            'remark' => $remark,
            'type' => $type,
            'account' => $account,
            'realname' => $realname
        ];
        $res = model('GoldWithdrawApply')->saveData($param);
        if ($res['code'] > 1){
            return $this->error($res['msg']);
        }

        $data=[
            'info'=>'提交成功'
        ];
        return $this->success($data);
    }

    public function getGoldWithdrawApply(){
        $this->checkLogin();

        $param = [];

        $page = input('page');
        $limit = input('limit');
        $res = model('GoldWithdrawApply')->listData(['user_id' => $GLOBALS['user']['user_id']], 'created_time desc', $page, $limit);
        $code = $res['code'];
        if($code == 1){
            $data = [
                'page' => $res['page'],
                'total' => $res['total'],
                'limit' => $res['limit'],
                'list' => $res['list'],
            ];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
    }

    /**
     *
     * 变更为代理
     * 先判断是否为代理，是则返回提示信息，不是则继续；
     * 判断用户积分是否达到变更代理的积分值，不够则提示，够的话则继续；
     * 扣除积分，变更用户身份标识
     *
     * */

    public function postChangeAgents()
    {
    	$this->checkLogin();
        $user = $GLOBALS['user'];
        $user_id = $user['user_id'];
        $where = ['user_id' => $user_id];
		$score = config('score')['agents_score'];
        $info = model('User')->changeAgents($where, $score);
        return $this->success($info);
    }

	/**
     * 获取代理所所需积分
     * */
    public function getAgentsScore(){
        $this->checkLogin();
        $score = config('score')['agents_score'];
        $data=['score'=>$score];
        return $this->success($data);
    }
	 /**
     *
     * 视频试看
     * 后台设置试看分钟数，0表示直接观看，大于0表示试看几分钟
     * 后台设置点播需要的积分，根据后台设置的收费模式（每集、每视频）进行处理
     * */
    public function getCheckVodTrySee()
    {

        Log::mylog('标题：' , '内容' , 'test');
        $user = $GLOBALS['user'];

        $param = input();
        if(empty($param['id']) or empty($param['mid']) or empty($param['nid'])){
            return $this->error('请按要求传参');
        }
        $vod_id = intval($param['id']);
        $data = [];
        $data['ulog_mid'] = intval($param['mid']) <=0 ? 1:$param['mid'];
        $data['ulog_rid'] = intval($param['id']);
        $data['ulog_type'] = 4;
        if(!empty($user)){
            $data['user_id'] = $user['user_id'];
        }

        $trysee = intval(config('maccms')['user']['trysee']);
        if($trysee == 0){
            $info = ['code'=>1,'msg'=>'直接观看','status'=>0];
        }
        if($trysee>0){
            if(!empty($user)){
                $user_group_name = $user['group']['group_name'];
                if(stripos($user_group_name,'vip') !== false){
                    $info = ['code'=>1,'msg'=>'VIP用户直接观看','trysee'=>$trysee,'status'=>0];
                }else{
                    $info = ['code'=>1,'msg'=>'开启试看模式','trysee'=>$trysee,'status'=>1];
                }
            }else{
                $info = ['code'=>1,'msg'=>'开启试看模式','trysee'=>$trysee,'status'=>1];
            }
        }
        /*
         * 点播所需积分
         * */
        $vod_points_play = model('Vod')->where('vod_id',$vod_id)->value('vod_points_play');
        if(intval($vod_points_play)>0 and !empty($user)){
            $data['ulog_points']= $vod_points_play;
            if(intval(config('maccms')['user']['vod_points_type'])==0){
                $data['ulog_nid'] = intval($param['nid']);
            }
            $ulog = model('Ulog')->where($data)->select();
            if(count($ulog)>0){
                $info = ['code'=>1,'msg'=>'您已付费，请直接观看','status'=>0];
            }else{
                $info = ['code'=>1,'msg'=>'您需要花费'.$vod_points_play.'积分才能观看','status'=>2,'trysee'=>$trysee];
            }
        }

        $info['user_video'] = getUserVideoTimes($user['user_id']);

        return $this->success($info);
    }

	/*
     * 充值说明，最小充值金额、1元可兑换积分个数
     *
     * */
    public function getPayTip()
    {
        $pay = config('maccms')['pay'];
        $min = $pay['min'];
        $scale = $pay['scale'];
        $url = $pay['card']['url'];
        $data = ['url'=>$url];
        return $this->success($data,'最小充值金额为'.$min.'元，1元可兑换'.$scale.'个积分');
    }

    /*
     * 卡密 销售网址
     * */

    public function getCardUrl()
    {
        $pay = config('maccms')['pay'];
        $url = $pay['card']['url'];
        $data = ['url'=>$url];
        return $this->success($data);
    }

    /*
     * APP配置
     * */
    public function getAppConfig()
    {
        $config = config('maccms')['app_setting'];
        $param = input();
        if(empty($param['type'])){
            return $this->error('请按要求传参');
        }
        $data=[];
        switch($param['type']){
            case 1:
                $data['img'] = $config['start_img'];
                $data['url'] = null;
                break;
            case 2:
                $data['img'] = $config['before_play_img'];
                $data['url'] = $config['before_play_url'];;
                break;
            case 3:
                $data['img'] = $config['water_img'];
                $data['url'] = $config['water_url'];
                break;
            case 4:
                $data['has_logout'] = $config['has_logout'];
                break;
        }
        return $this->success($data);

    }

    /**
     * 提现说明
     * */
    public function getGoldTip()
    {
        $this->checkLogin();
        $gold_min = intval(config('maccms')['user']['gold_min']);
        $gold_ratio = intval(config('maccms')['user']['gold_ratio']);
        $user = $GLOBALS['user'];
        $user_gold = intval($user['user_gold']);
        $can_money = floor($user_gold/$gold_ratio);
        $data = [];
        $data['msg'] = '最低提现'.$gold_min.'元';
        if($can_money<$gold_min){
            $data['info'] = '当前可提现金额0元，提现比例'.$gold_ratio.'金币=1元';
        }else{
            $data['info'] = '当前可提现金额'.$can_money.'元，提现比例'.$gold_ratio.'金币=1元';
        }
        return $this->success($data);
    }

	/*
     * 分享奖励
     * */
    public function postShareScore()
    {
        $this->checkLogin();
        $score = config('task')['share']['reward']['points'];
        $reword_num = config('task')['share']['reward_num'];
        $user = $GLOBALS['user'];

        $today_start=strtotime(date("Y-m-d 00:00:00"));
        $tomorrow_start = strtotime(date("Y-m-d 00:00:00",strtotime("+1 day")));
        $where = [
            'user_id'=>['=',$user['user_id']],
            'plog_type'=>'15',
            'plog_time'=>['>',$today_start],
            'plog_time'=>['<',$tomorrow_start],
        ];

        $count = model('Plog')->where($where)->count('plog_id');
        if($count>=$reword_num){
            return $this->error('今日分享奖励已达上限');
        }
        model('User')->where('user_id', $user['user_id'])->setInc('user_points', $score);
        $data=[
            'user_id'=>$user['user_id'],
            'plog_type'=>'15',
            'plog_points' => $score,
            'plog_time'=>time(),
            'plog_remarks'=>'用户'.$user['user_name'].'分享奖励'.$score.'分',
        ];

        $res = model('Plog')->saveData($data);
        $info = [
            'info' => '分享成功',
            'score'=>$score
        ];
        if($res['code'] == 1){
            return $this->success($info);
        }else{

            return $this->error('分享奖励保存失败');
        }
    }

	/**
     * 任务列表
     * */
    public function getTask()
    {
       $this->checkLogin();
        $task = config('task');
        $user_id = $GLOBALS['user']['user_id'];
        if(!empty($task['sign'])){
            $task['sign']['finish'] = 0;
            $count = Db::name('sign')
                ->where('date',date('Y-m-d',time()))
                ->where('user_id',$user_id)
                ->count('sign_id');
            if($count>0) {
                $task['sign']['finish'] = 1;
            }
        }

        if(!empty($task['comment'])){
            $task['comment']['finish'] = 0;
            $reward_num = 1;
            if(!empty($task['sign']['reward_num'])){
                $reward_num = intval($task['sign']['reward_num']);
            }

            $count = Db::name('comment')
                ->where('comment_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('comment_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('user_id',$user_id)
                ->count('comment_id');

            if($count> 0){
                $task['comment']['finish'] = 1;
            }
        }

        if(!empty($task['dianzan'])){
            $task['dianzan']['finish'] = 0;

        }

        if(!empty($task['danmu'])){
            $task['danmu']['finish'] = 0;

            $count = Db::name('danmu')
                ->where('danmu_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('danmu_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('user_id',$user_id)
                ->count('danmu_id');

            if($count> 0){
                $task['danmu']['finish'] = 1;
            }
        }


        if(!empty($task['mark'])){
            $task['mark']['finish'] = 0;

            $count = Db::name('plog')
                ->where('plog_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('plog_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('plog_type',12)
                ->where('user_id',$user_id)
                ->count('plog_id');

            if($count> 0){
                $task['mark']['finish'] = 1;
            }
        }

        if(!empty($task['share'])){
            $task['share']['finish'] = 0;
            $count = Db::name('plog')
                ->where('plog_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('plog_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('plog_type',15)
                ->where('user_id',$user_id)
                ->count('plog_id');

            if($count> 0){
                $task['share']['finish'] = 1;
            }
        }
        if(!empty($task['view30m'])){
            $task['view30m']['finish'] = 0;
            $count = Db::name('view30m')
                ->where('create_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('create_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('user_id',$user_id)
                ->sum('view_seconds');

            if($count>= 1800){
                $task['view30m']['finish'] = 1;
            }
        }




        return $this->success($task);
    }

    /**
     * 分享地址和LOGO
     * */
    public function getShareInfo()
    {
        $this->checkLogin();
        $macConfig = config('maccms');
        $data =[
            'share_url' => $macConfig['app']['share_url']. ($GLOBALS['user']['user_id'] ? '?invite_code='. \app\common\model\User::getInviteCode($GLOBALS['user']['user_id']) : ''),
            'share_logo' => $macConfig['app']['share_logo'] ? mac_path_to_imageurl($macConfig['app']['share_logo']) : null,
        ];
        return $this->success($data);
    }


    /**
     * 添加视频播放记录
     * */
    public function postAddViewLog()
    {
        $this->checkLogin();
        $data = input();
        $vod_id = $data['vod_id'];
        $nid = $data['nid'];
        $percent = $data['percent'];
        $source = $data['source'];
        $user = $GLOBALS['user'];
        $user_id = $user['user_id'];

        if (is_null($vod_id) or is_null($nid) or is_null($percent)) {
            return $this->error('参数有误');
        }

        // if($user['group_id']!=3){
        //     $leave_times = getUserVideoTimes($user['user_id']);
        //     if($leave_times<=0){
        //         return $this->error('观影次数用完了',-10000);
        //     }
        // }

        // $vlog = model('Vlog')
        //     ->where('vod_id', $vod_id)
        //     ->where('nid',$nid)
        //     ->where('source',$source)
        //     ->where('user_id', $user_id)
        //     ->find();

        $data['last_view_time'] = time();
        $data['user_id'] = $user_id;
        model('Vlog')->insert($data);
        $user_video = getUserVideoTimes($user_id);
        $data = [
            'user_video'=>$user_video
        ];
        // if (is_null($vlog)) {
        // } else {
        //     Vlog::where('vod_id', $vod_id)
        //         ->where('user_id', $user_id)
        //         ->where('nid',$nid)
        //         ->where('source',$source)
        //         ->update($data);
        // }

        return $this->success($data);

    }
    /**
     * 获取视频播放记录
     * */
    public function getViewLog()
    {
        $this->checkLogin();
        $user = $GLOBALS['user'];
        $user_id = $user['user_id'];
        $params = input();

        $params['user_id'] = $user_id;

        $page = input('page');
        $limit = input('limit');
        $where = [
        	'user_id'=>$user_id
        	];
        $res = model('Vlog')->listData($where,'last_view_time desc',$page,$limit);

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


    /**
     * 删除播放记录
     * */
    public function postDelVlog()
    {
        $this->checkLogin();
        $vlog_id = input('id');
        if(empty($vlog_id)){
            return $this->error('参数有误');
        }

        Vlog::where('vod_id',$vlog_id)->delete();
        return $this->success();

    }

    /**
     * 获取是否开启手机注册
     * */
    public function getPhoneReg()
    {
        $macConfig = config('maccms');
        $data = [
          'phone'=>$macConfig['user']['reg_phone_sms']
        ];

        return $this->success($data);
    }


    /*上传观影时间*/
    public function postViewSeconds()
    {
        $this->checkLogin();
        $user_id = $GLOBALS['user']['user_id'];
        $view_seconds = input('view_seconds');
        if(empty($view_seconds)){
            return $this->error('请按要求传参');
        }


        $data = [
            'user_id'=>$user_id,
            'create_time'=>time(),
            'view_seconds'=>$view_seconds,
        ];

        Db::name('view30m')->insert($data);

        $task = config('task');
        $add_score=0;
        if($task['status'] == '1'){
            $num = Db::name('view30m')
                ->where('create_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                ->where('create_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                ->where('user_id',$user_id)
                ->sum('view_seconds');
            if($num>=1800){
                $points = $task['reward']['points'];
                $count = Db::name('plog')
                    ->where('user_id',$user_id)
                    ->where('plog_time','>',strtotime(date('Y-m-d 00:00:00',time())))
                    ->where('plog_time','<',strtotime(date('Y-m-d 23:59:59',time())))
                    ->where('plog_type',16)
                    ->count('plog_id');
                if($count == 0){
                	$add_score=$points;
                    Db::name('user')
                        ->where('user_id',$user_id)
                        ->setInc('user_points',$points);
                    $log = [
                        'user_id'=>$user_id,
                        'plog_type'=>16,
                        'plog_points'=>$points,
                        'plog_time'=>time(),
                        'plog_remark'=>'观影30分钟奖励'
                    ];
                    Db::name('plog')
                        ->insert($log);
                }
            }
        }

        return $this->success(['score'=>$add_score]);
    }

     /*获取推广人员*/
    public function getSubUsers()
    {
        $this->checkLogin();
        $user_id = $GLOBALS['user']['user_id'];
        $where = 'user_pid = '.$user_id.' or user_pid_2 = '.$user_id.' or user_pid_3 = '.$user_id;
        $page = input('page');
        $limit = input('limit');
        if(empty($page)){
            $page = 1;
        }
        if(empty($limit)){
            $limit = 20;
        }
    	$field = 'user_id,user_name,user_nick_name,user_reg_time';
        $res = model('User')->listData($where,'user_id desc',$page,$limit,$field);
        $data = [
            'limit' => $res['limit'],
            'page' => $res['page'],
            'total' => $res['total'],
            'list' => $res['list'],
        ];
        return $this->success($data);
    }

     /*获取用户等级配置*/
    public function getUserlevelconfig()
    {
        $config = config('maccms');
        $user = $config['user'];
        $user_level_config = $user['user_level'];
        return $this->success($user_level_config);
    }

}
