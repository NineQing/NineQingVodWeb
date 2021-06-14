<?php
header('Content-type:text/json'); 
$downurl = $_POST['downurl'];
if(empty($_SERVER['HTTP_REFERER']) || empty($downurl)){
	exit(json_encode(array('code' => 400,'msg'=>'升级失败，请勿从非法页面打开！'),true));
}
if(empty($_COOKIE['admin_name']) || $_COOKIE['admin_name']!==$_GET['name']){
	exit(json_encode(array('code' => 400,'msg'=>'升级失败，您目前是未登陆状态！'),true));
}

$file = httpcopy($downurl);
if($file==false){
	exit(json_encode(array('code' => 201,'msg'=>'升级失败，无法下载升级包文件！请尝试手动下载文件覆盖更新'),true));
}

$zip = new ZipArchive;
if ($zip->open($file) === TRUE) {
  $zip->extractTo('./');
  $zip->close();
  unlink($file);
  echo json_encode(array('code' => 200,'msg'=>'升级成功！如果有问题，请及时反馈！'),true);
} else {
  echo json_encode(array('code' => 201,'msg'=>'升级失败，无法解压缩升级包文件，请尝试手动下载文件覆盖更新！'),true);
}

function httpcopy($url, $file="", $timeout=10) {
  $file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
  $dir = pathinfo($file,PATHINFO_DIRNAME);
  !is_dir($dir) && @mkdir($dir,0755,true);
  $url = str_replace(" ","%20",$url);
 
  if(function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $temp = curl_exec($ch);
    if(@file_put_contents($file, $temp) && !curl_error($ch)) {
      return $file;
    } else {
      return false;
    }
  } else {
    $opts = array(
      "http"=>array(
      "method"=>"GET",
      "header"=>"",
      "timeout"=>$timeout)
    );
    $context = stream_context_create($opts);
    if(@copy($url, $file, $context)) {
      return $file;
    } else {
      return false;
    }
  }
}

?>