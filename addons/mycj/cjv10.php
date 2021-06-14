<?php 
/**
 *  『萌芽模板网』多功能综合资源采集插件
 * 
 * 官方网站    www.vrecf.com
 * @author     萌芽<209910539@qq.com>
 * @version    v10.3.1
 * @time       2019.12.28
 * @说明	   请勿擅自修改文件内容，否则可能无法正常使用！
 */
header("Content-Type: text/html;charset=utf-8");
$my = @require('../../application/extra/maccms.php');
$mac_ver = @require('../../application/extra/version.php'); 
$path = $my['site']['install_dir'];
$unionfile = '../../application/admin/view/collect/union.html';
$union = './config/union.html';
if(!@$_SERVER['HTTP_REFERER']||!$_COOKIE["admin_name"]) header('location:/');
@copy($union,$unionfile);
if(empty($path) || !$mac_ver){
	echo show_tips('苹果cmsV10主程序文件缺失','请检测苹果cms主程序文件，或者重新安装主程序<br><a href="https://github.com/magicblack/maccms10" target="_blank">点此下载新版程序</a>');
	die;	
}
if (strpos($_SERVER['HTTP_REFERER'], 'load.html?flag=vod')) {
	echo show_tips('未检测到断点数据','程序中没有断点记录，无法执行断点采集！<br>如果你清理过程序缓存，也会将断点记录清除掉！');
	die;	
}
if (!is_writable('./')) {
  echo show_tips('/addons/mycj/ 没有写入权限','请开放mycj文件夹的读取写入权限');
  die;
} 
if(!is_writable('./cache')){
	echo show_tips('文件夹写入权限不足','请调整 mycj/cache/ 文件夹的写入权限');
	die;
}
if(!file_exists('create.php') || !file_exists('set_player.php') || !file_exists('close.php')){
	require('install.php');
    die;
}
if(!file_exists('./cache/data.php') || !file_exists('./cache/faves.php') || !file_exists('./cache/user.txt')){
	echo show_tips('文件缺失','addons/mycj/cache文件夹内缺少文件');
    die;
}
$faves = array();
if(file_exists('./cache/data.php')){
	include './cache/data.php';
}
if(PHP_VERSION< '5.5'){
	echo show_tips('PHP版本不符合插件运行要求，当前PHP版本'.PHP_VERSION.'','推荐使用php7.0以上环境！');
	die;
}
if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stristr($_SERVER['HTTP_USER_AGENT'], 'Trident')){
	echo show_tips('插件不支持在IE内核下使用','请调整浏览器内核，或者使用谷歌浏览器、360浏览器等极速模式');
	die;	
}
$userid = '';
if(file_exists('./cache/user.txt')){
	$userid = file_get_contents('./cache/user.txt'); 
}
$player_path = '../../static/js/player.js';
$playerjs = 0;
if(file_exists($player_path)){
	$player_html = file_get_contents($player_path); 
	if(strpos($player_html,'eval(function') !==false){
		$playerjs = 1;
	}
}
function show_tips($title,$content)
{
	global $path;
	$html = '<title>萌芽采集插件 by www.vrecf.com</title>'; 
	$html .= '<link href="'.$path.'static/layui/css/layui.css" rel="stylesheet" type="text/css" />';
	$html .= '<link href="css/tips.css" rel="stylesheet" type="text/css" />';
	$html .= '<div class="wrapper">';
	$html .= '<div class="main">';
	$html .= '<div class="title">提示信息</div>';   
	$html .= '<div class="content">';
	$html .= '<h3><font color=red>'.$title.'</font></h3>';
	$html .= '<p>'.$content.'</p>';
	$html .= '</div>';
	$html .= '<div class="footer"><a target="_blank" href="http://www.vrecf.com/">萌芽模板网 www.vrecf.com</a>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
$ver = 'v10.3.1';
?>
<!DOCTYPE html>
<html>
<head>
<title>萌芽采集资源VIP版</title>
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $path; ?>static/layui/css/layui.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $path; ?>static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $path; ?>static/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<style>.footer{padding: 30px 0; line-height: 30px; text-align: center; color: #666; font-weight: 300;}
@media screen and (max-width:900px){.sjhide{display: none;}.layui-table td, .layui-table th{padding: 8px 10px;}}
</style>
<script type="text/javascript">var my = {'name':'<?php echo $_COOKIE["admin_name"];?>',mac_version:'v10',mac_ver:'<?php echo $mac_ver["code"];?>',userid:'<?php echo $userid;?>',playerjs:'<?php echo $playerjs;?>'}; var verv10 = '<?php echo $ver;?>';</script>
</head>
<body>
<div class="layui-row">
<ul class="layui-nav layui-bg-green">
  <li class="layui-nav-item">
    <a href="javascript:;" id="step1">常见<b style="color:#e7f70e;">采集问题</b></a>
    <dl class="layui-nav-child cj-help"></dl>	
  </li>
  <li class="layui-nav-item" id="step2">
    <a href="javascript:;">常见<b style="color:#e7f70e;">播放问题</b></a>
    <dl class="layui-nav-child play-help"></dl>	
  </li> 
  <li class="layui-nav-item addzyz">
    <a href="javascript:;" target="_blank"><i class="layui-icon">&#xe641;</i>资源站分享</a>
  </li>   
  <li class="layui-nav-item" id="mycjv10">
	 <a href="javascript:;"><span id="is_vip">免费版</span> <span style="color: #e7f70e;font-weight: bold;"><?php echo $ver;?></span></a>
  </li> 
  <li class="layui-nav-item">
    <a href="javascript:;" class="update">检测更新</a>
  </li>  
  <li class="layui-nav-item" id="user">
    <a href="javascript:userLogin();" class="login"><i class="layui-icon">&#xe612;</i><span >登陆</span></a>
  </li> 
</ul>
</div>
<form class="layui-form">
	<div class="layui-tab">	
		<div class="layui-btn-group">
			<p class="layui-btn layui-bg-red duandian"><i class="layui-icon">&#xe631;</i>视频断点采集</p>
			<p class="layui-btn layui-btn-normal alljx"><i class="layui-icon">&#xe620;</i>播放器批量设置</p>
			<p class="layui-btn pic-slide"><i class="layui-icon">&#xe64a;</i>视频幻灯图</p>	
		</div>
		<div class="layui-input-inline" style="width:130px">
			<select name="collect" lay-verify="required">
				<?php if(count($faves)>0){echo '<option value="faves" selected>我的收藏专区</option>'.chr(10);}?>
				<option value="m3u8">切片资源专区</option>
				<option value="yun">云播资源专区</option>
				<option value="zonghe">综合资源专区</option>	
				<option value="offi">视频独立采集</option>				
				<option value="fuck">叉站资源专区</option>		
			</select>
		</div>	
		<div class="layui-input-inline searchwd" style="width:130px">
			<input type="text" required lay-verify="required" placeholder="请输入关键字" autocomplete="off" class="layui-input layui-input-search">
		</div>
		<div class="layui-input-inline">
			<button type="button" class="layui-btn searchs">立即搜索</button>
			<input type="text" required lay-verify="required" placeholder="搜索间隔" autocomplete="off" class="layui-input interval" value="3" style="width:38px;display:inline-block">
			<span>秒间隔</span>
		</div>		
	</div>
</form>
<div class="layui-tab layui-collect"></div>
<script src="./js/core.js"></script>
<script src="./js/enc-base64.js"></script>
<script src="./js/cipher-core.js"></script>
<script src="./js/aes.js"></script>
<script src="./js/md5.js"></script>
<script src="./js/md5.min.js"></script>
<script src="./js/main.min.js"></script>
<script src='./js/myad.js'></script>
<?php if(count($faves)>0){echo '<script type="text/javascript" src="./cache/faves.php?v='.time().'"></script>'.chr(10);}?>
<script src='https://caiji-api.oss-accelerate.aliyuncs.com/V10/data.js?v=<?php echo date('Hi'); ?>'></script>
<script src='./js/mycj.min.js'></script>
<script src="./js/mycjv10.js"></script>
</body>
</html>
