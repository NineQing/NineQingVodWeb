<?php  
require ('main.class.php');
$userid = @$_GET["id"];
if($userid){
	$user = mac_write_file('./cache/user.txt',$userid);
	if($user===false){
		$tips = '/addons/mycj/cache/user.txt 的写入权限不足，请开放写入权限，否则无法使用VIP版功能';
		echo '<script type="text/javascript">parent.parent.layer.alert("'.$tips.'");</script> ';
		exit;
	}
}
?>
<html>  
 <head>  
  <meta http-equiv="content-type" content="text/html; charset=utf-8">  
  <title> exec main function </title>  
 </head>  
 <body>  
    <script type="text/javascript"> 
	var userid = '<?php echo $_GET["id"];?>';
    var id = userid ? userid : '';
    parent.parent.LoginClose(id);
    </script> 
 </body>  
</html>  
