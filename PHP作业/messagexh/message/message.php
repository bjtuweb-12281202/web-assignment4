<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
include './include/config.php';
$title=addslashes(htmlspecialchars($_POST['title']));
$neir=addslashes(htmlspecialchars($_POST['neirong']));
$name=$_SESSION['name_1'];
if($name==""){
	$name="匿名";
}
$number=$_POST['unum'];
$time=date("Y-m-d H:i:s",time());
$time_1=time();
if(!empty($title) or !empty($neir)){
//还原空格和回车
if(!empty($neir)){
	$neir=str_replace("　","",$neir);
	$neir=ereg_replace("\n","<br>　　",ereg_replace(" ","&nbsp;",$neir));
}
}
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
@session_start();
if($number  !=  $_SESSION['long']  ||  empty($number)){
	echo"<script language='javascript'> alert('验证码不正确');history.back();</script>";
}else if(!$title==0 && !$neir==0){
	$ins="insert into ".$tbprefix."guestbook(typeid,title,content,name,time,time_1) values('$fruits','$title','$neir','$name','$time','$time_1')";
	mysql_query($ins);
	echo"<script language='javascript'> alert('主题发表成功');location.href='index.php';</script>";
}else echo"<script language='javascript'> alert('请正确填写“*”内容');history.back();</script>";

?>
