<?php
/*##################################################

# 模块功能：自定义播放器配置
###################################################*/
error_reporting(0);
header("Content-Type: text/html;charset=utf-8");
if(!@$_SERVER['HTTP_REFERER']||!$_COOKIE["admin_name"]) header('location:/');
$config = './config/config.php';
if (!file_exists($config)) {
	exit('未检测到config.php配置文件,请检查 addons/dplayer/config/config.php 文件是否存在！');
}
require($config);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>dplayer播放器设置 - 影视卿</title>
    <link href="/static/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <script src="/static/layui/layui.js" type="text/javascript" charset="utf-8"></script>
	<script src="/static/js/jquery.js"></script>
	<style>.layui-input-inline textarea{min-width:300px;min-height:150px;}
	.layui-form-item .layui-form-label{min-width:130px;}
	</style>
</head>
<body style="margin:20px 20px">
<style>.showpic {position:absolute; max-width:400px; max-height:500px; text-align:center; line-height:150%; border:2px solid #DEEFFA; padding:5px; background:#FFFFFF;  z-index:99999;}</style>
<div class="showpic" style="display:none;"><img class="showpic_img" width="100%" height="100%"></div>
<form class="layui-form layui-form-pane" action="">
<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">影视卿-dplayer播放器</li>
    <li>基础设置</li>
    <li>前置广告设置</li>
    <li>暂停广告设置</li></ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <blockquote class="layui-elem-quote layui-quote-nm">
        <p>欢迎使用影视卿 整合的苹果cmsV10 Dplayer播放器</p>
      </blockquote>
      <table class="layui-table">
        <colgroup>
          <col width="100">
            <col width="150">
              <col></colgroup>
        <thead>
          <tr>
            <th colspan="2" scope="col">播放器简介</th>
            <th colspan="1" scope="col">使用说明</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>名称</td>
            <td>
              <a href="https://tv.jiuqing97.top/" target="_blank">Dplayer播放器3.0</a></td>
            <td>1. PHP版本≥5.6</td></tr>
          <tr>
            <td>作者</td>
            <td>
              <a href="https://tv.jiuqing97.top/" target="_blank">影视卿</a></td>
            <td>2. 唯一官方网站，其他网站购买到本源码均为二次倒卖！</td></tr>
          <tr>
            <td>官方网站</td>
            <td>
              <a href="https://tv.jiuqing97.top/" target="_blank">https://tv.jiuqing97.top/</a></td>
            <td>3. 不支持IE8及以下浏览器，采用HLS流媒体播放m3u8格式视频，无需flash插件</td></tr>
          <tr>
            <td style="color:red;">使用教程</td>
            <td>
              <a href="" style="color:blue;" target="_blank"></a></td>
            <td>4. 使用盗版源码遇到任何问题本人概不负责</td></tr>
          <tr>
            <td>作者QQ</td>
            <td>1036706612</td>
            <td>5. 唯一官方QQ，购买非官方制作源码，无任何技术支持及售后服务！</td></tr>
          <tr>
            <td>更新时间</td>
            <td>
              <a href="https://tv.jiuqing97.top/" target="_blank">2019-10-15</a></td>
            <td>7. 肆意散播转售或者倒卖，将视为放弃一切技术支持</td></tr>
          <tr>
            <td colspan="3" style="color:red;">其他苹果cmsV10程序可调用接口：http://<?php echo $_SERVER['HTTP_HOST'];?>/addons/dplayer/?url=</td></tr>			
          <tr>
            <td colspan="3">请务必尊重知识产权，严格保证不恶意传播产品源码、不得直接对源码进行二次转售或倒卖等。一经发现，我们有权利终止你在我方购买的所有源码的售后技术支持。</td></tr>
        </tbody>
      </table>
    </div>
    <div class="layui-tab-item">
      
        <div class="layui-form-item">
          <label class="layui-form-label">全局广告状态</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_ads_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['ads']['status']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">关闭后，所有广告均不显示</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">会员免广告</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_ads_vip" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['ads']['vip']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">关闭后，所有登陆的会员都要看广告</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">指定会员组</label>
          <div class="layui-input-inline">
            <input type="number" name="player_ads_group" placeholder="请输入会员组ID" value="<?php echo $player['ads']['group']?$player['ads']['group']:'0';?>" autocomplete="off" class="layui-input"></div>
          <div class="layui-form-mid layui-word-aux"><font color="red">升级会员组后，需要退出重新登陆才生效！</font>指定会员组ID免广告</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">播放前预览图</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_pre_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['pre']['status']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">视频播放前的一个预览提示图</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">预览图地址</label>
          <div class="layui-input-inline">
            <input type="text" name="player_pre_url" placeholder="请填写预览图片地址" value="<?php echo $player['pre']['url'];?>" autocomplete="off" class="layui-input upload-input upload-img"></div>
          <div class="layui-input-inline" style="width:100px;">
            <span class="layui-btn layui-upload">上传图片</span></div>
          <div class="layui-form-mid layui-word-aux">填写地址需带http</div></div>		  		  
        <div class="layui-form-item">
          <label class="layui-form-label">播放器logo</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_logo_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['logo']['status']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">播放器右上角logo，建议尺寸193*55</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">logo地址</label>
          <div class="layui-input-inline">
            <input type="text" name="player_logo_url" placeholder="请填写logo图片地址" value="<?php echo $player['logo']['url'];?>" autocomplete="off" class="layui-input upload-img upload-input"></div>
          <div class="layui-input-inline" style="width:100px;">
            <span class="layui-btn layui-upload">上传图片</span></div>
          <div class="layui-form-mid layui-word-aux">填写地址需带http</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">右键版权</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_copyright_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['copyright']['status']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">只支持pc端鼠标右键</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">右键内容</label>
          <div class="layui-input-inline">
            <input type="text" name="player_copyright_content" placeholder="请填写右键显示内容" value="<?php echo $player['copyright']['content'];?>" autocomplete="off" class="layui-input"></div>
          <label class="layui-form-label">内容链接</label>
          <div class="layui-input-inline">
            <input type="text" name="player_copyright_url" placeholder="点击内容后的跳转链接" value="<?php echo $player['copyright']['url'];?>" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">自动播放</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_dp_auto" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['dp']['auto']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">仅在关闭所有广告的情况下才生效，只针对PC端</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">记忆播放</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_dp_last" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['dp']['last']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">只支持pc端，记忆播放位置</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">自动下一集</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_dp_next" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['dp']['next']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">只支持pc端</div></div>
        <div class="layui-form-item">
          <label class="layui-form-label">H5独立播放</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="player_dp_h5" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $player['dp']['h5']?'checked':'';?>></div>
          <div class="layui-form-mid layui-word-aux">h5环境中使用自定义的播放容器，开启后，PC端可展示广告，移动端就不展示广告</div></div>
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="systemsave">保存配置</button></div>
        </div>
    </div>
    <div class="layui-tab-item">
        <div class="layui-form-item">
          <label class="layui-form-label">前置广告状态</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="pre_ads_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $pre['ads']['status']?'checked':'';?>></div>
			<div class="layui-form-mid layui-word-aux">关闭则不显示前置广告</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">广告显示时间</label>
          <div class="layui-input-inline">
            <input type="number" name="pre_ads_time" placeholder="单位（秒）" value="<?php echo $pre['ads']['time'];?>" autocomplete="off" class="layui-input"></div>
			<div class="layui-form-mid layui-word-aux">单位（秒）</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">跳过按钮</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="pre_ads_button" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $pre['ads']['button']?'checked':'';?>></div>
			<div class="layui-form-mid layui-word-aux">只支持图片类型前置广告跳过，视频广告无法跳过</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">跳过限制</label>
          <div class="layui-input-inline">
            <input type="radio" name="pre_ads_auth" value="0" title="不限制" <?php if($pre['ads']['auth']==0){echo 'checked';} ?>>
			<input type="radio" name="pre_ads_auth" value="1" title="注册会员" <?php if($pre['ads']['auth']==1){echo 'checked';} ?>>
			<input type="radio" name="pre_ads_auth" value="2" title="指定会员组" <?php if($pre['ads']['auth']==2){echo 'checked';} ?>>
			<input type="number" name="pre_ads_group" placeholder="请输入指定会员组ID" value="<?php echo $pre['ads']['group'];?>" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">不限制：游客也可以跳过；注册会员：注册登陆就可以跳过；指定会员组：需要指定的会员组才能跳过</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">前置图片广告</label>
          <div class="layui-input-block">
            <input type="checkbox" name="pre_pic_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $pre['pic']['status']?'checked':'';?>></div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">图片广告内容</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_pic_img" placeholder="请输入http广告图片" value="<?php echo $pre['pic']['img'];?>" autocomplete="off" class="layui-input upload-img upload-input"></div>
          <div class="layui-input-inline" style="width:100px;">
            <span class="layui-btn layui-upload">上传图片</span></div>			
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">图片尺寸宽度</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_pic_width" placeholder="请输入数值" autocomplete="off" value="<?php echo $pre['pic']['width'];?>" class="layui-input"></div>
          <label class="layui-form-label">图片尺寸高度</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_pic_height" placeholder="请输入数值" autocomplete="off" value="<?php echo $pre['pic']['height'];?>" class="layui-input"></div>		
			<div class="layui-form-mid layui-word-aux">调整前置图片广告显示的大小，可以留空，留空则自适应播放器大小</div>
        </div>	
        <div class="layui-form-item">
          <label class="layui-form-label">图片广告链接</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_pic_link" placeholder="请输入http跳转链接" autocomplete="off" value="<?php echo $pre['pic']['link'];?>" class="layui-input"></div>
			<div class="layui-form-mid layui-word-aux">点击图片后跳转到哪个地方</div>
        </div>
		
        <div class="layui-form-item">
          <label class="layui-form-label">前置视频广告</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="pre_vod_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $pre['vod']['status']?'checked':'';?>></div>
			<div class="layui-form-mid layui-word-aux">开启后，广告不支持跳过，无论是否会员，都要看视频广告</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">视频广告内容</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_vod_url" placeholder="支持mp4、m3u8格式视频" autocomplete="off" value="<?php echo $pre['vod']['url'];?>" class="layui-input"></div>
			<div class="layui-form-mid layui-word-aux">链接必须带http，视频格式必须是mp4或者m3u8，广告视频有多少秒就播放多少秒，不能跳过</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">视频广告链接</label>
          <div class="layui-input-inline">
            <input type="text" name="pre_vod_link" placeholder="http跳转链接" autocomplete="off" value="<?php echo $pre['vod']['link'];?>" class="layui-input"></div>
			<div class="layui-form-mid layui-word-aux">链接必须带http，点击视频广告跳转的地址</div>
        </div>		
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="systemsave">保存配置</button></div>
        </div>		
    </div>
    <div class="layui-tab-item">
      <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
          <label class="layui-form-label">暂停广告状态</label>
          <div class="layui-input-inline">
            <input type="checkbox" name="pause_status" lay-skin="switch" lay-text="开启|关闭" value="1" <?php echo $pause['status']?'checked':'';?>></div>
			<div class="layui-form-mid layui-word-aux">关闭则不显示暂停广告</div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">暂停广告内容</label>
          <div class="layui-input-inline">
            <input type="text" name="pause_pic" placeholder="请输入http链接" value="<?php echo $pause['pic'];?>" autocomplete="off" class="layui-input upload-img upload-input"></div>
          <div class="layui-input-inline" style="width:100px;">
            <span class="layui-btn layui-upload">上传图片</span></div>				
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">图片尺寸宽度</label>
          <div class="layui-input-inline">
            <input type="text" name="pause_width" placeholder="请输入数值" autocomplete="off" value="<?php echo $pause['width'];?>" class="layui-input"></div>
          <label class="layui-form-label">图片尺寸高度</label>
          <div class="layui-input-inline">
            <input type="text" name="pause_height" placeholder="请输入数值" autocomplete="off" value="<?php echo $pause['height'];?>" class="layui-input"></div>		
			<div class="layui-form-mid layui-word-aux">调整暂停图片广告显示的大小，可以留空，留空则自适应播放器大小</div>
        </div>		
        <div class="layui-form-item">
          <label class="layui-form-label">暂停广告链接</label>
          <div class="layui-input-inline">
            <input type="text" name="pause_link" placeholder="请输入http链接" value="<?php echo $pause['link'];?>" autocomplete="off" class="layui-input"></div>
			<div class="layui-form-mid layui-word-aux">点击图片后跳转到哪个地方</div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="systemsave">保存配置</button></div>
        </div>		
    </div>
    <div class="layui-tab-item">内容4</div>
    <div class="layui-tab-item">内容5</div>
	</form>
	</div>
</div>

<script>
layui.use(['layer', 'form', 'table', 'upload', 'element'], function(){
  var layer = layui.layer 
  ,form = layui.form
  ,table = layui.table 
  ,upload = layui.upload
  ,element = layui.element 
  var upload_path = $('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/upload/upload.html?flag=addon';
  var ishttps = 'https:' == document.location.protocol ? 'https://': 'http://';
        upload.render({
            elem: '.layui-upload'
            ,url: upload_path
            ,method: 'post'
            ,before: function(input) {
                layer.msg('文件上传中...', {time:3000000});
            },done: function(res, index, upload) {
                var obj = this.item;
                if (res.code == 0) {
                    layer.msg(res.msg);
                    return false;
                }
                layer.closeAll();
                var input = $(obj).parent().parent().find('.upload-input');
                if ($(obj).attr('lay-type') == 'image') {
                    input.siblings('img').attr('src', res.data.file).show();
                }
                input.val(ishttps+window.location.host+'/'+res.data.file);
            }
        });

  form.on('submit(systemsave)', function(data){
	console.log(JSON.stringify(data.field));
    data.field.player_ads_status = data.field.player_ads_status?data.field.player_ads_status:'0';
	data.field.player_ads_vip = data.field.player_ads_vip?data.field.player_ads_vip:'0';
	data.field.player_pre_status = data.field.player_pre_status?data.field.player_pre_status:'0';
	data.field.player_logo_status = data.field.player_logo_status?data.field.player_logo_status:'0';
	data.field.player_copyright_status = data.field.player_copyright_status?data.field.player_copyright_status:'0';
	data.field.player_dp_auto = data.field.player_dp_auto?data.field.player_dp_auto:'0';
	data.field.player_dp_last = data.field.player_dp_last?data.field.player_dp_last:'0';
	data.field.player_dp_next = data.field.player_dp_next?data.field.player_dp_next:'0';
	data.field.pre_ads_status = data.field.pre_ads_status?data.field.pre_ads_status:'0';
	data.field.pre_ads_button = data.field.pre_ads_button?data.field.pre_ads_button:'0';
	data.field.pre_pic_status = data.field.pre_pic_status?data.field.pre_pic_status:'0';
	data.field.pre_vod_status = data.field.pre_vod_status?data.field.pre_vod_status:'0';
	data.field.pause_status = data.field.pause_status?data.field.pause_status:'0';
    data.field.pause_status = data.field.pause_status?data.field.pause_status:'0';
    $.ajax({
        url: "save.php",
        data: data.field,
        type: "post", 
		dataType: 'json',
        success: function (data) {
			layer.msg(data.msg, {icon: data.icon});
            form.render(); 		
        },
        error: function () {
            layer.alert("保存配置执行异常!", {icon: 5});
        }
    });				  
    return false;	
  });
});

        $('.upload-img').hover(function (e){
            var e = window.event || e;
            var imgsrc = $(this).val();
            if(imgsrc.trim()==""){ return; }
            var left = e.clientX+document.body.scrollLeft+20;
            var top = e.clientY+document.body.scrollTop+20;
            $(".showpic").css({left:left,top:top,display:""});
            $(".showpic_img").attr("src", imgsrc);
        },function (e){
            $(".showpic").css("display","none");
        });
</script>
</body>
</html>