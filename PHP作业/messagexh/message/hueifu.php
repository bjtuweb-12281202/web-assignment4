<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
$name=$_SESSION['name_1'];
$code=$_POST['code'];
$neir=addslashes(htmlspecialchars($_POST['neirong']));
if($name==""){
	$name="匿名";
}
if(!empty($neir)){
	$neir=str_replace("　","",$neir);
	$neir=ereg_replace("\n","<br>　　",ereg_replace(" ","&nbsp;",$neir));
}
include_once 'title.php';
include './include/config.php';
$time=date("Y-m-d H:i:s",time());
$time_1=time();
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
if($_POST['reply']){
	if($code  !=  $_SESSION['long']  ||  empty($code)){
		echo"<script language='javascript'> alert('验证码不正确');history.back();</script>";
	}else if(!$name==0 && !$neir==0){
		$ins="insert into ".$tbprefix."reply(id_1,name,counner,time) values('$_GET[id]','$name','$neir','$time')";
		mysql_query($ins);
		$time_2="update ".$tbprefix."guestbook set time_1='$time_1' where id='$_GET[id]'";
		mysql_query($time_2);
		echo"<script language='javascript'> alert('评论成功发表');history.back();history.back();</script>";
	}echo"<script language='javascript'> alert('请填写必要内容');history.back();</script>";
}
$smarty->assign("sessionname",$sessionname);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('hueifu_1.html'); //调用模板
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('hueifu.html'); //调用模板
		}
?>