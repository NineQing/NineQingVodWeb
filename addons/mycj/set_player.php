<?php
header("Content-Type: text/html;charset=utf-8");
$my = @require('../../application/extra/maccms.php');
$type = @$_GET['type']; 
$apis = @$_GET['apis'];
$name = @$_GET['name'];
$flag = @$_GET['flag'];
$tips = '无需安装任何插件';
$desc = '支持手机电脑在线播放';	
if(!$type || !$apis || !$name || !$flag){
	echo '缺少必要参数';exit;
}

$vod_player = '../../application/extra/vodplayer.php';
$list = require ($vod_player);
if(!is_array($list) || !$list){
	$vodplayer = './config/vodplayer.php';
	copy($vodplayer,$vod_player);
	echo "<script>location.reload();</script>";
	exit();
}
$arr = array();
$flags = array();
if(strpos($flag,'|') !== false){  
	  $flag = explode("|",$flag);
      foreach($flag as $fl){
        $fla = explode(",",$fl);
        $flags[] = $fla;
      }	
	  foreach($flags as $from){
		  $show = $from[0];
		  $playfrom = $from[1];
		  $sort = $from[2];
		  if(!empty($list[''.$playfrom.''])){
			  $arr[] = $list[''.$playfrom.''];              
		  }else{
			  $arr[] = array(
                 'status' => '1',
                 'from' => $playfrom,
                 'show' => $show,
                 'des' => $desc,
                 'ps' => '0',
                 'parse' => '',
                 'sort' => $sort,
                 'tip' => $tips,
                 'id' => $playfrom,
			  );
		  }
	  } 
}else{
    $flag = explode(",",$flag);
    if(!empty($list[''.$flag[1].''])){
		$arr[] = $list[''.$flag[1].'']; 
	}else{
		$arr[] = array(
            'status' => '1',
            'from' => $flag[1],
            'show' => $flag[0],
            'des' => $desc,
            'ps' => '0',
            'parse' => '',
            'sort' => $flag[2],
            'tip' => $tips,
            'id' => $flag[1],		
		);
	}
}	
$userid = '';
if(file_exists('./cache/user.txt')){
	$userid = file_get_contents('./cache/user.txt'); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>播放器配置 - 萌芽采集插件</title>
    <link rel="stylesheet" href="<?=$my['site']['install_dir'];?>static/layui/css/layui.css">
    <link rel="stylesheet" href="<?=$my['site']['install_dir'];?>static/css/admin_style.css">
    <script type="text/javascript" src="<?=$my['site']['install_dir'];?>static/js/jquery.js"></script>
    <script type="text/javascript" src="<?=$my['site']['install_dir'];?>static/layui/layui.js"></script>
	<script type="text/javascript">var admin_path = parent.parent.ADMIN_PATH; var my = {'name':'<?php echo $_COOKIE["admin_name"];?>',userid:'<?php echo $userid;?>'}; var path = '<?php echo $my['site']['install_dir'];?>'; var playertype = '<?php echo $type;?>';</script>
</head>
<body>
<div class="page-container p10">
    <form class="layui-form layui-form-pane">
        <div class="layui-tab">
            <blockquote class="layui-elem-quote layui-quote-nm mt10">
			  <p style="color:red">本插件提供的默认解析接口为：//cdn.zyc888.top/?url=，此接口免费提供，移动端播放会有广告！</p>
              <p class="f-20 text-success">推荐安装本地播放器，如DPlayer、CKplayer等播放器，第三方解析接口可加载广告或者劫持流量。</p>			  
            </blockquote>
            <div class="layui-tab-content">
			    <div class="layui-tab-item layui-show jie-kou">
                    <div class="layui-form-item">
                        <p class="layui-btn layui-btn-sm player" data-type="jiekou">使用默认接口</p>					
				        <p class="layui-btn layui-btn-sm player" data-type="dplayer" play-type="<?=$type?>">使用Dplayer</p>
						<p class="layui-btn layui-btn-sm player" data-type="ckplayerx" play-type="<?=$type?>">使用CkplayerX</p>
						<p class="layui-btn layui-btn-sm player" data-type="videojs" play-type="<?=$type?>">使用Videojs</p>
						<p class="layui-btn layui-btn-sm player" data-type="aliplayer" play-type="<?=$type?>">使用Aliplayer</p>
                    </div>				
					<?php				
					    foreach($arr as $i=>$info){
							$name = $info['show'];
							$play_from = $info['from'];
							if($info['ps']>0){
								$jxapi = $info['parse'];
							}else{
								$file = '../../static/player/'.$info['from'].'.js';
								if(file_exists($file)){
									$jxtxt = file_get_contents($file);
									preg_match('/src="(.*)=/iU', $jxtxt, $api);
									if(empty($api[1])){
										$jxapi = $apis;
									}else{
										$jxapi = $api[1].'=';
										if(strpos($api[1],'MacPlayer') !==false){
											$jxapi = '';
										}
									}
								}else{
									$jxapi = $apis;
								}
							}

				echo '<div class="layui-form-item">
                        <label class="layui-form-label">播放器名称：</label>
                        <div class="layui-input-inline" style="width:100px">
                            <input type="text" class="layui-input" value="'.$name.'" lay-verify="required" placeholder="播放器的名称" name="play[name][]">
                        </div>
                        <label class="layui-form-label">播放器编码：</label>
                        <div class="layui-input-inline" style="width:100px">
                            <input type="text" class="layui-input" value="'.$play_from.'" disabled name="play[from][]">
                        </div>
                    </div>
                    <input type="hidden" value="'.$info['sort'].'" name="play[sort][]">
                    <input type="hidden" value="'.$info['tip'].'" name="play[tip][]">	
                    <input type="hidden" value="'.$info['des'].'" name="play[des][]">				
                    <div class="layui-form-item jie-kou">
                        <label class="layui-form-label">解析接口：</label>
                        <div class="layui-input-inline" id="jiekou">
                            <input type="text" class="layui-input layui-disabled" disabled value="'.$jxapi.'" placeholder="请输入解析接口" id="apis_'.$i.'" name="play[apis][]">
                        </div>
						<div class="layui-form-mid layui-word-aux">接口可以更换，不更换就用默认的</div>
                    </div>';	
						}
					?>		 
              </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn layui-btn-disabled" id="layui-btn-submit" lay-submit="*" lay-filter="formSubmit" data-child="true">网页加载中...</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" charset="utf-8" src="./js/md5.min.js"></script>
<script type="text/javascript" charset="utf-8" src="./js/main.min.js"></script>
<script type="text/javascript" src="./js/set-player.js"></script>
</body>
</html>
