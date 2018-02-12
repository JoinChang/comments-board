<?php  
include_once("connect.php");//连接数据库  
  
$q=mysqli_query($link,"select * from comments order by id desc"); 
while($row=mysqli_fetch_array($q)){  
	$comments[] = array("id"=>$row['id'],"user"=>$row['user'],"comment"=>$row['comment'],"addtime"=>$row['addtime']);  
}  
echo json_encode($comments);