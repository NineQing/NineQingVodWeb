<?php 
header("Content-Type: text/html;charset=utf-8");
$my = @require('../../application/extra/maccms.php');
$list = require ('../../application/extra/vodplayer.php');
$userid = '';
if(file_exists('./cache/user.txt')){
	$userid = file_get_contents('./cache/user.txt'); 
}
?>
<!DOCTYPE html>
<html>
<head>
<title>萌芽采集资源VIP版 - 一键替换本地播放器</title>
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $my['site']['install_dir'];?>static/layui/css/layui.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $my['site']['install_dir'];?>static/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $my['site']['install_dir'];?>static/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<style>.p10{padding:10px;}</style>
<script type="text/javascript">var admin_path = parent.parent.ADMIN_PATH; var my = {'name':'<?php echo $_COOKIE["admin_name"];?>',userid:'<?php echo $userid;?>'}; var path = '<?php echo $my['site']['install_dir'];?>';</script>
</head>
<body>
<div class="page-container p10">
    <div class="layui-tab layui-form-item">
	<blockquote class="layui-elem-quote" class="navbar-brand">
	&nbsp;<b>温馨提示：</b>新手不会操作的，请看一遍视频教程>><br>
    </blockquote>
	</div>
    <div class="my-toolbar-box">
        <div class="layui-btn-group">
		    <a class="layui-btn layui-btn-normal all" data-type="dplayer"><i class="layui-icon">&#xe620;</i>安装dplayer播放器</a>
			<a class="layui-btn layui-btn-normal all" data-type="ckplayerx"><i class="layui-icon">&#xe620;</i>安装ckplayerX播放器</a>
			<a class="layui-btn layui-btn-normal all" data-type="videojs"><i class="layui-icon">&#xe620;</i>安装videojs播放器</a>
			<a class="layui-btn layui-btn-normal all" data-type="aliplayer"><i class="layui-icon">&#xe620;</i>安装阿里云播放器</a>
			<a class="layui-btn setplayer" data-type="setplayer"><i class="layui-icon">&#xe620;</i>批量设置自定义接口</a>
        </div>
    </div>
    <form class="layui-form " method="post" id="pageListForm">
        <table class="layui-table">
            <thead>
            <tr>
                <th ><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th >排序</th>
                <th >播放器编码</th>
                <th >播放器名称</th>
                <th >操作</th>
            </tr>
            </thead>
            <?php foreach ($list as $k=>&$v){ ?>
            <tr>
                <td width="50px"><input type="checkbox" name="ids[]" value="<?php echo $v['from']?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td><?php echo $v['sort']?></td>
                <td><?php echo $v['from']?></td>
                <td><?php echo $v['show']?></td>
                <td><script>document.writeln('<a class="layui-badge-rim j-iframe" data-href="'+admin_path+'/admin/vodplayer/info/id/<?php echo $v['from'];?>.html" href="javascript:;" title="编辑">查看 / 编辑</a>');</script></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript" charset="utf-8" src="./js/md5.min.js"></script>
<script type="text/javascript" src="./js/main.min.js"></script>
<script type="text/javascript" src="./js/allplayer.js"></script>
<script src="<?php echo $my['site']['install_dir'];?>static/js/admin_common.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>	
