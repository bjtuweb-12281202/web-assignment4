<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
include_once 'title.php';
include './include/config.php';
$name=$_POST['name'];
$pas=$_POST['pw'];
$number=$_POST['number'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
if($_POST['dl']){
	if($name!="" && $pas!=""){
	@session_start();
	if($number  !=  $_SESSION['long']  ||  empty($number)){
			echo"<script language='javascript'> alert('��֤�����');history.back();</script>";
		}else{
			$yanzeng="select * from ".$tbprefix."user where name='".$name."' and password='".$pas."'";
			$yi=mysql_query($yanzeng);
			$uu=mysql_num_rows($yi);
			if($uu	>0){
				$_SESSION['name']=true;
				$_SESSION['name_1']=$name;
				echo"<script language='javascript'> alert('��ӭ��½����');location.href='index.php';</script>";
			}else echo"<script language='javascript'> alert('�û������������');history.back();</script>";
		}
	}else echo"<script language='javascript'> alert('�û��������벻��Ϊ��');history.back();</script>";
}
$smarty->display('login.html'); //����front.htmlģ��
?>
