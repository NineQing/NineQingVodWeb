<?php

namespace app\api\controller\v1;

use app\common\controller\All;
use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;

class Base extends All {

    public function __construct()
    {
        header('Access-Control-Allow-Credentials:true');
        $referer=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "");
        if($referer){
            $parseUrl=parse_url($referer);
            if (isset($parseUrl["host"]) && $parseUrl['host'] == "www.xiaoyaoji.cn"){
                header('Access-Control-Allow-Origin:'.$parseUrl['scheme'].'://'.$parseUrl['host'].(isset($parseUrl['port']) ? ":".$parseUrl['port'] : ""));
            }else{
                header('Access-Control-Allow-Origin:*');
            }
        }else{
            header('Access-Control-Allow-Origin:*');
        }
//        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:OPTIONS,GET,POST,PUT,DELETE, HEAD, PATCH');
        header("Access-Control-Allow-Headers:X-HXR-Client,X-HXR-Vern,X-HXR-Device,X-HXR-TOKEN,X-HXR-WEB-TOKEN,X-HXR-MARSBOX-TOKEN,Power-By,Content-Type,X-Requested-With");
        parent::__construct();


        $this->setUp();
        $this->setAuto();

        $request= Request::instance();
        $action = $request->action();


        try{
            if ($this->request->isGet()){
                return $this->{'get'.ucfirst($action)}();
            }
            if ($this->request->isPost()){
                return $this->{'post'.ucfirst($action)}();
            }

            if ($this->request->isDelete()){
                return $this->{'delete'.ucfirst($action)}();
            }
        }catch (\Exception $exception){
            throw $exception;
            return $this->error($exception->getMessage());
        }

