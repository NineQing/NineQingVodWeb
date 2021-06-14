<?php

namespace app\api\controller\v1;

use app\common\model\AppVersion;
use think\Request;

/**
 * APP业务模块
 * Class Main
 * @package app\api\controller\v1
 */
class Main extends Base {


    public function getTaskarticle(){

        $config = config('task.article');
        return $this->success($config);


    }


    public function getStartup(){

        $adsWhere = [];
        $ads = model('Adtype')->listData($adsWhere,'',1,999);
        if (isset($ads['list'])){
            $temp_key = array_column($ads['list'],'tag');  //键值
            $ads = array_combine($temp_key,$ads['list']) ;
            //$sjsz = mt_rand(1,100);
            //if($sjsz<=70){$ads['startup_adv']['description']='ik2021';}
            $ads['startup_config']['status']=1;
        }else{
            $ads = [];
        }
        $taskConfig = config('task');

        $sign = $taskConfig['sign'];
        $comment = $taskConfig['comment'];
        $mark = $taskConfig['mark'];
        $danmu = $taskConfig['danmu'];




        // 播放器配置
        $player = null;
        $macConfig = config('maccms');
        $player['app_logo'] = $macConfig['play']['app_logo'];

        $appConfig = config('app');
         
        $appConfig['popupwindo'][0]['type'] = 'un_register';//un_register 未注册
        $appConfig['popupwindo'][1]['type'] = 'registerd'; //registerd 已注册
        $appConfig['popupwindo'][2]['type'] = 'notice'; // 公告
        $appConfig['popupwindo'][3]['type'] = 'roll_notice'; // 公告
        $appConfig['popupwindo'][4]['type'] = 'home_notice'; // 首页公告
        $appConfig['popupwindo'][5]['type'] = 'game_notice'; // 游戏公告
        $temp_key = array_column($appConfig['popupwindo'],'type');  //键值
        
       
        
        $appConfig = array_combine($temp_key,$appConfig['popupwindo']) ;

		
        //支付配置
        $payments = []; // 支付方式开关

        $epayConfigOrg = $GLOBALS['config']['pay']['epay'];
        $epayConfig['name'] = $epayConfigOrg['name'];
        $epayConfig['payment'] = 'epay';
        if (empty($epayConfigOrg['type'])){
            $epayConfig['status'] = 0;
        }else{
            $epayConfig['status'] = 1;
        }

        $qqEpayConfigOrg = $GLOBALS['config']['pay']['qqepay'];
        $qqEpayConfig['payment'] = 'qqepay';
        $qqEpayConfig['name'] = $qqEpayConfigOrg['name'];
        if (empty($qqEpayConfigOrg['type'])){
            $qqEpayConfig['status'] = 0;
        }else{
            $qqEpayConfig['status'] = 1;
        }

        $payments[] = $epayConfig;
        $payments[] = $qqEpayConfig;


        // 免邀请码注册绑定
        // 获取最新的邀请记录，72小时内的
        $remoteIp = Request::instance()->ip();
        $newstInvite = model('AppInstallRecord')->where('client_ip', $remoteIp)->where('create_time', '>',time() - 3600 * 72)->order('create_time', 'desc')->where('is_pull', 0)->find();
        if ($newstInvite){
            $inviteByUserId = $newstInvite['invite_user_id'];
            cookie('invite_by_user_id', $inviteByUserId);
        }

        $data = [
            'sign' => $sign,
            'vod_mark' => $mark,
            'comment' => $comment,
            'danmu' => $danmu,
            'document' => $appConfig,
            'ads' =>$ads,
            'player' => $player,
            'payments' => $payments,
            'share_url' => $macConfig['app']['share_url']. ($GLOBALS['user']['user_id'] ? '?invite_code='. \app\common\model\User::getInviteCode($GLOBALS['user']['user_id']) : ''),
            'share_logo' => $macConfig['app']['share_logo'] ? mac_path_to_imageurl($macConfig['app']['share_logo']) : null,
            'search_hot' => explode(',',$macConfig['app']['search_hot'])
        ];

        return $this->success($data);
    }


    /**
     * 首页分类列表
     */
    public function getCategory(){
        $cateWhere = [];
        $order = ['sort' => 'asc'];
        $res = model('Category')->listData($cateWhere,$order,1,20);
        $code = $res['code'];
        if($code == 1){
            $list = $res['list'];

            $needVod = input('need_vod');
            if ($needVod){
                $vodIds = [];
                foreach ($list as $item){
                    $vodIds = array_merge($vodIds, explode(',', $item['void_id']));
                }
                $query = null;
                $vodeParam['ids'] = implode(',',$vodIds);

                $defaultLevel = '7,6,5,4,3,2,1,0';
                $defaultLevel = input('level', $defaultLevel);
                $vodWhere = [
                    'level' => $defaultLevel,
                    'paging' => 'no',
                    'num' => 1000
                ];

                $query= function ($query) use ($vodeParam){
                    $exp = new \think\db\Expression('field(vod_id,'.$vodeParam['ids'].')');
                    return $query->order($exp);
                };


                $resV = model('Vod')->listCacheData(array_merge($vodeParam, $vodWhere), $query);
                if ($resV['code'] == 1){
                    foreach ($list as &$item){


                        $item['vods'] = [];
                        $vodIds = explode(',', $item['void_id']);
                        if (empty($vodIds)){
                            $vodIds = [];
                        }


                        foreach ($resV['list'] as $value){

                            if (in_array($value['vod_id'], $vodIds)){
                                $item['vods'][] = $value;
                            }
                        }

                    }
                }
            }



            $data = [
                'page' => $res['page'],
                'total' => $res['total'],
                'limit' => $res['limit'],
                'list' => $list,
            ];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
    }

    public function getVersion(){
        $version = input('version');
        $os = input('os');
        if (!in_array($os, AppVersion::osArr)){
            return $this->error('系统参数错误');
        }
        $order = 'version desc';
        $res = model('app_version')->listData(['os' => $os], ['version desc'],1,1);
        $data = null;
        if ($res['code'] == 1){

            if (version_compare($version, $res['list'][0]['version'],'<')){
                $data = $res['list'][0];
            }
        }

        return $this->success($data);
    }


}