<?php
$path = 'application/data/config/quickmenu.txt';
$mycj = @require ('application/extra/maccms.php');
$info = '萌芽采集资源VIP版,' . $mycj['site']['install_dir'] . 'addons/mycj/cjv10.php';
if (stristr(file_get_contents($path), $info))
    exit('快捷菜单已存在，请刷新页面后，在 后台首页>>快捷菜单 中查找【萌芽采集资源VIP版】菜单');
elseif (file_put_contents($path, chr(13) . chr(10) . $info, FILE_APPEND))
	exit('快捷菜单添加成功，请刷新页面后，在 后台首页>>快捷菜单 中查找【萌芽采集资源VIP版】菜单');
else
    exit('快捷菜单添加失败，请检查文件权限或者查看是否被防火墙拦截');

?>