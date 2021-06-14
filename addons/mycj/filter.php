<?php 
error_reporting(0);
header("Content-Type: text/html;charset=utf-8");
if(!@$_SERVER['HTTP_REFERER']||!$_COOKIE["admin_name"]) header('location:/');
$my = @require('../../application/extra/maccms.php');
$path = $my['site']['install_dir'];
include './cache/data.php';
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>我的收藏 - 数据过滤 - 萌芽采集插件</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link href="<?php echo $path; ?>static/layui/css/layui.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $path; ?>static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div style="padding: 10px;">
    <form class="layui-form layui-form-pane" method="post" action="">
	    <input id="collect_id" name="collect_id" type="hidden" value="<?php echo $id;?>">
        <div class="layui-form-item">
            <label class="layui-form-label">资源名称：</label>
            <div class="layui-input-block  ">
                <input type="text" class="layui-input" value="<?php echo $faves[$id]['name'];?>" placeholder="" id="collect_name" name="collect_name">
            </div>
        </div>	
        <div class="layui-form-item">
            <label class="layui-form-label">数据操作：</label>
            <div class="layui-input-block">
                <input name="collect_opt" type="radio" value="0" title="新增+更新" <?php if($faves[$id]['opt']==0 || empty($faves[$id]['opt'])){echo 'checked';}?>>
                <input name="collect_opt" type="radio" value="1" title="新增" <?php if($faves[$id]['opt']==1){echo 'checked';}?>>
                <input name="collect_opt" type="radio" value="2" title="更新" <?php if($faves[$id]['opt']==2){echo 'checked';}?>>
            </div>
            <div class="layui-form-mid layui-word-aux" style="">提示信息：如果某个资源作为副资源不想新增数据，可以只勾选更新。</div>
        </div>

        <div class="layui-form-item row_filer" >
            <label class="layui-form-label">地址过滤：</label>
            <div class="layui-input-block">
                <input name="collect_filter" type="radio" value="0" title="不过滤" <?php if($faves[$id]['filter']==0 || empty($faves[$id]['filter'])){echo 'checked';}?>>
                <input name="collect_filter" type="radio" value="1" title="新增+更新" <?php if($faves[$id]['filter']==1){echo 'checked';}?>>
                <input name="collect_filter" type="radio" value="2" title="新增" <?php if($faves[$id]['filter']==2){echo 'checked';}?>>
                <input name="collect_filter" type="radio" value="3" title="更新" <?php if($faves[$id]['filter']==3){echo 'checked';}?>>
            </div>
        </div>
        <div class="layui-form-item row_filer">
            <label class="layui-form-label">过滤代码：</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" value="" placeholder="" id="collect_filter_from" name="collect_filter_from">
            </div>
            <div class="layui-form-mid layui-word-aux" style="margin-left:110px; ">过滤提示：多组地址的资源开启白名单后只会入库指定代码的地址。比如 youku,iqiyi</div>
        </div>
        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" data-child="true">保 存</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo $path; ?>static/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script>
layui.define(['element', 'layer', 'form'], function(exports) {
    var $ = layui.jquery,
	element = layui.element, 
	layer = layui.layer, 
	form = layui.form;
    form.on('submit(formSubmit)', function(data) {
        var that = $(this),
            _form = '';
        _form = $(this).parents('form');
        layer.msg('数据提交中...',{time:500000});
        $.ajax({
            type: "POST",
            url: 'create.php?id=filter&name=<?php echo $_COOKIE["admin_name"];?>',
            data: _form.serialize(),
            success: function(res) {
                if (res.code == 200) {
					layer.msg(res.msg,{icon:6,time:800},function() {
						var index = parent.layer.getFrameIndex(window.name); 
						parent.layer.close(index);
						parent.location.reload(); 
					});    
                }else{
					layer.alert(res.msg,{icon:5});	
                }
            }
        });
        return false;
    });	
});
</script>
</body>
</html>