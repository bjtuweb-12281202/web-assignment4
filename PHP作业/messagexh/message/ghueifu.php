<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
require_once 'Myclass.php'; //ʹ��smarty��
include_once 'title.php';
include './include/config.php';
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
$sql = "select * from ".$tbprefix."reply where id_1='$_GET[id]'";
   $result = mysql_query($sql);
   while($rs=mysql_fetch_array($result)){
   	$reply[]=array('name_1'=>$rs['name'],'time_1'=>$rs['time'],'counner_1'=>$rs['counner']);
  }
$smarty->assign("reply",$reply);
@session_start();
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('moreback.html'); //����ģ��
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('moreback_1.html'); //����ģ��
		}
?>