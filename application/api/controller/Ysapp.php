<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Ysapp extends Base
{

  public function fenl(){
    $so =db('type')->where('type_pid','0')->where('type_status','1')->where('type_mid','1')->select();
    return  json_encode($so);
  }
  //新版 首页
  public function fenplay(){
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
    $hot_list = model('Vod')->listDatae(['vod_year'=>date('Y')],$types[$phbType].' desc',1,9);
    $dianying = model('Vod')->listDatae(['type_id'=>1,'vod_year'=>date('Y')],$types[$phbType].' desc',1,9);
    $lianxuju = model('Vod')->listDatae(['type_id'=>2,'vod_year'=>date('Y')],$types[$phbType].' desc',1,9);
    $zongyi = model('Vod')->listDatae(['type_id'=>3,'vod_year'=>date('Y')],$types[$phbType].' desc',1,9);
    $dongman = model('Vod')->listDatae(['type_id'=>4,'vod_year'=>date('Y')],$types[$phbType].' desc',1,9);
    $typese =db('type')->where('type_pid','0')->where('type_status','1')->where('type_mid','1')->select();
    $lunbo = model('Vod')->listData(['vod_level'=>9],$types[$phbType].' desc',1,9);
    foreach($lunbo['list'] as $k=>$v){
        $tlist[$k]['vod_id'] =$v['vod_id'];
        $tlist[$k]['vod_pic'] =$v['vod_pic'];
        $tlist[$k]['vod_name'] =$v['vod_name'];
        $tlist[$k]['lianjie'] ="";
    }
    foreach($typese as $key=>$vo){
        $title[$key]['type_name']=$vo['type_name'];
        $title[$key]['type_id']=$vo['type_id'];
    }
    $list['title'] = $title;
    $list['tui'] = "";
    $list['tuicount'] = 0;
    $list['lunbo'] = $tlist;
    $so['dianying'] = $dianying['list'];
    $so['dianyingcount'] = $dianying['total'];
    $so['lianxuju'] = $lianxuju['list'];
    $so['lianxujucount'] = $lianxuju['total'];
    $so['zongyi'] = $zongyi['list'];
    $so['zongyicount'] = $zongyi['total'];  
    $so['dongman'] = $dongman['list'];
    $so['dongmancount'] = $dongman['total'];  
    $so['hot_list'] = $hot_list['list'];
    $so['hot_listcount'] = $hot_list['total'];
    $re['status'] =1;
    $re['msg'] ="所有视频";
    $re['data'] =$so;
    $re['list'] = $list;
    return  json_encode($re);
  }
  //新版筛选分类
      public function shaifind(){
        $where = [
            'type_mid' => 1
        ];
        $res = model('type')->listData($where);
        if ($res['code'] == 1){
            //$list = array_values($res['list']);
            foreach($res['list'] as $k=>$v){
                $address[$k]['data']=$v['type_extend']['area'];
                $time[$k]['data']=$v['type_extend']['year'];
                $type[$k]['data']=$v['type_extend']['class'];
                $address[$k]['type_id'] = $v['type_id'];
                $time[$k]['type_id'] = $v['type_id'];
                $type[$k]['type_id'] = $v['type_id'];
            }
            $list['address'] = $this->str_array($address,"address");
            $list['time'] = $this->str_array($time,"timename");
            $list['type'] = $this->str_array($type,"typename");
            $data = [
                'status' => 1,
                'msg' => "筛选数据",
                'list' => $list,
            ];
            return  json_encode($data);
        }
    }
    public function str_array($str,$str1){
        foreach($str as $k=>$v){
            $arr[$k]=explode(",",$v['data']);
           $id[$k] = $v['type_id'];
            
        }
         foreach($arr as $k=>$v){
            foreach($v as $m=>$n){
                $list[$id[$k]][$m+1][$str1] = $n;
                $list[$id[$k]][$m+1]['id'] = $m+1;
                
            }
            $list[$id[$k]][0][$str1] = "全部";
            $list[$id[$k]][0]['id'] = 0;
        }
        return $list;
        
    }
    //新版获取视频
    public function shaixuan(){
        $param = input();
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
                'status' => 1,
                'msg' => "视频筛选数据",
                'list' => $res['list'],
            ];
            return  json_encode($data);
        }else{
            $data = [
                'status' => 0,
                'msg' => "视频筛选数据",
                'list' => '',
            ];            
            return  json_encode($data);
        }

    }
    //新版播放视频
    public function playbo(){
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

            $param1 =[
                'class'=>$data['vod_class'],
                'type'=>$data['type_id'],
                'page'=>1,
                'num'=>3,
                ];
            $query = null;
            // foreach ($data['vod_play_list'] as $k=>$v){
            //     $playform[$k]=$v['player_info']['show'];
                
            // }
            $res = model('Vod')->listCacheData($param1, $query);
            $data = [
                'status' => 1,
                'msg' => "视频详情",
                'data' => $data,
                'list' =>$res['list']
            ];
            return  json_encode($data);
        }else{
            return $this->error($res['msg']);
        }        
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
   public function ffenl(){
     $data=input();
     $pid=$data['id']+1;
    $so =db('type')->where('type_pid',$pid)->where('type_status','1')->where('type_mid','1')->select();

    return  json_encode($so);
  }
  public function wzpid(){
     $id=$_GET['id'];
     $so =db('art')->where('art_id', $id)->find();
      return  json_encode($so);
  }
  
   public function shouye(){
    $so =db('vod')->limit(0,4)->order('vod_time desc')->whereor('type_id','3')->select();
    $so1 =db('vod')->limit(0,6)->order('vod_time desc')->whereor('type_id','4')->select();
    $so2 =db('vod')->limit(0,6)->order('vod_time desc')->where('type_id_1','2')->select();
    $so3 =db('vod')->limit(0,6)->order('vod_time desc')->where('type_id_1','1')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
    foreach($so1 as $key=>$vo){
		if (strpos($so1[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so1[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so1[$key]['vod_pic'];
		}
	}
    foreach($so2 as $key=>$vo){
		if (strpos($so2[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so2[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so2[$key]['vod_pic'];
		}
	}
    foreach($so3 as $key=>$vo){
		if (strpos($so3[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so3[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so3[$key]['vod_pic'];
		}
	}
    $arr['zy']['data']=$so;
    $arr['dm']['data']=$so1;
    $arr['dy']['data']=$so3;
    $arr['dsj']['data']=$so2;
    return  json_encode($arr);
  }
  public function sosuo(){
     $name=$_GET['name'];
    //->where('fl','NEQ','福利片')
     $so =db('vod')->limit(0,21)->order('vod_time desc')->where('vod_name', 'like', '%'.$name.'%')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
    $arr['dsj']['data']=$so;
      return  json_encode($arr);
  }
  public function sosuoid(){
     $id=$_GET['id'];
    //->where('fl','NEQ','福利片')
     $so =db('vod')->order('vod_time desc')->where('vod_id', $id)->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
    
      return  json_encode($so);
  }

  public function gxsosuo(){
     $name=$_GET['name'];
     $yeshu=$_GET['yema'];
   
    if($yeshu==1){
      $zuixiao=0;
        $zuida=21;
      }else{
      $zuixiao=($yeshu*21)-20;
        $zuida=$yeshu*21;
      }
    $count =db('vod')->order('vod_time desc')->where('vod_name', 'like', '%'.$name.'%')->count();
    if($zuixiao>$count){
      return json(['code' => '0','msg'=>'已经加载完了，没有了呦！']);
    }else{
     $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_name', 'like', '%'.$name.'%')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
    $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
  }
  
  public function dsjsy1(){
    $shaix=$_GET['shaix'];
    $so =db('vod')->limit(0,21)->order('vod_time desc')->where('type_id',$shaix)->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
  }
    public function phdsj(){
	$data=input();
	$flpin= $data['flpin'];
	$leibie= $data['leibie'];
	if($flpin==1){
		$sodat='vod_hits_week desc';
	}
	if($flpin==2){
		$sodat='vod_hits_month desc';
	}
	if($flpin==3){
		$sodat='vod_score desc';
	}
	$so1 =db('vod')->where('type_id_1',$leibie)->count();
     if($so1 == 0){
		$sodata['type_id']=$leibie;
	  }else{
		$sodata['type_id_1']=$leibie;
		 }	
  $so =db('vod')->limit(0,11)->order($sodat)->where($sodata)->select();	
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);  
	}
  public function fldsj(){
	  $data=input();
	  $fltype= $data['fltype'];
	  $flyear= $data['flyear'];
	  $flpin= $data['flpin'];
	  if($fltype == 0 && $flyear == 0 && $flpin == 0){
		$so =db('vod')->limit(0,21)->order('vod_time desc')->select();  
	  }else{
		 if($fltype != 0){
	    $so1 =db('vod')->where('type_id_1',$fltype)->count();
         if($so1 == 0){
		 $sodata['type_id']=$fltype;
	     }else{
			 $sodata['type_id_1']=$fltype;
		 }			 			 
		 }	
		 if($flyear != 0){
			 $sodata['vod_year']=$flyear;
		 }
		 if($flpin == 0){
			 $sodat='vod_time desc';
		 }
		 if($flpin == 1){
			 $sodat='vod_time desc';
		 }
		 if($flpin == 2){
			 $sodat='vod_hits_week desc';
		 }
		 if($flpin == 3){
			 $sodat='vod_score desc';
		 }
    $so =db('vod')->limit(0,21)->order($sodat)->where($sodata)->select();		 
	  }

    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);	  
  } 
  public function fldsjjzgd(){
	  $data=input();
	  $fltype= $data['fltype'];
	  $flyear= $data['flyear'];
	  $flpin= $data['flpin'];	  
     $yeshu=$data['yema'];
      if($yeshu==1){
      $zuixiao=0;
        $zuida=21;
      }else{
      $zuixiao=($yeshu*21)-20;
        $zuida=$yeshu*21;
      }
	if($fltype == 0 && $flyear == 0 && $flpin == 0){  
    $count =db('vod')->order('vod_time desc')->count();
    if($zuixiao>$count){
   return json(['code' => '0','msg'=>'已经加载完了，没有了呦！']);
    }else{
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
	}else{
		 if($fltype != 0){
		    $so1 =db('vod')->where('type_id_1',$fltype)->count();
            if($so1 == 0){
		    $sodata['type_id']=$fltype;
	        }else{
			 $sodata['type_id_1']=$fltype;
		 }		 
		 }	
		 if($flyear != 0){
			 $sodata['vod_year']=$flyear;
		 }
		 if($flpin == 0){
			 $sodat='vod_time desc';
		 }
		 if($flpin == 1){
			 $sodat='vod_time desc';
		 }
		 if($flpin == 2){
			 $sodat='vod_hits_week desc';
		 }
		 if($flpin == 3){
			 $sodat='vod_score desc';
		 }
    $count =db('vod')->order($sodat)->where($sodata)->count();
    if($zuixiao>$count){
   return json(['code' => '0','msg'=>'已经加载完了，没有了呦！']);
    }else{
    $so =db('vod')->limit($zuixiao,$zuida)->order($sodat)->where($sodata)->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }	
	  }
    
    
  }  
  public function dsjsy(){
     $leix=$_GET['leix'];
    $shaix=$_GET['shaix'];
    if($leix==0){
      if($shaix==1){
      $dfs='国产';
      }else if($shaix==2){
      $dfs='香港';
      }else if($shaix==3){
      $dfs='韩国';
      }else if($shaix==4){
      $dfs='欧美';
      }else if($shaix==5){
      $dfs='日本';
      }else if($shaix==6){
      $dfs='台湾';
      }else if($shaix==7){
      $dfs='海外';
      }
      
    if($shaix==0){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->where('vod_class','国产剧')->whereor('vod_class','香港剧')->whereor('vod_class','韩国')->whereor('vod_class','欧美')->whereor('vod_class','台湾')->whereor('vod_class','日本')->whereor('vod_class','海外')->select();
      foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
   $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix==8){
     $so =db('vod')->limit(0,21)->order('vod_time desc')->where('type_id','22')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}     
	 $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix!=0){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->where('vod_class',$dfs)->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}     
	 $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
      
    }else if($leix==1){
      if($shaix==1){
      $dfs='动作';
      }else if($shaix==2){
      $dfs='喜剧';
      }else if($shaix==3){
      $dfs='爱情';
      }else if($shaix==4){
      $dfs='科幻';
      }else if($shaix==5){
      $dfs='恐怖';
      }else if($shaix==6){
      $dfs='剧情';
      }else if($shaix==7){
      $dfs='战争';
      }
      if($shaix==0){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->where('vod_class','动作')->whereor('vod_class','喜剧')->whereor('vod_class','爱情')->whereor('vod_class','科幻')->whereor('vod_class','恐怖')->whereor('vod_class','剧情')->whereor('vod_class','战争')->select();
        foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
	 $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix==8){
     $so =db('vod')->limit(0,21)->order('vod_time desc')->where('type_id','23')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix!=0){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->where('vod_class',$dfs)->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
      
    }else if($leix==2){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->whereor('vod_class','动漫')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($leix==3){
    $so =db('vod')->limit(0,21)->order('vod_time desc')->whereor('vod_class','综艺')->select();
    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
    
    
  }
  public function dsjjzgd(){
     $leix=$_GET['leix'];
     $yeshu=$_GET['yema'];
    $shaix=$_GET['shaix'];
    
      if($yeshu==1){
      $zuixiao=0;
        $zuida=21;
      }else{
      $zuixiao=($yeshu*21)-20;
        $zuida=$yeshu*21;
      }
    
    if($leix==0){
      if($shaix==1){
      $dfs='国产';
      }else if($shaix==2){
      $dfs='香港';
      }else if($shaix==3){
      $dfs='韩国';
      }else if($shaix==4){
      $dfs='欧美';
      }else if($shaix==5){
      $dfs='日本';
      }else if($shaix==6){
      $dfs='台湾';
      }else if($shaix==7){
      $dfs='海外';
      }
      
      if($shaix==0){
      $count =db('vod')->order('vod_time desc')->where('vod_class','国产')->whereor('vod_class','香港')->whereor('vod_class','韩国')->whereor('vod_class','欧美')->whereor('vod_class','台湾')->whereor('vod_class','日本')->whereor('vod_class','海外')->count();
      }else if($shaix==8){
      $count =db('vod')->order('vod_time desc')->where('type_id','22')->count();
      }else if($shaix!=0){
      $count =db('vod')->order('vod_time desc')->where('vod_class',$dfs)->count();
      }
      
    }else if($leix==1){
      if($shaix==1){
      $dfs='动作';
      }else if($shaix==2){
      $dfs='喜剧';
      }else if($shaix==3){
      $dfs='爱情';
      }else if($shaix==4){
      $dfs='科幻';
      }else if($shaix==5){
      $dfs='恐怖';
      }else if($shaix==6){
      $dfs='剧情';
      }else if($shaix==7){
      $dfs='战争';
      }
      if($shaix==0){
      $count =db('vod')->order('vod_time desc')->where('vod_class','动作')->whereor('vod_class','喜剧')->whereor('vod_class','爱情')->whereor('vod_class','科幻')->whereor('vod_class','恐怖')->whereor('vod_class','剧情')->whereor('vod_class','战争')->count();
      }else if($shaix==8){
      $count =db('vod')->order('vod_time desc')->where('type_id','23')->count();
      }else if($shaix!=0){
      $count =db('vod')->order('vod_time desc')->where('vod_class',$dfs)->count();
      }
    }else if($leix==2){
      $count =db('vod')->order('vod_time desc')->where('vod_class','动漫')->count();
    }else if($leix==3){
    $count =db('vod')->order('vod_time desc')->where('vod_class','综艺')->count();
    }
    
    if($zuixiao>$count){
   return json(['code' => '0','msg'=>'已经加载完了，没有了呦！']);
    }else{
      if($leix==0){
        if($shaix==0){
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class','国产')->whereor('vod_class','香港')->whereor('vod_class','韩国')->whereor('vod_class','欧美')->whereor('vod_class','台湾')->whereor('vod_class','日本')->whereor('vod_class','海外')->select();
          foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
	  $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix==8){
     $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('type_id','22')->select();
	     foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix!=0){
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class',$dfs)->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
        
        
    }else if($leix==1){
        if($shaix==0){
   $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class','动作')->whereor('vod_class','喜剧')->whereor('vod_class','爱情')->whereor('vod_class','科幻')->whereor('vod_class','恐怖')->whereor('vod_class','剧情')->whereor('vod_class','战争')->select();
     foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}   
	$arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix==8){
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('type_id','23')->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }else if($shaix!=0){
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class',$dfs)->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
        
      }else if($leix==2){
       $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class','动漫')->select();
	       foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
      }else if($leix==3){
       $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('vod_class','综艺')->select();
	       foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
      }
    }
  }
  
  
  
  
  
  
  public function dsjjzgd1(){
     $yeshu=$_GET['yema'];
    $shaix=$_GET['shaix'];
      if($yeshu==1){
      $zuixiao=0;
        $zuida=21;
      }else{
      $zuixiao=($yeshu*21)-20;
        $zuida=$yeshu*21;
      }
    $count =db('vod')->order('vod_time desc')->where('type_id',$shaix)->count();
    if($zuixiao>$count){
   return json(['code' => '0','msg'=>'已经加载完了，没有了呦！']);
    }else{
    $so =db('vod')->limit($zuixiao,$zuida)->order('vod_time desc')->where('type_id',$shaix)->select();
	    foreach($so as $key=>$vo){
		if (strpos($so[$key]['vod_pic'], 'http') !== false) {	
		}
		else{
			$so[$key]['vod_pic']='http://'. $_SERVER['HTTP_HOST'].'/'. $so[$key]['vod_pic'];
		}
	}
      $arr['dsj']['data']=$so;
      return  json_encode($arr);
    }
    
    
  }
  
  
  
}
