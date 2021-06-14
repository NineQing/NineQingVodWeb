<?php 
if(!@$_SERVER['HTTP_REFERER']||!$_COOKIE["admin_name"]) header('location:/');
if(file_exists('create.php') || file_exists('close.php')){
	exit('您已安装插件，无需重复安装，若您需要重新安装，请删除插件文件夹，重新上传插件文件，从初始状态开始安装');
}
$my = @require('../../application/extra/maccms.php');
if($my['site']['install_dir']!='/'){
	echo '<h1 style="color:red">请勿将你的苹果cms程序安装在二级目录，请检查“系统”->“网站参数配置”->“安装目录”</h1>';die;
}
$js_path = '../../static/layui/layui.js';
if(!file_exists($js_path)){
	echo '<h1 style="color:red"><a href="/static/layui/layui.js">/static/layui/layui.js</a> 这个文件地址不存在，请你检查！</h1>';die;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>插件安装 - 萌芽采集插件</title>
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $my['site']['install_dir']; ?>static/layui/css/layui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $my['site']['install_dir']; ?>static/css/admin_style.css">
<link rel="stylesheet" href="<?php echo $my['site']['install_dir']; ?>static/css/install.css">
<script type="text/javascript">var my = {'name':'<?php echo $_COOKIE["admin_name"];?>',mac_version:'v10'};</script>
<script src="<?php echo $my['site']['install_dir']; ?>static/js/jquery.js?v=<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $my['site']['install_dir']; ?>static/layui/layui.js?v=<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="header">
    <h1>感谢您选择『萌芽多功能综合采集插件』苹果CMS-V10版</h1>
</div>
<div class="install-box">
    <fieldset class="layui-elem-field site-demo-button">
        <legend>采集插件用户使用须知</legend>
        <div class="protocol">
            <p>
                本插件由萌芽模板网（www.vrecf.com）收集整理制作，请认准官方地址 www.vrecf.com <br /><br />
                一、插件介绍： <br /> <br />
                本插件分为 <b>免费版</b> 和 <b>付费版</b>，免费版和付费版能采集到的资源都是一样的；区别在于<b style="color:#FF5722">付费版可使用自定义播放配置、一键定时任务、一键搜索最新资源、批量修改播放器、视频断点采集、采集交流群等 </b><br /><br />
                二、重要声明：  <br /> <br />
				<b style="color:red">1、本插件仅作为资源站导航插件，插件不存储任何视频链接和数据，所有数据均由资源站提供，我们插件提供的仅仅是资源站的收集整理与维护
				 </b><br /> <br />
				2、本插件不提供无广告解析接口或者播放器，无广告解析接口需要自己准备或者购买播放器源码安装<br /> <br />
				3、本插件基于 苹果cms-V10程序 制作，所有功能程序原装就有，本插件只是更加方便的使用程序功能！<br /> <br />
				4、因为采集数据造成的侵权问题、域名红名、网页劫持跳转等问题，与本插件无关！<br /> <br />
                <strong>插件版权所有 (c) 2018-2020，萌芽模板网（www.vrecf.com）,保留所有权利</strong>。
            </p>
        </div>
    </fieldset>
    <div class="step-btns">
	<form class="layui-form" action="">
		<input id="btnReg" class="layui-btn layui-btn-disabled" disabled type="button" lay-submit lay-filter="insatll" value="我已了解并安装插件" />
	</form>	
    </div>
</div>
<script src="https://caiji-api.oss-cn-shanghai.aliyuncs.com/V10/update.js?v=<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
<script>
layui.use('form', function(){
  var form = layui.form;
  form.on('submit(insatll)', function(data){
	update.install();
    return false;
  });
});
</script>

<script type="text/javascript">
var s=30;
function countsub()
{
 var btnReg=document.getElementById("btnReg");
 if(btnReg)
 {
 if(s<=0)
 {
  btnReg.value="我已了解并安装插件";
  btnReg.disabled=false;
  $("input").removeClass("layui-btn-disabled");
  $("input").addClass("layui-btn-normal");
  clearInterval(id);
 }
 else
 {
  btnReg.value="请仔细阅读用户须知(还剩"+s+"秒)";
  s--;
 }
 }
}
var id = setInterval('countsub()',500);
</script>
</body>
</html>
