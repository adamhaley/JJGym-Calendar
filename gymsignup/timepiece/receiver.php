<?php
//MYSQL CONNEX
require('db.php');


$act_name = mysql_real_escape_string($_GET['act_name']);
$act_type = mysql_real_escape_string($_GET['act_type']);
$how_contribute = mysql_real_escape_string($_GET['how_contribute']);
$phone = mysql_real_escape_string($_GET['phone']);
$web_url = mysql_real_escape_string($_GET['web_url']);
$calendar_suggestion = mysql_real_escape_string($_GET['calendar_suggestion']);
	
$sql = sprintf("insert into participants(act_name,act_type,how_contribute,phone,web_url,calendar_suggestion) values('%s','%s','%s','%s','%s','%s')",$act_name,$act_type,$how_contribute,$phone,$web_url,$calendar_suggestion);
// echo $sql;

if(mysql_query($sql)){
	echo 1;
}


?>
