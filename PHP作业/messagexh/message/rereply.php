<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
require_once 'Myclass.php'; //ʹ��smarty��
include_once 'title.php';
include './include/config.php';
@session_start();
$sessionname=$_SESSION['name_1'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
$sql = "select * from ".$tbprefix."user where name='$sessionname'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$id=$row->id;
$sql = "select * from ".$tbprefix."reply where id='$_GET[id]'";
$result=mysql_query($sql);
while($rs=mysql_fetch_array($result)){
  	 $myquery[]=array('id'=>$rs['id'],'title'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['counner']);
	if(($rs['name'] != $sessionname) && ($id != 1)){
		echo"<script language='javascript'> alert('Ȩ�޲���');history.back();</script>";
		exit();
	}
}
if($_POST[tj]){
	$exec="update ".$tbprefix."reply set counner='".$_POST['post_contents']."' where id='$_GET[id]'";
  $result=mysql_query($exec);
  echo"<script language='javascript'> alert('�޸ĳɹ�');history.back();history.back();</script>";
	}
$smarty->assign("query",$myquery);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('edit.html'); //����ģ��
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('edit.html'); //����ģ��
		}
?>