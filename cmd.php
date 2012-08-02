<?php
include_once("post.php");
include_once("mysql.php");
include_once("shuoshuo.php");
include_once("time_check.php");
include_once("config.php");
header("content-Type: text/html; charset=utf-8");

$sql=new mysql($mysql_account);
$shuoshuo=new shuoshuo($app_info);
$post_time_check=new time_check($time_config);

$shuoshuo->get_new_shuoshuo();
$post=new Post($accout);
$post->SendPost($shuoshuo->content);
if($post->status){
	echo "post send\n";
	$shuoshuo->flag_shuoshuo();
	$shuoshuo->count_next_shuoshuo();
	echo "OK\n";
}else{
	echo "ERROR\n";
}
echo time(),"\n";
?>