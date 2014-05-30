<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
require_once 'Myclass.php'; //使用smarty类
include_once 'title.php';
include './include/config.php';
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
$sql = "select * from ".$tbprefix."reply where id_1='$_GET[id]'";
   $result = mysql_query($sql);
   while($rs=mysql_fetch_array($result)){
   	$reply[]=array('name_1'=>$rs['name'],'time_1'=>$rs['time'],'counner_1'=>$rs['counner']);
  }
$smarty->assign("reply",$reply);
@session_start();
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('moreback.html'); //调用模板
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('moreback_1.html'); //调用模板
		}
?>