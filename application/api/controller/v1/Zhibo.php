<?php

/**
 *
 *                      .::::.
 *                    .::::::::.            | AUTHOR: 
 *                    :::::::::::           | EMAIL: 
 *                 ..:::::::::::'           | QQ: 
 *             '::::::::::::'               | 
 *                .::::::::::               | DATETIME: 2019/11/19
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 *
 */

namespace app\api\controller\v1;


class Zhibo extends Base
{
    public function getIndex()
    {
        $param = input();
        $limit = $param['limit'];
        $start = $param['start'];
        $page = $param['page'];

        $where = [];

        $order = [];

        $res = model('Zhibo')->listData($where,$order,$page,$limit);
        if ($res['code'] == 1){
            $data = [
                'limit' => $res['limit'],
                'start' => $res['start'],
                'list' => $res['list']
            ];
        }else{
            $data = [
                'limit' => $limit,
                'start' => $start,
                'list' => []
            ];
        }

        return $this->success($data);
    }

    public function getDetail()
    {
        $param = input();
        if (empty($param['id'])){
            $this->error('缺少参数ID');
        }
        $res = model('Zhibo')->infoData($param);
        if ($res['code'] == 1){
            $data = $res['info'];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }

    }
    
    public function getThirdUiName()
    {
        $config = config('maccms');
        $data = $config['zhibo'];
         if(empty($data)){
            $data='';
        }else{
            $data = $data['app_third_ui_name'];
        }
        return $this->success($data);
    }
}