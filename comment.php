<?php
include_once("connect.php");
$user = htmlspecialchars(addslashes(trim($_POST['user'])));  
$txt = htmlspecialchars(addslashes(trim($_POST['txt']))); 
$rec = $_POST['ip']; 
$url = $_SERVER["HTTP_REFERER"];
$ip = $_SERVER["HTTP_CLIENT_IP"];
$str = str_replace(["http://","https://"],"",$url);
$strdomain = explode("/",$str);
$domain = $strdomain[0];

if(empty($user)){  
    $data = array("code"=>355,"message"=>"昵称不能为空");  
    echo json_encode($data);  
    exit;  
}
if(empty($txt)){  
    $data = array("code"=>356,"message"=>"内容不能为空");  
    echo json_encode($data);  
    exit;  
}

if($rec=="true"&&$domain=="lxns.ml"){
$lengthuser = strlen($user);
$lengthtxt = strlen($txt);
$time = date("Y-m-d H:i:s");  
$query=mysqli_query($link,"insert into comments(user,comment,addtime,domain)values('$user','$txt','$time','$domain')");  
if($query)  {
    $data = array("code" => 1, "message"=>"success","user" => $user , "txt" => $txt);  
    echo json_encode($data);  
}
}