<?php
/*##################################################
# 模块功能：保存功能配置
###################################################*/
 require_once('class.db.php');
 session_start(); 
 if(isset($_SESSION['lock_config'])){ $time=(int)$_SESSION['lock_config']-(int)time(); if($time>0){ exit(json_encode(array('success'=>0,'icon'=>5,'msg'=>"请勿频繁提交，".$time."秒后再试！")));}}
 $_SESSION['lock_config']= time()+ $from_timeout;

//播放器基本设置；
if(filter_has_var(INPUT_POST, "player_logo_url")){
 
	$player['ads']['status'] = filter_input(INPUT_POST, "player_ads_status");
	$player['ads']['vip'] = filter_input(INPUT_POST, "player_ads_vip");
	$player['ads']['group'] = filter_input(INPUT_POST, "player_ads_group");
	$player['pre']['status'] = filter_input(INPUT_POST, "player_pre_status");
	$player['pre']['url'] = trim(filter_input(INPUT_POST, "player_pre_url"));	
	$player['logo']['status'] = filter_input(INPUT_POST, "player_logo_status");
	$player['logo']['url'] = trim(filter_input(INPUT_POST, "player_logo_url"));
	$player['copyright']['status'] = filter_input(INPUT_POST, "player_copyright_status");
	$player['copyright']['content'] = trim(filter_input(INPUT_POST, "player_copyright_content"));
	$player['copyright']['url'] = trim(filter_input(INPUT_POST, "player_copyright_url"));
	$player['dp']['auto'] = filter_input(INPUT_POST, "player_dp_auto");
	$player['dp']['last'] = filter_input(INPUT_POST, "player_dp_last");
	$player['dp']['next'] = filter_input(INPUT_POST, "player_dp_next");
	$player['dp']['h5'] = filter_input(INPUT_POST, "player_dp_h5");
 
	$pre['ads']['status'] = filter_input(INPUT_POST, "pre_ads_status");
	$pre['ads']['time'] = filter_input(INPUT_POST, "pre_ads_time");
	$pre['ads']['button'] = filter_input(INPUT_POST, "pre_ads_button");
	$pre['ads']['auth'] = filter_input(INPUT_POST, "pre_ads_auth");
	$pre['ads']['group'] = filter_input(INPUT_POST, "pre_ads_group");
	$pre['pic']['status'] = filter_input(INPUT_POST, "pre_pic_status");
	$pre['pic']['img'] = trim(filter_input(INPUT_POST, "pre_pic_img"));
	$pre['pic']['link'] = filter_input(INPUT_POST, "pre_pic_link");
	$pre['pic']['width'] = filter_input(INPUT_POST, "pre_pic_width");	
	$pre['pic']['height'] = filter_input(INPUT_POST, "pre_pic_height");	
	$pre['vod']['status'] = filter_input(INPUT_POST, "pre_vod_status");
	$pre['vod']['url'] = filter_input(INPUT_POST, "pre_vod_url");
	$pre['vod']['link'] = filter_input(INPUT_POST, "pre_vod_link");

	$pause['status'] = filter_input(INPUT_POST, "pause_status");
	$pause['pic'] = filter_input(INPUT_POST, "pause_pic");
	$pause['width'] = filter_input(INPUT_POST, "pause_width");
	$pause['height'] = filter_input(INPUT_POST, "pause_height");
	$pause['link'] = filter_input(INPUT_POST, "pause_link");

}

if( Main_db::save()){
	exit(json_encode(array('success'=>1,'icon'=>1,'msg'=>"保存成功!")));
}else{
	exit(json_encode(array('success'=>0,'icon'=>0,'msg'=>"保存失败!请检测配置文件权限")));
} 

?>