<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
@session_start();
include './include/config.php';
$title=addslashes(htmlspecialchars($_POST['title']));
$neir=addslashes(htmlspecialchars($_POST['neirong']));
$name=$_SESSION['name_1'];
if($name==""){
	$name="����";
}
$number=$_POST['unum'];
$time=date("Y-m-d H:i:s",time());
$time_1=time();
if(!empty($title) or !empty($neir)){
//��ԭ�ո�ͻس�
if(!empty($neir)){
	$neir=str_replace("��","",$neir);
	$neir=ereg_replace("\n","<br>����",ereg_replace(" ","&nbsp;",$neir));
}
}
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
@session_start();
if($number  !=  $_SESSION['long']  ||  empty($number)){
	echo"<script language='javascript'> alert('��֤�벻��ȷ');history.back();</script>";
}else if(!$title==0 && !$neir==0){
	$ins="insert into ".$tbprefix."guestbook(typeid,title,content,name,time,time_1) values('$fruits','$title','$neir','$name','$time','$time_1')";
	mysql_query($ins);
	echo"<script language='javascript'> alert('���ⷢ��ɹ�');location.href='index.php';</script>";
}else echo"<script language='javascript'> alert('����ȷ��д��*������');history.back();</script>";

?>
