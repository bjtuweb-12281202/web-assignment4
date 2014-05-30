<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
$sessionname=$_SESSION['name_1'];
include './include/config.php';
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
$sql = "select * from ".$tbprefix."user where name='$sessionname'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$id=$row->id;
$sql = "select * from ".$tbprefix."reply where id='$_GET[id]'";
$result=mysql_query($sql);
while($rs=mysql_fetch_array($result)){
  	 $myquery[]=array('id'=>$rs['id'],'title'=>$rs['title'],'name'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['content']);
	if(($rs['name'] != $sessionname) && ($id != 1)){
		echo"<script language='javascript'> alert('权限不够');history.back();</script>";
		exit();
	}
}
$sql = "delete from ".$tbprefix."reply where id='$_GET[id]'";
mysql_query($sql);
mysql_close();
echo"<script language='javascript'> alert('成功删除');location.href='index.php';</script>";
?>