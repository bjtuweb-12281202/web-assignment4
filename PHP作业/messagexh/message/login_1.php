<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
include_once 'title.php';
include './include/config.php';
$name=$_POST['name'];
$pas=$_POST['pw'];
$number=$_POST['number'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
if($_POST['dl']){
	if($name!="" && $pas!=""){
	@session_start();
	if($number  !=  $_SESSION['long']  ||  empty($number)){
			echo"<script language='javascript'> alert('验证码错误');history.back();</script>";
		}else{
			$yanzeng="select * from ".$tbprefix."user where name='".$name."' and password='".$pas."'";
			$yi=mysql_query($yanzeng);
			$uu=mysql_num_rows($yi);
			if($uu	>0){
				$_SESSION['name']=true;
				$_SESSION['name_1']=$name;
				echo"<script language='javascript'> alert('欢迎登陆。。');location.href='index.php';</script>";
			}else echo"<script language='javascript'> alert('用户名或密码错误');history.back();</script>";
		}
	}else echo"<script language='javascript'> alert('用户名或密码不能为空');history.back();</script>";
}
$smarty->display('login.html'); //调用front.html模板
?>
