<?php


namespace app\api\controller\v1;
use app\common\model\Topic as MT;


class Topic extends Base
{
    public function getTopicList()
    {
        $params = input();
        $res = model('Topic')->listData($params,"topic_time desc");
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
    
    public function getTopicDetail()
    {
        $id = input('topic_id');
        $param['topic_id'] = $id;
        if (!$id) {
            $this->error('缺少参数ID');
        }
        $res = model('Topic')->infoData($param);
        if ($res['code'] == 1) {
            $data = $res['info'];
            return $this->success($data);
        } else {
            return $this->error($res['msg']);
        }

    }
}