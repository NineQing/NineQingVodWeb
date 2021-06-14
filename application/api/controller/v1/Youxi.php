<?php

/**
 *
 *                      .::::.
 *                    .::::::::.            | AUTHOR: 
 *                    :::::::::::           | EMAIL: 
 *                 ..:::::::::::'           | QQ: 
 *             '::::::::::::'               | 
 *                .::::::::::               | DATETIME: 2020/1/1
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


class Youxi extends Base
{

    public function getIndex()
    {
        $param = input();
        $limit = $param['limit'];
        $start = $param['start'];
        $page = $param['page'] || 1;

        $where = [];

        $order = [];

        $res = model('Youxi')->listData($where,$order,$page,$limit);
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
        $res = model('Youxi')->infoData($param);
        if ($res['code'] == 1){
            $data = $res['info'];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }

    }
}