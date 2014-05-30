<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
require_once 'Myclass.php'; //使用smarty类
include_once 'title.php';
include './include/config.php';
@session_start();
$sessionname=$_SESSION['name_1'];
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
  	 $myquery[]=array('id'=>$rs['id'],'title'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['counner']);
	if(($rs['name'] != $sessionname) && ($id != 1)){
		echo"<script language='javascript'> alert('权限不够');history.back();</script>";
		exit();
	}
}
if($_POST[tj]){
	$exec="update ".$tbprefix."reply set counner='".$_POST['post_contents']."' where id='$_GET[id]'";
  $result=mysql_query($exec);
  echo"<script language='javascript'> alert('修改成功');history.back();history.back();</script>";
	}
$smarty->assign("query",$myquery);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('edit.html'); //调用模板
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('edit.html'); //调用模板
		}
?>