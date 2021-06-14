<?php


namespace app\api\controller\v1;


class GroupChat extends Base
{

    public function getIndex()
    {
        $param = input();
        $limit = $param['limit'];
        $page = $param['page'];

        $where = [];

        $order = [];

        $res = model('GroupChat')->listData($where,$order,$page,$limit);
        if ($res['code'] == 1){
            $data = [
                'limit' => $res['limit'],
                'list' => $res['list']
            ];
        }else{
            $data = [
                'limit' => $limit,
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
        $res = model('GroupChat')->infoData($param);
        if ($res['code'] == 1){
            $data = $res['info'];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }

    }
}