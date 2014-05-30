<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
$admin_pass=$_POST['admin_pass'];
$password_1=$_POST['password'];
$admin_pass2=$_POST['admin_pass2'];
@session_start();
$name=$_SESSION['name_1'];
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	include './include/config.php';
	include_once 'title.php';
	$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
	mysql_query("SET NAMES'gb2312'",$link);
	mysql_select_db("$dbname")or die(不能连接数据库！);
	$sql = "select * from ".$tbprefix."user where name='$name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	$id=$row->id;
	if($id != 1){
		$set="";
	}else {$set='<li><a href="admin_set.php">系统参数设置</a>';}
	$sql = "select * from ".$tbprefix."user";
	$result=mysql_query($sql);
	$rs=mysql_fetch_object($result);
	$password=$rs->password;
	$smarty->assign("name",$name);
	$smarty->assign("set",$set);
	if($_POST[tj]){
		if($password_1 != $admin_pass2){
			echo"<script language='javascript'> alert('密码确认错误');history.back();</script>";
		}else if($password == $admin_pass){
			$exec="update ".$tbprefix."user set password='".$password_1."' where name='".$name."'";
	  		$result=mysql_query($exec);
	  		echo"<script language='javascript'> alert('修改成功');history.back();</script>";
		}echo"<script language='javascript'> alert('请正确输入原始密码');history.back();</script>";
	}
$smarty->display('admin_mp.html'); //调用front.html模板
} else {
	 $_SESSION['name'] = false;
	}
?>
