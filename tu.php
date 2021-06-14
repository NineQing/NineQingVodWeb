<?php 
header('Content-type: image/jpeg');
$p=$_GET['a']; 
$pics=file($p); 
for($i=0;$i< count($pics);$i++) 
{ 
echo $pics[$i]; 
} 
?> 