        exit('Not found');
        return $this->errorNotFountd();
    }

    protected function setUp(){
        return $this;
    }

    protected function setAuto(){
        $this->check_site_status();
        $this->label_maccms();
        $this->label_user();
        return $this;
    }

    protected function label_user() {
        $user_id = intval(cookie('user_id'));
        $user_name = cookie('user_name');
        $user_check = cookie('user_check');

        $user = ['user_id'=>0,'user_name'=>'游客','user_portrait'=>'static/images/touxiang.png','group_id'=>1,'points'=>0];
        if(!empty($user_id) || !empty($user_name) || !empty($user_check)){
            $res = model('User')->checkLogin();

            if($res['code'] == 1){
                $user = $res['info'];
            }
        }
        else{
            $group_list = model('Group')->getCache();
            $user['group'] = $group_list[1];
        }

        $GLOBALS['user'] = $user;
    }

    public function success($data = null, $msg = 'success', array $header = [])
    {
        $result = [
            'code' => 200,
            'msg'  => $msg,
            'data' => $data,
        ];
        $response = json($result);
//        Response::create($response, 'json')->header($header);
        echo json_encode($result);
        exit();
//        return Response::create($response)->send();
    }

    /**
     * 错误处理
     * @param string $msg
     * @param null $url
     * @param string $data
     * @param int $wait
     * @param array $header
     */
    public function error($msg = '', $code = 400,$url = null, $data = '', $wait = null, array $header = [])
    {

        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $response = json($result,400);

        throw new HttpResponseException($response);
    }

    public function sesstionExp($msg = '您未登陆', $code = 403){
        return $this->error($msg, $code);
    }

    public function errorNotFountd(){
        return $this->error('Not Found');
    }


    public function checkLogin(){
        if(empty($GLOBALS['user']['user_id'])){

            return $this->sesstionExp();
        }
        return true;
    }


    protected function check_user_popedom($type_id,$popedom,$param=[],$flag='',$info=[],$trysee=0)
    {
        $user = $GLOBALS['user'];
        $group = $GLOBALS['user']['group'];

        $res = false;
        if(strpos(','.$group['group_type'],','.$type_id.',')!==false && !empty($group['group_popedom'][$type_id][$popedom])!==false){
            $res = true;
        }

        if(in_array($flag,['art','play','down'])){
            if($flag=='art') {
                $points = $info['art_points_detail'];
                if($GLOBALS['config']['user']['art_points_type']=='1'){
                    $points = $info['art_points'];
                }
            }
            else{
                $points = $info['vod_points_'.$flag];
                if($GLOBALS['config']['user']['vod_points_type']=='1'){
                    $points = $info['vod_points'];
                }
            }
        }


        if($GLOBALS['config']['user']['status']==0){

        }
        elseif($popedom==2 && $flag=='art'){
            if($res===false && (empty($group['group_popedom'][$type_id][2]) || $trysee==0)){
                return ['code'=>3001,'msg'=>'您没有权限访问此数据，请升级会员','trysee'=>0];
            }
            elseif($group['group_id']<3 && $points>0  ){
                $where=[];
                $where['ulog_mid'] = 2;
                $where['ulog_type'] = 1;
                $where['ulog_rid'] = $param['id'];
                $where['ulog_sid'] = $param['page'];
                $where['ulog_nid'] = 0;
                $where['user_id'] = $user['user_id'];
                $where['ulog_points'] = $points;
                if($GLOBALS['config']['user']['art_points_type']=='1'){
                    $where['ulog_sid'] = 0;
                }
                $res = model('Ulog')->infoData($where);

                if($res['code'] > 1) {
                    return ['code'=>3003,'msg'=>'观看此数据，需要支付【'.$points.'】积分，确认支付吗？','points'=>$points,'confirm'=>1,'trysee'=>0];
                }
            }
        }
        elseif($popedom==3){
            if($res===false && (empty($group['group_popedom'][$type_id][5]) || $trysee==0)){
                return ['code'=>3001,'msg'=>'您没有权限访问此数据，请升级会员','trysee'=>0];
            }
            elseif($group['group_id']<3 && empty($group['group_popedom'][$type_id][3]) && !empty($group['group_popedom'][$type_id][5]) && $trysee>0){
                return ['code'=>3002,'msg'=>'进入试看模式','trysee'=>$trysee];
            }
            elseif($group['group_id']<3 && $points>0  ){
                $where=[];
                $where['ulog_mid'] = 1;
                $where['ulog_type'] = $flag=='play' ? 4 : 5;
                $where['ulog_rid'] = $param['id'];
                $where['ulog_sid'] = $param['sid'];
                $where['ulog_nid'] = $param['nid'];
                $where['user_id'] = $user['user_id'];
                $where['ulog_points'] = $points;
                if($GLOBALS['config']['user']['vod_points_type']=='1'){
                    $where['ulog_sid'] = 0;
                    $where['ulog_nid'] = 0;
                }
                $res = model('Ulog')->infoData($where);

                if($res['code'] > 1) {
                    return ['code'=>3003,'msg'=>'观看此数据，需要支付【'.$points.'】积分，确认支付吗？','points'=>$points,'confirm'=>1,'trysee'=>0];
                }
            }
        }
        else{
            if($res===false){
                return ['code'=>1001,'msg'=>'您没有权限访问此页面，请升级会员组'];
            }
            if($popedom == 4){
                if( $group['group_id'] ==1 && $points>0){
                    return ['code'=>4001,'msg'=>'此页面为收费数据，请先登录后访问！','trysee'=>0];
                }
                elseif($group['group_id'] ==2 && $points>0){
                    $where=[];
                    $where['ulog_mid'] = 1;
                    $where['ulog_type'] = $flag=='play' ? 4 : 5;
                    $where['ulog_rid'] = $param['id'];
                    $where['ulog_sid'] = $param['sid'];
                    $where['ulog_nid'] = $param['nid'];
                    $where['user_id'] = $user['user_id'];
                    $where['ulog_points'] = $points;
                    if($GLOBALS['config']['user']['vod_points_type']=='1'){
                        $where['ulog_sid'] = 0;
                        $where['ulog_nid'] = 0;
                    }
                    $res = model('Ulog')->infoData($where);

                    if($res['code'] > 1) {
                        return ['code'=>4003,'msg'=>'下载此数据，需要支付【'.$points.'】积分，确认支付吗？','points'=>$points,'confirm'=>1,'trysee'=>0];
                    }
                }
            }
            elseif($popedom==5){
                if(empty($group['group_popedom'][$type_id][3]) && !empty($group['group_popedom'][$type_id][5])){
                    $where=[];
                    $where['ulog_mid'] = 1;
                    $where['ulog_type'] = $flag=='play' ? 4 : 5;
                    $where['ulog_rid'] = $param['id'];
                    $where['ulog_sid'] = $param['sid'];
                    $where['ulog_nid'] = $param['nid'];
                    $where['user_id'] = $user['user_id'];
                    $where['ulog_points'] = $points;
                    if($GLOBALS['config']['user']['vod_points_type']=='1'){
                        $where['ulog_sid'] = 0;
                        $where['ulog_nid'] = 0;
                    }
                    $res = model('Ulog')->infoData($where);

                    if($res['code'] == 1) {

                    }
                    elseif( $group['group_id'] <=2 && $points <= intval($user['user_points']) ){
                        return ['code'=>5001,'msg'=>'试看结束,是否支付[' . $points . ']积分观看完整数据？您还剩下[' . $user['user_points'] . ']积分，请先充值！','trysee'=>$trysee];
                    }
                    elseif( $group['group_id'] <3 && $points > intval($user['user_points']) ){
                        return ['code'=>5002,'msg'=>'对不起,观看此页面数据需要[' . $points . ']积分，您还剩下[' . $user['user_points'] . ']积分，请先充值！','trysee'=>$trysee];
                    }
                }
            }
        }

        return ['code'=>1,'msg'=>'权限验证通过'];
    }


    public function _empty()
    {
        header("HTTP/1.0 404 Not Found");
        echo  '<script>setTimeout(function (){location.href="'.MAC_PATH.'";},'.(2000).');</script>';
        $msg = '页面不存在';
        abort(404,$msg);
        exit;
    }

    protected function check_search($param)
    {
        if($GLOBALS['config']['app']['search'] !='1'){
            echo $this->error('搜索功能关闭中');
            exit;
        }

        if ( $param['page']==1 && mac_get_time_span("last_searchtime") < $GLOBALS['config']['app']['search_timespan']){
            echo $this->error("请不要频繁操作，搜索时间间隔为".$GLOBALS['config']['app']['search_timespan']."秒");
            exit;
        }

    }

    protected function check_site_status()
    {
        //站点关闭中
        if ($GLOBALS['config']['site']['site_status'] == 0) {
            $this->assign('close_tip',$GLOBALS['config']['site']['site_close_tip']);
            echo $this->fetch('public/close');
            die;
        }
    }

    protected function label_vod_play($flag='play',$info=[],$view=0,$pe=0)
    {
        $param = mac_param_url();
        $this->assign('param',$param);

        if(empty($info)) {
            $res = mac_label_vod_detail($param);
            if ($res['code'] > 1) {
                return $this->error($res['msg']);
            }
            $info = $res['info'];
        }
        if(empty($info['vod_tpl'])){
            $info['vod_tpl'] = $info['type']['type_tpl_detail'];
        }
        if(empty($info['vod_tpl_play'])){
            $info['vod_tpl_play'] = $info['type']['type_tpl_play'];
        }
        if(empty($info['vod_tpl_down'])){
            $info['vod_tpl_down'] = $info['type']['type_tpl_down'];
        }


        $trysee = 0;
        $urlfun='mac_url_vod_'.$flag;
        $listfun = 'vod_'.$flag.'_list';
        if($view <2) {
            if ($flag == 'play') {
                $trysee = $GLOBALS['config']['user']['trysee'];
                if($info['vod_trysee'] >0){
                    $trysee = $info['vod_trysee'];
                }
                $popedom = $this->check_user_popedom($info['type_id'], ($pe==0 ? 3 : 5),$param,$flag,$info,$trysee);
            }
            else {
                $popedom =  $this->check_user_popedom($info['type_id'], 4,$param,$flag,$info);
            }
            $this->assign('popedom',$popedom);





            if($pe==0 && $popedom['code']>1 && empty($popedom["trysee"])){
                return $popedom;
                $info['player_info']['flag'] = $flag;
                $this->assign('obj',$info);

                if($popedom['confirm']==1){
                    $this->assign('flag',$flag);
                    echo $this->fetch('vod/confirm');
                    exit;
                }
                echo $this->error($popedom['msg'], mac_url('user/index') );
                exit;
            }
        }


        $player_info=[];
        $player_info['flag'] = $flag;
        $player_info['encrypt'] = intval($GLOBALS['config']['app']['encrypt']);
        $player_info['trysee'] = intval($trysee);
        $player_info['points'] = intval($info['vod_points_'.$flag]);
        $player_info['link'] = $urlfun($info,['sid'=>'{sid}','nid'=>'{nid}']);
        $player_info['link_next'] = '';
        $player_info['link_pre'] = '';
        if($param['nid']>1){
            $player_info['link_pre'] = $urlfun($info,['sid'=>$param['sid'],'nid'=>$param['nid']-1]);
        }
        if($param['nid'] < $info['vod_'.$flag.'_list'][$param['sid']]['url_count']){
            $player_info['link_next'] = $urlfun($info,['sid'=>$param['sid'],'nid'=>$param['nid']+1]);
        }
        $player_info['url'] = (string)$info[$listfun][$param['sid']]['urls'][$param['nid']]['url'];
        $player_info['url_next'] = (string)$info[$listfun][$param['sid']]['urls'][$param['nid']+1]['url'];

        $player_info['from'] = (string)$info[$listfun][$param['sid']]['from'];
        if((string)$info[$listfun][$param['sid']]['urls'][$param['nid']]['from'] != $player_info['from']){
            $player_info['from'] = (string)$info[$listfun][$param['sid']]['urls'][$param['nid']]['from'];
        }
        $player_info['server'] = (string)$info[$listfun][$param['sid']]['server'];
        $player_info['note'] = (string)$info[$listfun][$param['sid']]['note'];

        if($GLOBALS['config']['app']['encrypt']=='1'){
            $player_info['url'] = mac_escape($player_info['url']);
            $player_info['url_next'] = mac_escape($player_info['url_next']);
        }
        elseif($GLOBALS['config']['app']['encrypt']=='2'){
            $player_info['url'] = base64_encode(mac_escape($player_info['url']));
            $player_info['url_next'] = base64_encode(mac_escape($player_info['url_next']));
        }

        $info['player_info'] = $player_info;
        $this->assign('obj',$info);

        $pwd_key = '1-'.($flag=='play' ?'4':'5').'-'.$info['vod_id'];

        if( $pe==0 && $flag=='play' && ($popedom['trysee']>0 ) || ($info['vod_pwd_'.$flag]!='' && session($pwd_key)!='1') || ($info['vod_copyright']==1 && !empty($info['vod_jumpurl']) && $GLOBALS['config']['app']['copyright_status']==4) ) {
            $dy_play = mac_url('index/vod/'.$flag.'er',['id'=>$info['vod_id'],'sid'=>$param['sid'],'nid'=>$param['nid']]);
            $this->assign('player_data','');
            $this->assign('player_js','<div class="MacPlayer" style="z-index:99999;width:100%;height:100%;margin:0px;padding:0px;"><iframe id="player_if" name="player_if" src="'.$dy_play.'" style="z-index:9;width:100%;height:100%;" border="0" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" scrolling="no" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" ></iframe></div>');
        }
        else {
            $this->assign('player_data', '<script type="text/javascript">var player_data=' . json_encode($player_info) . '</script>');
            $this->assign('player_js', '<script type="text/javascript" src="' . MAC_PATH . 'static/js/playerconfig.js"></script><script type="text/javascript" src="' . MAC_PATH . 'static/js/player.js"></script>');
        }
        $this->label_comment();
        return $info;
    }

}