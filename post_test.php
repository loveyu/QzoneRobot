<?php
$fp = fopen("post.txt","a+");
foreach($_POST as $n => $v)
	fwrite($fp,$n.' => '.$v."\r\n");
fclose($fp);
?>