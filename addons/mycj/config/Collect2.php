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

class Collect2 extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? 100 : $param['limit'];
        $where = [];
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

}
