<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
$admin_pass=$_POST['admin_pass'];
$password_1=$_POST['password'];
$admin_pass2=$_POST['admin_pass2'];
@session_start();
$name=$_SESSION['name_1'];
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	include './include/config.php';
	include_once 'title.php';
	$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
	mysql_query("SET NAMES'gb2312'",$link);
	mysql_select_db("$dbname")or die(�����������ݿ⣡);
	$sql = "select * from ".$tbprefix."user where name='$name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	$id=$row->id;
	if($id != 1){
		$set="";
	}else {$set='<li><a href="admin_set.php">ϵͳ��������</a>';}
	$sql = "select * from ".$tbprefix."user";
	$result=mysql_query($sql);
	$rs=mysql_fetch_object($result);
	$password=$rs->password;
	$smarty->assign("name",$name);
	$smarty->assign("set",$set);
	if($_POST[tj]){
		if($password_1 != $admin_pass2){
			echo"<script language='javascript'> alert('����ȷ�ϴ���');history.back();</script>";
		}else if($password == $admin_pass){
			$exec="update ".$tbprefix."user set password='".$password_1."' where name='".$name."'";
	  		$result=mysql_query($exec);
	  		echo"<script language='javascript'> alert('�޸ĳɹ�');history.back();</script>";
		}echo"<script language='javascript'> alert('����ȷ����ԭʼ����');history.back();</script>";
	}
$smarty->display('admin_mp.html'); //����front.htmlģ��
} else {
	 $_SESSION['name'] = false;
	}
?>
