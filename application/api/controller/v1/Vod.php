<?php
namespace app\api\controller\v1;
use think\Db;
use think\Exception;


/**
 * 视频模块
 * Class Vod
 * @package app\api\controller\v1
 */
class Vod extends Base {

    /**
     * 视频列表
     */
    public function getIndex(){
        $param = input();

//        $typeId = input('type_id');
//        if ($typeId){
//            $param['type_id'] = $typeId;
//        }
//
//        $groupId = input('group_id');
//        if ($groupId){
//            $param['group_id'] = $groupId;
//        }
//
//        $page = input('page',1) ? : 1;
//        $limit = input('limit',20) ? : 20;
        $param['paging'] = 'yes';
        $param['num'] = input('limit');
        $param['pageurl'] = 'test';

        $defaultLevel = '9,8,7,6,5,4,3,2,1,0';
        $param['level'] = input('level', $defaultLevel);


        $requestType = input('request_type');
       switch ($requestType){
            case 'top_day':
                $param['order'] = 'desc';
                $param['by'] = 'hits_day';
                break;
            case 'top_month':
                $param['order'] = 'desc';
                $param['by'] = 'hits_month';
                break;
            case 'top_week':
                $param['order'] = 'desc';
                $param['by'] = 'hits_week';
                break;
            case 'hits':
                $param['order'] = 'desc';
                $param['by'] = 'hits';
                break;
            case 'score':
                $param['order'] = 'desc';
                $param['by'] = 'score';
                break;
            case 'time':
                $param['order'] = 'desc';
                $param['by'] = 'time';
                break;
            case 'store_num':
                $param['order'] = 'desc';
                $param['by'] = 'store_num';
                break;

        }

        $random = input('random');
        $query = null;
        $category = input('category_id');
        if ($category){
            $res = model('Category')->infoData(['id' => $category]);
            if ($res['code'] == 1){
                $param['ids'] = $res['info']['void_id'];
                $query= function ($query) use ($param){
                $exp = new \think\db\Expression('field(vod_id,'.$param['ids'].')');
                    return $query->order($exp);
                };
            }else{
                return $this->error($res['msg']);
            }
        }

        if ($random){
            $expRand =  new \think\db\Expression('RAND()');
            $query = function ($query) use ($expRand){
                $query->order($expRand);
            };
        }

        $res = model('Vod')->listCacheData($param, $query);


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

    /**
     * 视频详情
     */
    public function getDetail(){

        $id = input('vod_id');
        $param['vod_id'] = $id;
        $labelParam['id'] = $id;
//        $info = $this->label_vod_detail($labelParam);
        if (!$id){
            $this->error('缺少参数ID');
        }

        $res = model('Vod')->infoData($param);
        if ($res['code'] == 1){
            model('Vod')->where('vod_id', $id)->setInc('vod_hits');
            $relVods = [];
            $info = $res['info'];
            $info['vod_points_play'] = intval(config('maccms.user.trysee_points'));

            //初始化值----------
            $model = model('vod');
            $pre = 'vod';
            $update[$pre.'_hits'] = $info[$pre.'_hits'];
            $update[$pre.'_hits_day'] = $info[$pre.'_hits_day'];
            $update[$pre.'_hits_week'] = $info[$pre.'_hits_week'];
            $update[$pre.'_hits_month'] = $info[$pre.'_hits_month'];
            $new = getdate();
            $old = getdate($info[$pre.'_time_hits']);
            //月
            if($new['year'] == $old['year'] && $new['mon'] == $old['mon']){
                $update[$pre.'_hits_month'] ++;
            }else{
                $update[$pre.'_hits_month'] = 1;
            }
            //周
            $weekStart = mktime(0,0,0,$new["mon"],$new["mday"],$new["year"]) - ($new["wday"] * 86400);
            $weekEnd = mktime(23,59,59,$new["mon"],$new["mday"],$new["year"]) + ((6 - $new["wday"]) * 86400);
            if($info[$pre.'_time_hits'] >= $weekStart && $info[$pre.'_time_hits'] <= $weekEnd){
                $update[$pre.'_hits_week'] ++;
            }else{
                $update[$pre.'_hits_week'] = 1;
            }
            //日
            if($new['year'] == $old['year'] && $new['mon'] == $old['mon'] && $new['mday'] == $old['mday']){
                $update[$pre.'_hits_day'] ++;
            }else{
                $update[$pre.'_hits_day'] = 1;
            }
            //更新数据库
            $update[$pre.'_hits'] = $update[$pre.'_hits']+1;
            $update[$pre.'_time_hits'] = time();
            $model->where($param)->update($update);

            //============


            $actor = $info['vod_actor'];
            $class = $info['vod_class'];
            $not = $info['vod_id'];
            $by = 'rnd';
            $relLimit = input('rel_limit', 10);
            $relRes =  model('Vod')->listCacheData(['class' => $class, 'actor' => $actor, 'not' => $not, 'by' => $by, 'num' => $relLimit]);
            if ($relRes['code'] == 1){
                 $relVods = $relRes['list'];
            }
            $res['info']['rel_vods'] = $relVods;
            $res['info']['comment_num'] = model('Comment')->countData(['comment_rid' => $res['info']['vod_id'], 'comment_mid' => 1]);



            // 接口数据单独处理
            if (isset($res['info']['vod_play_list'])){
                if (is_array($res['info']['vod_play_list'])){
                    $res['info']['vod_play_list'] = array_values($res['info']['vod_play_list']);

                    foreach ($res['info']['vod_play_list'] as &$value){
                        if (isset($value['urls']) && is_array($value['urls'])){
                            $value['urls'] = array_values($value['urls']);
                        }
                    }


                }
            }




            $data = $res['info'];


			/*扩展分类只显示前4个*/
			$vod_classes = $data['vod_class'];
            $vod_class_arr = explode(',',$vod_classes);
            if(count($vod_class_arr)>4){
                $data['vod_class'] = implode(',',array_slice($vod_class_arr,0,4));
            }


            $config = config('maccms');
            $user = $config['user'];


            $user_level_config = $user['user_level'];
            $user_id = $GLOBALS['user']['user_id'];
            $userData = [];
            $user_sub_count = Db::name('user')
                ->where('user_pid',$user_id)
                // ->whereOr('user_pid_2',$user_id)
                // ->whereOr('user_pid_3',$user_id)
                ->count();
            $userData['user_level'] = 1;
            foreach ($user_level_config as $k=>$v){
            	if($user_sub_count>=$v['people_count']){
                    $userData['user_level'] = str_replace("v","",$k);
                    $userData['user_view_count'] = $v['view_count'];
                    $userData['leave_peoples'] =$v['people_count']-$user_sub_count>0?$v['people_count']-$user_sub_count:0;
                    if($userData['leave_peoples'] == 0 and $userData['user_level']<5){
                        $userData['leave_peoples'] = $user_level_config['v'.($userData['user_level']+1)]['people_count']-$user_sub_count;
                    }
                }


            }

            if($GLOBALS['user']['group_id']!=3){
                if(!empty($userData['user_view_count'])){
                    // 播放记录
                    $used_times = getUserVideoTimes($GLOBALS['user']['user_id']);
                    if($used_times<=0){
                        $data['user_video'] = 0;
                        return $this->success($data);
                    }
                    $data['user_video'] = $used_times;
                    $data2 = [];
                    $data2['ulog_mid'] = 0;
                    $data2['ulog_rid'] = 0;
                    $data2['ulog_sid'] = 0;
                    $data2['ulog_nid'] = 0;
                    $data2['ulog_type'] = 5;
                    $data2['user_id'] = $GLOBALS['user']['user_id'];
                    $data2['ulog_points'] = 0;
                    model('Ulog')->saveData($data2);
                }else{
                    $data['user_video'] = 0;
                    return $this->success($data);
                }
            }else{
                $data['user_video'] = -1;
            }

            $data['playInfo'] = Db::name('Vlog')->where('user_id',$user_id)
                ->where('vod_id',$id)
                ->order('last_view_time desc')
                ->limit(1)
                ->field('nid,curProgress,source,urlIndex,playSourceIndex')
                ->find();

            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }
    }

    public function getPlay(){
        $id = input('id');
        $sid = input('sid');
        $nid = input('nid');
        $info = $this->label_vod_play('play');

        if ($info['code']){
            $data = [
                'code' => $info['code'],
                'msg' => $info['msg']
            ];
        }else{
            $data = array_merge(['code'=> 200], $info);
        }

        return $this->success($data);
    }



    public function getTypes(){
        $where = [
            'type_mid' => 1
        ];
        $res = model('type')->listData($where);
        if ($res['code'] == 1){
            $list = array_values($res['list']);
            $total = $res['total'];
            $data = [
                'list' => $list,
                'total' => $total,
                'page' => $res['page'],
                'limit' => $res['limit']
            ];
            return $this->success($data);
        }
    }

    public function getType(){
        $where = [
            'type_id' => input('type_id')
        ];
        $info = null;
        $res = model('Type')->infoData($where);
        if ($res['code'] == 1){
            $info = $res['info'];
            $typeExtend = $res['info']['type_extend'];


            if (1 == 1){
                $typeExtendClassArr = explode(',', $typeExtend['class']);

                $classes = [];
                foreach ($typeExtendClassArr as $key => $itemClass){
                    if (count($classes) < 4){
                        $item = [
                            'name' => $itemClass,
                        ];
                        $item['vods'] = [];
                        $defaultLevel = '7,6,5,4,3,2,1,0';
                        $defaultLevel = input('level', $defaultLevel);
                        $vodWhere = [
                            'type' => $where['type_id'],
                            'class' => implode(',', [$itemClass]),
                            'num' => 7,
                            'level' => $defaultLevel,
                            'order' => 'desc',
                            'by' => 'level'
                        ];
                        $resV = model('Vod')->listCacheData($vodWhere);
                        if ($resV['code'] == 1){
                            if (!empty($resV['list'])){

                            }
                            $item['vods'] = $resV['list'];
                            $classes[] = $item;
                        }
                    }
                }

                $info['classes'] = $classes;
            }
        }else{
            return $this->error('视频不存在');
        }

        return $this->success($info);




    }


    public function postScore()
    {
        $this->checkLogin();

        $param = input();
        $id = $param['id'];
//        $mid = $param['mid'];
        $mid = 1;
        $score = $param['score'];
        if (!in_array($score, [1,2,3,4,5])){
            return $this->error('只能打1-5分');
        }

        if(empty($id) ||  !in_array($mid,['1','2','3','8','9']) ) {
            return $this->error('参数错误');
        }

        $today_start=strtotime(date("Y-m-d 00:00:00"));
        $tomorrow_start = strtotime(date("Y-m-d 00:00:00",strtotime("+1 day")));
        /*$exsWhere = [
          ['user_id','=',$GLOBALS['user']['user_id']],
          ['ulog_rid','=',$id],
          ['ulog_mid','=',$mid],
          ['ulog_type','=',6],
          ['ulog_time','>',$today_start],
          ['ulog_time','<',$tomorrow_start],
        ];*/
        $exsWhere = [
            'user_id'=> ['=',$GLOBALS['user']['user_id']],
            'ulog_rid'=>['=',$id],
            'ulog_mid'=>['=',$mid],
            'ulog_type'=>['=',6],
            'ulog_time'=>['>',$today_start],
            'ulog_time'=>['<',$tomorrow_start],
        ];
        $exs = model('Ulog')->infoData($exsWhere);
        if ($exs['code'] != 1002){
            if ($exs['code'] == 1){
                return $this->error('已经进行过评分了');
            }else{
                return $this->error('参数错误');
            }
        }


//        $mids = [1=>'vod',2=>'art',3=>'topic',8=>'actor',9=>'role'];
        $mids = [1=>'vod'];
        $pre = $mids[$mid];
        $where = [];
        $where[$pre.'_id'] = $id;
        $field = $pre.'_score,'.$pre.'_score_num,'.$pre.'_score_all';
        $model = model($pre);

        $res = $model->infoData($where,$field);
        if($res['code']>1) {
            return $this->error($res['msg']);
        }
        $info = $res['info'];
		$add_score = 0;
        if ($info) {
            if($score){
//                $cookie = $pre.'-score-'.$id;
//                if(!empty(cookie($cookie))){
//                    return json(['code'=>1002,'msg'=>'您已评分']);
//                }
                $update=[];
                $update[$pre.'_score_num'] = $info[$pre.'_score_num']+1;
                $update[$pre.'_score_all'] = $info[$pre.'_score_all']+$score;
                $update[$pre.'_score'] = number_format( $update[$pre.'_score_all'] / $update[$pre.'_score_num'] ,1,'.','');
                // 更新评分记录
                $model->where($where)->update($update);


                // 增加评分记录
                $data2 = [];
                $data2['ulog_mid'] = $mid;
                $data2['ulog_rid'] = intval($id);
                $data2['ulog_sid'] = 0;
                $data2['ulog_nid'] = 0;
                $data2['ulog_type'] = 6;
                $data2['user_id'] = $GLOBALS['user']['user_id'];
                $data2['ulog_points'] = $score;
                $res = model('Ulog')->saveData($data2);

                if ($res['code'] == 1){
                    // 发放评分奖励
                    $config = config('task.mark');
                    if ($config['status'] == 1){
                        $reword = $config['reward'];
                        if ($reword['points'] > 0){
                            // 今日已评分数量
                            $exsPlogsCount = 0;
                            if ($config['reward_num']){
                                $todayTime = strtotime(date('Y-m-d', time()));
                                $toTime = $todayTime + 24 * 3600;
                                $where = [
                                    'plog_time' => function($query) use($todayTime, $toTime){
                                        $query->where('plog_time', '>=', $todayTime)->where('plog_time', '<', $toTime);
                                    },
                                    'user_id' => $GLOBALS['user']['user_id'],
                                    'plog_type' => 12
                                ];
                                $exsPlogsCount = model('Plog')->countData($where);
                            }
                            // 如果不限制奖励次数 或者 奖励次数还未用完
                            if (empty($config['reward_num']) || $config['reward_num'] > $exsPlogsCount){
                                $user['user_id'] = $GLOBALS['user']['user_id'];
                                $res = model('User')->where($user)->setInc('user_points', $reword['points']);
                                $add_score = $reword['points'];
                                //积分日志
                                $plog = [];
                                $plog['user_id'] = $GLOBALS['user']['user_id'];
                                input('user_id', $plog['user_id']);
                                $plog['plog_type'] = 12;
                                $plog['plog_points'] =  $reword['points'];
                                $res = model('Plog')->saveData($plog);
								return $this->success(['score'=>$add_score]);
                            }
                        }
                    }

                }
                   return $this->error('评分成功！');

                $data['score'] = $update[$pre.'_score'];
                $data['score_num'] = $update[$pre.'_score_num'];
                $data['score_all'] = $update[$pre.'_score_all'];

//                cookie($cookie,'t',30);
            }
            else{
                $data['score'] = $info[$pre.'_score'];
                $data['score_num'] = $info[$pre.'_score_num'];
                $data['score_all'] = $info[$pre.'_score_all'];
            }
        }else{
            $data['score'] = 0.0;
            $data['score_num'] = 0;
            $data['score_all'] = 0;
        }
        
        return json(['code'=>1,'msg'=>'感谢您的参与，评分成功！','data'=>$data]);
    }

	/**
     * 获取视频排行榜
     * */
    public function getVodPhb()
    {
        $type = input('type');
        $order_by = input('order_by');
        $page = input('page');
        $limit = input('limit');

        if(empty($page)){
            $page = 1;
        }

        if(empty($limit)){
            $limit = 12;
        }

        if(empty($type) or empty($order_by)){
            return $this->error('请按要求传参');
        }
        $where = [
            'type_id'=>$type,
            'vod_year'=>date('Y')
        ];
        $res = model('Vod')->listData($where,$order_by,$page,$limit);
        if ($res['code'] == 1){
            $data['list'] = $res['list'];
            return $this->success($data);
        }else{
            return $this->error($res['msg']);
        }

    }


    /**
     * 获取视频排行榜① 
     * */
    public function getVodPhbAll()
    {


        $phbType = input('orderType');
        $types = [
            'week'=>'vod_hits_week',
            'month'=>'vod_hits_month',
            'total'=>'vod_hits',
            'day'=>'vod_hits_day',
        ];
        $type = input('type');
        if(empty($phbType) or !array_key_exists($phbType,$types)){
            $phbType = 'week';
        }
        $page = input('page');
        $limit = input('limit');
        if(empty($page)){
            $page = 1;
        }

        if(empty($limit)){
            $limit = 12;
        }

        $data = (object)[
            'list'=>[
                 [
                    'vod_type_id'=>1,
                    'vod_type_name'=>'热播推荐',
                    'vod_list'=>model('Vod')->listData(['vod_levels'=>1],$types['day'].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>2,
                    'vod_type_name'=>'电影热播推荐',
                    'vod_list'=>model('Vod')->listData(['type_id'=>1,'vod_year'=>date('Y')],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>3,
                    'vod_type_name'=>'电视剧热播推荐',
                    'vod_list'=>model('Vod')->listData(['type_id'=>2,'vod_year'=>date('Y')],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>4,
                    'vod_type_name'=>'综艺热播推荐',
                    'vod_list'=>model('Vod')->listData(['type_id'=>3,'vod_year'=>date('Y')],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>5,
                    'vod_type_name'=>'动漫热播推荐',
                    'vod_list'=>model('Vod')->listData(['type_id'=>4,'vod_year'=>date('Y')],$types[$phbType].' desc',1,12)['list'],
                ]
            ]
        ];

        // $typd_ids = [1,2,3,4];
        // if(!in_array($type,$typd_ids)){
        //     return $this->error('分类有误');
        // }
        //
        // $type_names = ['','电影','电视剧','综艺','动漫'];
        // $data = (object)[
        //   'list'=>[
        //       'vod_type_id'=>$type,
        //       'vod_type_name'=>$type_names[$type].'推荐',
        //       'vod_list'=>model('Vod')->listData(['type_id'=>$type,'vod_year'=>date('Y')],$types[$phbType].' desc',$page,$limit)['list'],
        //   ]
        // ];

        return $this->success($data);

    }


 /**
     * 获取视频排行榜② //💎仿冷咖影视-反编译首页布局👇
     * */
/*  public function getVodPhbAll()
    {


        $phbType = input('orderType');
        $types = [
            'week'=>'vod_hits_week',
            'month'=>'vod_hits_month',
            'total'=>'vod_hits',
            'day'=>'vod_hits_day',
        ];
        $type = input('type');
        if(empty($phbType) or !array_key_exists($phbType,$types)){
            $phbType = 'week';
        }
        $page = input('page');
        $limit = input('limit');
        if(empty($page)){
            $page = 1;
        }

        if(empty($limit)){
            $limit = 12;
        }

        $data = (object)[
            'zhui'=>[
                [
                    'vod_type_id'=>1,
                    'vod_type_name'=>'猜你会追',
	                'vod_type_img'=>'',
                    'vod_list'=>model('Vod')->listData(['vod_level'=>5],$types[$phbType].' arclist',1,12)['list'],
                ]
            ],
            'list'=>[
                [
                    'vod_type_id'=>1,
                    'vod_type_name'=>'腾讯会员热门推荐',
                    'vod_type_img'=>'http://v.qq.com/favicon.ico', 
                    'vod_list'=>model('Vod')->listData(['vod_play_from'=>qq],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>2,
                    'vod_type_name'=>'爱奇艺会员热门推荐',
                    'vod_type_img'=>'http://www.iqiyipic.com/common/fix/128-128-logo.png', 
                    'vod_list'=>model('Vod')->listData(['vod_play_from'=>qiyi],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>3,
                    'vod_type_name'=>'优酷会员热门推荐',
	    'vod_type_img'=>'https://img.alicdn.com/tfs/TB1WeJ9Xrj1gK0jSZFuXXcrHpXa-195-195.png',
                    'vod_list'=>model('Vod')->listData(['vod_play_from'=>youku],$types[$phbType].' desc',1,12)['list'],
                ],
                [
                    'vod_type_id'=>4,
                    'vod_type_name'=>'芒果会员热门推荐',
	    'vod_type_img'=>'https://www.mgtv.com/favicon.ico',
                    'vod_list'=>model('Vod')->listData(['vod_play_from'=>mgtv],$types[$phbType].' desc',1,12)['list'],
                ]
            ]
        ];
        
         return $this->success($data);

    }
*/ //💎②仿冷咖影视-反编译首页布局👆

    /*提交观影记录*/
    public function postVideoViewRecode()
    {
        $this->checkLogin();
        $user_id = $GLOBALS['user']['user_id'];
        $rid = input('rid');
        $nid = input('nid');
        $source = input('source');
        if(empty($rid) or empty($nid) or empty($source)){
            return $this->error('参数有误');
        }
        $data = [];
        $data['vod_id'] = $rid;
        $data['source'] = $source;
        $data['nid'] = $nid;
        $data['user_id'] = $user_id;
        $data['source'] = $source;
        $data['last_view_time'] = time();
        model('Vlog')->saveData($data);

        $user_video = getUserVideoTimes($user_id);
        $data = [
            'user_video'=>$user_video
        ];
        return $this->success($data);
    }

    /*获取视频进度*/
    public function getVideoProgress()
    {
        $this->checkLogin();
        $vod_id = input('vod_id');
        $nid = input('nid');
        $source = input('source');
        $user_id = $GLOBALS['user']['user_id'];
        if(empty($vod_id) or empty($nid) or empty($source)){
            return $this->error('请按要求传参');
        }

        $data = Db::name('Vlog')
            ->where('user_id',$user_id)
            ->where('source',$source)
            ->where('nid',$nid)
            ->value('curProgress');
        if(empty($data)){
            $data = 0;
        }
        return $this->success($data);
    }

}