<?php  
require('config.php');//使用时将该行删除，将3至6行解除注释并填入相关内容
//$host="DATABASE HOST";  
//$db_user="DATABASE USERNAME";  
//$db_pass="DATABASE PASSWORD";  
//$db_name="DATABASE NAME";  
$timezone="Asia/Shanghai";  
  
$link=mysqli_connect($host,$db_user,$db_pass);//连接数据库主机  
mysqli_select_db($link,$db_name);//选择数据库  
mysqli_query($link,"SET names UTF8");//设置数据库编码格式  
  
header("Content-Type: text/html; charset=utf-8");//设置头部样式  
date_default_timezone_set($timezone); //北京时间