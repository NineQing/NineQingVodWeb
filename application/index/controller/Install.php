<?php

namespace app\index\controller;

use app\common\controller\All;
use think\Request;

class Install extends All {

    /**
     * 下载页面
     */
    public function index(){
        return $this->fetch('index@install/index');
    }

    /**
     * 提交下载记录
     */
    public function ajaxRecord(Request $request){
//        exit();
        $clientIp = $request->ip();
        $inviterUserCode = input('invite_code');
        $inviteByUserId = \app\common\model\User::getUserIdByInviteCode($inviterUserCode);
        $inviteByUserId = $inviteByUserId > 0 ?$inviteByUserId : 0;
        $param = input();
        $param['invite_user_id'] = $inviteByUserId;
        $param['client_ip'] = $clientIp;
        $model = model('AppInstallRecord')->saveData($param);
        return json();
    }


}