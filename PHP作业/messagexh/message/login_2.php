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
$pas1=$_POST['pw1'];
$number=$_POST['number'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
if($_POST['zc']){
	if($name!="" && $pas!="" && $pas1!=""){
		if($pas!=$pas1){
			echo"<script language='javascript'> alert('ȷ�ϴ���');history.back();</script>";
		}
		@session_start();
		if($number  !=  $_SESSION['long']  ||  empty($number)){
			echo"<script language='javascript'> alert('��֤�����');history.back();</script>";
		}else{
			$yanzeng="select * from ".$tbprefix."user where name='".$name."'";
			$yi=mysql_query($yanzeng);
			$uu=mysql_num_rows($yi);
			if($uu	>0){
				echo"<script language='javascript'> alert('�û�����ע��');history.back();</script>";
			}else {
				$zc="insert into ".$tbprefix."user(name,password) values('$name','$pas')";
				mysql_query($zc);
				$_SESSION['name']=true;
				$_SESSION['name_1']=$name;
				echo"<script language='javascript'> alert('��ϲ�û���$name ע��ɹ�');location.href='index.php';</script>";
			}
		}
	}else echo"<script language='javascript'> alert('��������дע����Ϣ');history.back();</script>";
}
$smarty->display('login_2.html'); //����front.htmlģ��
?>
