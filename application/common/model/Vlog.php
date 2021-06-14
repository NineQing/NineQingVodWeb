<?php

/**
 *
 *                      .::::.
 *                    .::::::::.            | 
 *                    :::::::::::           | 
 *                 ..:::::::::::'           | 
 *             '::::::::::::'               | 
 *                .::::::::::               | DATETIME: 2019/12/28
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

namespace app\common\model;

use think\Db;
class Vlog extends Base
{
    protected $table = 'mac_vlog';
    
    
    
    public function listData($where,$order,$page=1,$limit=20,$start=0,$field='*',$totalshow=1)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        $tmp = Db::name('Vlog')
            ->where($where)
            ->field('max(last_view_time) last_view_time,vod_id,percent,source,nid,user_id')
            ->group('vod_id,user_id')
            ->order($order)
            ->limit($limit_str)
            ->select();
        $total = Db::name('Vlog')
            ->where($where)
            ->field('max(last_view_time) last_view_time,vod_id,percent,source,nid,user_id')
            ->group('vod_id,user_id')
            ->count('vod_id');

        $list = [];
		$pichost = $this->thost();
        foreach($tmp as $k=>$v){
            $vod_id = $v['vod_id'];
            $vod = Db::name('Vod')->where('vod_id',$vod_id)
            ->field(['type_id,vod_name,vod_pic,vod_pic_thumb'])
            ->find();
            if(!empty($vod)){
                $vlog = Db::name('Vlog')
                    ->where('user_id',$v['user_id'])
                    ->where('vod_id',$v['vod_id'])
                    ->where('last_view_time',$v['last_view_time'])
                    ->field('nid,curProgress,percent,source')
                    ->find();
                $v['type_id'] = $vod['type_id'];
                $v['vod_name'] = $vod['vod_name'];
				if(strpos($vod['vod_pic'], 'http') ===0){}else{
				 $vod['vod_pic'] = $pichost . $vod['vod_pic'] ;
			     }
                $v['vod_pic'] = $vod['vod_pic'];
                $v['pic_thumb'] = $vod['vod_pic_thumb'];
                $v['nid'] = $vlog['nid'];
                $v['curProgress'] = $vlog['curProgress'];
                $v['percent'] = $vlog['percent'];
                $v['source'] = $vlog['source'];
            	$list[] = $v;
            }else{
            	$v['type_id'] = '';
                $v['vod_name'] = '';
                $v['vod_pic'] = '';
            }
        }

        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }

    public function saveData($data)
    {
        $user_id = $GLOBALS['user']['user_id'];
        $data['user_id'] = $user_id;

        $res = $this->allowField(true)->insert($data);

        if(false === $res){
            return ['code'=>1004,'msg'=>'保存失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'保存成功'];
    }
    public function thost()
    {
		if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') || (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {

        $_SERVER['REQUEST_SCHEME'] = 'https';

        } else {

        $_SERVER['REQUEST_SCHEME'] = 'http';

        }
		$host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .'/';
		return $host;
	}	
}