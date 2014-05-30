<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
include './include/config.php';
require_once 'Myclass.php'; //使用smarty类
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
$sql="select * from ".$tbprefix."title";
$result=mysql_query($sql);
while($rs=mysql_fetch_array($result)){
	$smarty->assign("title",$rs['title']);
	$smarty->assign("description",$rs['description']);
	$smarty->assign("keywords",$rs['keywords']);
	$smarty->assign("author",$rs['author']);
	$onpage=$rs['page'];
}
?>
