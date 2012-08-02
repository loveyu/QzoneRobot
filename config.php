<?php
/*
	程序定时执行请通过crontab之类程序来运行
*/
$accout=array(
	'B_UID' => '',//QQ号
	'sid' => ''//手机QQ空间登录SID
);
$mysql_account=array(
	'hostname' => 'localhost',//数据库地址
	'username' => 'root',//数据库用户名
	'password' => '',//密码
	'db' => 'shuoshuo',//数据库名
	'dbcharset' => 'utf8',//数据库编码
	'dbrp' => ''//数据库表前缀
);
$app_info=array('name' => 'QZONE四级机器人');//应用程序内容后缀
$time_config=array(//执行时间间隔
	'h'=>0,//小时
	'i'=>29,//分钟
	's'=>0 //秒
);
?>