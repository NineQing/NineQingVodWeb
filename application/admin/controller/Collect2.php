<?php
/**
 *  『萌芽模板网』多功能综合资源采集插件
 * 
 * 官方网站    www.vrecf.com
 * @author     萌芽<209910539@qq.com>
 * @说明	   请勿擅自修改文件内容，否则可能无法正常使用！
 */
namespace app\admin\controller;
use think\Db;
use think\Cache;
use app\common\util\PclZip;

class Collect2 extends Base
{
    public function __construct()
    {
        parent::__construct();
		header('X-Accel-Buffering: no');
		$this->_save_path = './application/data/update/';
		$config = config('maccms');
		$plug_ver = config('mycjversion');
		$this->cjuser = config('mycjuser');
		$open = json_encode($this->cjuser['open'],true);
		$this->assign('user',$this->cjuser['login']); 
		$this->assign('open',$open); 
		$this->assign('plug',$plug_ver);
		$this->assign('config',$config['site']);
    }

    public function index()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? 100 : $param['limit'];
        $where = [];
		$collect = [];
        $order = 'collect_id desc';
        $res = model('Collect')->listData($where, $order, $param['page'], $param['limit']);
		foreach($res['list'] as $key=>$v){
			$collect[]=array(
			    'id' => $v['collect_id'],
                'flag' => md5($v['collect_url']),
                'name' => $v['collect_name'],
                'apis' => $v['collect_url'],
                'tips' => '<span class="layui-badge layui-bg-green">自定义</span>',
				'type' => $v['collect_type'], 
                'mid' => $v['collect_mid'], 
                'param' => $v['collect_param'],				
                'filter' => $v['collect_filter']?$v['collect_filter']:'', 
				'filter_from' => $v['collect_filter_from']?$v['collect_filter_from']:'', 
				'opt' => $v['collect_opt']?$v['collect_opt']:'',
			);
		}		
	    $data_arr['collect'] = array(
	        'head'=>'自定义资源站',
		    'tips'=>'这里是整合的苹果cms程序自定义的采集，<font color="red">自定义的资源站没有播放配置</font>',
		    'rows'=> $collect		
	    );		
		$datainfo = json_encode($data_arr,true);
		$html = "var collect = ".$datainfo.";";
		if(count($collect)>0){
			return $html;
		}else{
			return 'var collect = [];';
		}
    }
	
    public function union()
    {
		$param = input();
		if($param['code']>0){
			$this->assign('param', $param);
			return $this->fetch('admin@collect/qqclose');
		}
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'collect_break_vod';
        $collect_break_vod = Cache::get($key);
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'collect_break_art';
        $collect_break_art = Cache::get($key);
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'collect_break_actor';
        $collect_break_actor = Cache::get($key);
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'collect_break_role';
        $collect_break_role = Cache::get($key);
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'collect_break_website';
        $collect_break_website = Cache::get($key);
		$version = config('version');
        $this->assign('collect_break_vod', $collect_break_vod);
        $this->assign('collect_break_art', $collect_break_art);
        $this->assign('collect_break_actor', $collect_break_actor);
        $this->assign('collect_break_role', $collect_break_role);
        $this->assign('collect_break_website', $collect_break_website);
		$this->assign('today', strtotime(date('Y-m-d')));
		$this->assign('version',$version); 
		$this->assign('admin',$this->_admin); 
        $this->assign('title', '萌芽采集插件');
        return $this->fetch('admin@collect/mycj');
    }

	public function create()
	{
		$param = input();
		$id = $param['id'];
		switch ($id) {
			case 'sea': 
				$apis = $param['apis'];
				$name = $param['name'];
				$type = $param['type'];
				$mid = $param['mid'];
				if($mid>1){
					$data = [];
				}else{
					if($type==1){ 
						$data = $this->SearchXml($apis,$name);
					}else{
						$data = $this->SearchJson();
					}
				}
				return json($data);
			break;	
			case 'player': 
				$this->add_player($param);
			break;	
			case 'all_player': 
				$this->all_player($param);
			break;			
			case 'login': 
				$this->login();
			break;
			case 'faves': 
				$this->Add_faves($param);			
			case 'del_faves': 
				$this->del_faves($param);
			break;			
			case 'filter': 
				$this->filter();
			break;
			case 'open': 
				$this->open();
			break;	
			case 'delplayer': 
				$this->delplayer();
			break;	
			case 'update': 
				$this->step1($param['file']);
			break;	
			
			default:
				return $this->error('参数错误');
			break;
		}
	}
	

	public function filter()
	{
		$param = input();
		$faves = config('mycjfaves');
		if (Request()->isPost()) {
			$faves[$param['ids']]['opt'] = $param['collect_opt'];
			$faves[$param['ids']]['filter'] = $param['collect_filter'];
			$faves[$param['ids']]['filter_from'] = $param['collect_filter_from'];
			$res = mac_arr2file( APP_PATH .'extra/mycjfaves.php', $faves);
			if($res===false){
				return $this->error('保存失败！请检查文件写入权限！');
			}
			return $this->success('保存成功！');
		}
		$this->assign('faves',$faves[$param['ids']]);
		$this->assign('param',$param);
		$this->assign('title', '数据过滤配置');
        return $this->fetch('admin@collect/filter');		
	}

	public function delplayer()
	{
		$version = config('version');
		if (Request()->isPost()) {
            $param = input('post.');
			if($version['code']>='2020.1000.1042'){
				$validate = \think\Loader::validate('Token');
				if(!$validate->check($param)){
					return $this->error($validate->getError());
				}
			}
			$list = [];
			$res = mac_arr2file( APP_PATH .'extra/vodplayer.php', $list);
            if($res===false){
                return $this->error('清空删除失败！请检查文件写入权限！');
            }
			return $this->success('初始化成功');
        }
		
	}	
	
	public function login()
	{
		$param = input();
		unset($param['id']);
		$list = $this->cjuser;
		$list['login'] = $param;
		$res = mac_arr2file( APP_PATH .'extra/mycjuser.php', $list);
        if($res===false){
            return $this->error('登录写入记录失败！请检查文件写入权限！');
        }
        return $this->success('登录信息记录成功');
	}

	public function open()
	{
		$param = input();
		unset($param['id']);
		$list = $this->cjuser;
		$list['open'][$param['type']] = time();
		$res = mac_arr2file( APP_PATH .'extra/mycjuser.php', $list);
        if($res===false){
            return $this->error('写入记录失败！请检查文件写入权限！');
        }
        return $this->success('写入记录成功');
	}	

	public function faves()
	{
		$faves = config('mycjfaves');
		if(count($faves)==0){
			$code = 'var faves = [];';
		}else{
			$data_arr['faves'] = array(
				'head'=>'我的收藏',
				'tips'=>'可将常用的资源站，收藏到这里，如果api无法采集，请取消收藏后，重新收藏！',
				'rows'=>$faves		
			);
			$datainfo = json_encode($data_arr,true);
			$code = 'var faves = '.$datainfo.'';
		}
		return $code;
	}

	public function set_player()
	{
		$param = input();
		$name = $param['name'];
		$type = $param['type'];
		$flag = $param['flag'];
		$apis = $param['apis'];
		$list = config('vodplayer');
		if(strpos($flag,'|') !== false){ 
			$flag = explode("|",$flag);
			foreach($flag as $v){
				$from1 = explode(",",$v);
				$flags[] = $from1;
			}	
			foreach($flags as $v2){
				$show = $v2[0];
				$playfrom = $v2[1];
				$sort = $v2[2];
				if(is_array($list[$playfrom])){
					$info[] = $list[$playfrom];
				}else{
					$info[] = array(
						'from' => $playfrom,
						'show' => $show,
						'sort' => $sort,
						'id' => $playfrom,
					);
				}
			}
		}else{
			$flag = explode(",",$flag);
			if(is_array($list[$flag[1]])){
				$info[] = $list[$flag[1]];
			}else{
				$info[] = array(
					'from' => $flag[1],
					'show' => $flag[0],
					'sort' => $flag[2],
					'id' => $flag[1],		
				);
			}
		}
		foreach($info as $k=>$v3){
			if($v3['ps']>0){
				$info[$k]['parse'] = $v3['parse'];
			}else{
				$file = './static/player/'.$v3['from'].'.js';
				if(file_exists($file)){
					$jxtxt = file_get_contents($file);
					preg_match('/src="(.*)=/iU', $jxtxt, $api);
					if($api[1]){
						$jxapi = $api[1].'=';
						if(strpos($api[1],'MacPlayer') !==false){
							$jxapi = '';
						}
						if(strpos($jxtxt,'<embed') !==false){
							$jxapi = $apis;
						}
					}else{
						$jxapi = $apis;
					}
				}else{
					$jxapi = $apis;
				}
				$info[$k]['parse'] = $jxapi;
			}
		}
		
        $this->assign('info',$info);
		$this->assign('type',$type);
		$this->assign('title', '播放器配置');
        return $this->fetch('admin@collect/player');
	}
	
	public function allplayer()
	{
		$list = config('vodplayer');
        $this->assign('list',$list);
		$this->assign('title', '批量修改播放器');
        return $this->fetch('admin@collect/allplayer');
	}
	
	public function picslide()
	{
		$this->assign('title', '视频幻灯图片');
        return $this->fetch('admin@collect/picslide');
	}	
	
	public function SearchXml($apis,$name)
	{	
		$data = [];
		$html = mac_curl_get($apis."?wd=".$name);
		if(!empty($html)){ 
			$xml = simplexml_load_string($html, 'SimpleXMLElement', LIBXML_NOCDATA); 
			if(!empty($xml)){
				$xml = json_decode(json_encode($xml),true); 
				$recordcount = $xml['list']['@attributes']['recordcount']; 
				if($recordcount == 1){
					$data =  array($xml['list']['video']); 
				}else if($recordcount == 0){
					
				}else{
					$data = $xml['list']['video'];
				}
			}
		}
		if(count($data)>0){
			foreach($data as $key=>$v){
				$data[$key]['name'] = strip_tags($v['name']);
				$data[$key]['type'] = strip_tags($v['type']);
				$data[$key]['dt'] = strip_tags($v['dt']);
				$data[$key]['note'] = strip_tags($v['note']);
			}			
		}
		return $data;	
	}

	public function SearchJson()
	{
		$param = input();
		$url = $param['apis'];
		if(strpos($url,'?')===false){
            $url .='?';
        }else{
            $url .='&';
        }
		$url_param['wd'] = $param['name'];
		$url_param['type'] = $param['type'];
		$url .= http_build_query($url_param);
		$data = [];
		$html = mac_curl_get($url);
		if(empty($html)){
			return $data;
		}
		$json = json_decode($html,true);
        if(!$json){
            return $data;
        }
		foreach($json['list'] as $key=>$v){
			$data[] = array(
				'dt'=> strip_tags($v['vod_play_from']),
				'id'=> $v['vod_id'],
				'last'=> $v['vod_time'],
				'name'=> strip_tags($v['vod_name']),
				'note'=> strip_tags($v['vod_remarks']),
				'tid'=> $v['type_id'],
				'type'=> strip_tags($v['type_name']),
			);
		}
		return $data;
	}

	public function Add_faves($param)
	{
		$list = config('mycjfaves');
		unset($param['id']);
		$param['filter'] = '0';
		$param['filter_from'] = '';
		$param['opt'] = '0';
		$param['tips'] = '<span class="layui-badge layui-bg-green">我的收藏</span>';
		$list[] = $param;
        $res = mac_arr2file( APP_PATH .'extra/mycjfaves.php', $list);
        if($res===false){
            return $this->error('收藏失败！请检查文件写入权限！');
        }
        return $this->success('收藏成功');		
	}
	
    public function del_faves($param)
    {
        $list = config('mycjfaves');
        unset($list[$param['ids']]);
		$num = count($list);
		if($num==0){
			$faves = array();
		}else{
			foreach($list as $v){
				$faves[] = $v;
			}
			array_values($faves);		
		}
		$list = $faves;
        $res = mac_arr2file(APP_PATH. 'extra/mycjfaves.php', $list);
        if($res===false){
            return $this->error('删除收藏失败，请检查文件读写权限');
        }
        return $this->success('删除成功');
    }	

	public function all_player($param)
	{
		$param = input();
		$list = config('vodplayer');
        if (Request()->isPost()) {
			$ids = $param['ids'];
			$link =  $param['link'];
			$ps = $param['ps'];
			$src = $ps ? "".$link."'+MacPlayer.PlayUrl+'" : "".$link."";
			$code = "MacPlayer.Html='<iframe width=\"100%\" height=\"'+MacPlayer.Height+'\" src=\"".$src."\" frameborder=\"0\" allowfullscreen=\"true\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\"></iframe>';MacPlayer.Show();";	
			foreach($ids as $id){
				$list[$id]['ps'] = $ps;
				$list[$id]['parse'] = $ps ? $link : '';	
				$res = fwrite(fopen('./static/player/' . $id.'.js','wb'),$code);
			}
			if(!file_exists('./static/player/parse.js') && $ps==1){
				$parse_code = "MacPlayer.Html='<iframe width=\"100%\" height=\"'+MacPlayer.Height+'\" src=\"'+MacPlayer.Parse+MacPlayer.PlayUrl+'\" frameborder=\"0\" allowfullscreen=\"true\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\"></iframe>';MacPlayer.Show();"; 
				$parsejs = fwrite(fopen('./static/player/parse.js','wb'),$parse_code);
			}			
            $res = mac_arr2file( APP_PATH .'extra/vodplayer.php', $list);
            if($res===false){
                return $this->error('修改失败！请检查文件写入权限！');
            }
            return $this->success('批量修改成功');		
        }
		return $this->error('参数错误！');	
	}

	public function add_player()
	{
		$param = input();
		$list = config('vodplayer');
		if (Request()->isPost()) {
			$count = count($param['show']);
			for($i=0; $i<$count; $i++){
				if(strpos($param['link'][$i],'/static/player/') !==false){
					$ps = 0;
					$parse = '';
					$src = $param['link'][$i];
				}else{
					$ps = 1;
					$parse = $param['link'][$i]; 
					$src = $parse."'+MacPlayer.PlayUrl+'";
					if($param['link'][$i]==''){ 
						$ps = 0; 
						$parse = ''; 
						$src = "'+MacPlayer.PlayUrl+'";
					}
				}
				$code = "MacPlayer.Html='<iframe width=\"100%\" height=\"'+MacPlayer.Height+'\" src=\"".$src."\" frameborder=\"0\" allowfullscreen=\"true\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\"></iframe>';MacPlayer.Show();";
				fwrite(fopen('./static/player/' . $param['from'][$i].'.js','wb'),$code);
				$player[] = array(
					$param['from'][$i] => array(
						'status' => '1',
						'from' => $param['from'][$i],
						'show' => $param['show'][$i],
						'des' => '支持手机电脑在线播放',
						'target' => '_self',
						'ps' => $ps,
						'parse' => $parse,
						'sort' => $param['sort'][$i],
						'tip' => '无需安装任何插件',
						'id' => $param['from'][$i],
					)	
				);
			}
			if(!file_exists('./static/player/parse.js')){
				$parse_code = "MacPlayer.Html='<iframe width=\"100%\" height=\"'+MacPlayer.Height+'\" src=\"'+MacPlayer.Parse+MacPlayer.PlayUrl+'\" frameborder=\"0\" allowfullscreen=\"true\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\"></iframe>';MacPlayer.Show();"; 
				fwrite(fopen('./static/player/parse.js','wb'),$parse_code);
			}
			foreach($player as $data){
				$list = array_merge($list,$data);
			}
			$sort=[];
            foreach ($list as $k=>&$v){
                $sort[] = $v['sort'];
            }
            array_multisort($sort, SORT_DESC, SORT_FLAG_CASE , $list);
			$res = mac_arr2file( APP_PATH .'extra/vodplayer.php', $list);
			if($res===false){
                return $this->error('保存失败');
            }
			return $this->success('保存成功');
		}
	}
	public function step1($file='')
    {
        if(empty($file)){
            return $this->error('参数错误');
        }
        $version = config('mycjversion.code');
        $url = $file . '.zip?t='.time();

        echo $this->fetch('admin@public/head');
        echo "<div class='update'><h1>在线升级中,请稍后......</h1><textarea rows=\"10\" class='layui-textarea' readonly>正在下载升级文件包...\n";
        ob_flush();flush();
        sleep(1);

        $save_file = $version.'.zip';
		
        $html = mac_curl_get($url);
        @fwrite(@fopen($this->_save_path.$save_file,'wb'),$html);
        if(!is_file($this->_save_path.$save_file)){
            echo "下载升级包失败，请重试...\n";
            exit;
        }

        if(filesize($this->_save_path.$save_file) <1){
            @unlink($this->_save_path.$save_file);
            echo "下载升级包失败，请重试...\n";
            exit;
        }

        echo "下载升级包完毕...\n";
        echo "正在处理升级包的文件...\n";
        ob_flush();flush();
        sleep(1);

        $archive = new PclZip();
        $archive->PclZip($this->_save_path.$save_file);
        if(!$archive->extract(PCLZIP_OPT_PATH, '', PCLZIP_OPT_REPLACE_NEWER)) {
            echo $archive->error_string."\n";
            echo '升级失败，请检查系统目录及文件权限！' ."\n";;
            exit;
        }
        @unlink($this->_save_path.$save_file);
		$this->_cache_clear();
		echo "更新数据缓存文件...\n";
		echo "恭喜您，插件升级完毕...";
		ob_flush();flush();
        echo '</textarea></div>';
		echo '<script type="text/javascript">layui.use(["jquery","layer"],function(){var layer=layui.layer,$=layui.jquery;setTimeout(function(){var index=parent.layer.getFrameIndex(window.name);parent.location.reload();parent.layer.close(index)},"2000")});</script>';
    }
}