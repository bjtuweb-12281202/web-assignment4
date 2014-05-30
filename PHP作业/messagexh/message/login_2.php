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
$pas1=$_POST['pw1'];
$number=$_POST['number'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
if($_POST['zc']){
	if($name!="" && $pas!="" && $pas1!=""){
		if($pas!=$pas1){
			echo"<script language='javascript'> alert('确认错误');history.back();</script>";
		}
		@session_start();
		if($number  !=  $_SESSION['long']  ||  empty($number)){
			echo"<script language='javascript'> alert('验证码错误');history.back();</script>";
		}else{
			$yanzeng="select * from ".$tbprefix."user where name='".$name."'";
			$yi=mysql_query($yanzeng);
			$uu=mysql_num_rows($yi);
			if($uu	>0){
				echo"<script language='javascript'> alert('用户名已注册');history.back();</script>";
			}else {
				$zc="insert into ".$tbprefix."user(name,password) values('$name','$pas')";
				mysql_query($zc);
				$_SESSION['name']=true;
				$_SESSION['name_1']=$name;
				echo"<script language='javascript'> alert('恭喜用户：$name 注册成功');location.href='index.php';</script>";
			}
		}
	}else echo"<script language='javascript'> alert('请完整填写注册信息');history.back();</script>";
}
$smarty->display('login_2.html'); //调用front.html模板
?>
