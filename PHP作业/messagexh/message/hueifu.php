<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
@session_start();
$name=$_SESSION['name_1'];
$code=$_POST['code'];
$neir=addslashes(htmlspecialchars($_POST['neirong']));
if($name==""){
	$name="����";
}
if(!empty($neir)){
	$neir=str_replace("��","",$neir);
	$neir=ereg_replace("\n","<br>����",ereg_replace(" ","&nbsp;",$neir));
}
include_once 'title.php';
include './include/config.php';
$time=date("Y-m-d H:i:s",time());
$time_1=time();
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
if($_POST['reply']){
	if($code  !=  $_SESSION['long']  ||  empty($code)){
		echo"<script language='javascript'> alert('��֤�벻��ȷ');history.back();</script>";
	}else if(!$name==0 && !$neir==0){
		$ins="insert into ".$tbprefix."reply(id_1,name,counner,time) values('$_GET[id]','$name','$neir','$time')";
		mysql_query($ins);
		$time_2="update ".$tbprefix."guestbook set time_1='$time_1' where id='$_GET[id]'";
		mysql_query($time_2);
		echo"<script language='javascript'> alert('���۳ɹ�����');history.back();history.back();</script>";
	}echo"<script language='javascript'> alert('����д��Ҫ����');history.back();</script>";
}
$smarty->assign("sessionname",$sessionname);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('hueifu_1.html'); //����ģ��
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('hueifu.html'); //����ģ��
		}
?>