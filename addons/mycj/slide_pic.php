<?php 
header("Content-Type: text/html;charset=utf-8");
$my = @require('../../application/extra/maccms.php');
$path = $my['site']['install_dir'];
$userid = '';
if(file_exists('./cache/user.txt')){
	$userid = file_get_contents('./cache/user.txt'); 
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>视频海报数据列表 BY 萌芽模板网 www.vrecf.com</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link href="<?php echo $path; ?>static/layui/css/layui.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $path; ?>static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">var my = {'name':'<?php echo $_COOKIE["admin_name"];?>',userid:'<?php echo $userid;?>'};</script>
	<style>#Images li{width:49%;margin:0.5% 0.5%;float:left;overflow:hidden}#Images li img{width:100%;height:300px;cursor:pointer}#Images li .operate{display:block;height:40px;width:100%;background:#f4f5f9}#Images li .operate .check{float:left;margin-left:11px;height:18px;padding:11px 0;width:74%;position:relative}#Images li .operate .check .layui-form-checkbox[lay-skin=primary]{width:100%}#Images li .operate .check .layui-form-checkbox[lay-skin=primary] span{padding:0 5px 0 25px;width:100%;box-sizing:border-box}#Images li .operate .check .layui-form-checkbox[lay-skin=primary] i{position:absolute;left:0;top:0}#Images li .operate .layui-copy{float:right;margin:9px 11px 0 0;cursor:pointer}#Images li .operate .layui-copy:hover{color:#f00}@media screen and (max-width:1050px){#Images li{width:49%}#Images li img{width:100%;height:150px;cursor:pointer}}@media screen and (max-width:750px){#Images li{width:49%}#Images li img{width:100%;height:150px;cursor:pointer}}@media screen and (max-width:432px){#Images li{width:99%}#Images li img{width:100%;height:150px;cursor:pointer}}</style>
</head>
<body class="childrenBody">
	<blockquote class="layui-elem-quote news_search">
		<div class="layui-input-inline">
			<input type="text" id="name" lay-verify="required" placeholder="关键词为2个字搜索最精准" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-input-inline">
			<span class="layui-btn search">立即搜索</span>
		</div>	
		<div class="layui-input-inline">
			<span class="layui-btn layui-btn-normal"  onclick="location.reload()">重新加载</span>
		</div>		
	</blockquote>
	<ul class="layer-photos-demo" id="Images"></ul>
<script src="./js/core.js"></script>
<script src="./js/enc-base64.js"></script>
<script src="./js/cipher-core.js"></script>
<script src="./js/aes.js"></script>
<script src="./js/md5.js"></script>
<script src="./js/md5.min.js"></script>
 <script type="text/javascript" charset="utf-8" src="./js/main.min.js"></script>	
<script src="<?php echo $path; ?>static/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="./js/clipboard.min.js" charset="utf-8"></script>
<script type="text/javascript" src="./js/images.js"></script>
</body>
</html>
