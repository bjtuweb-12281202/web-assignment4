<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
@session_start();
$sessionname=$_SESSION['name_1'];
include './include/config.php';
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
  	 $myquery[]=array('id'=>$rs['id'],'title'=>$rs['title'],'name'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['content']);
	if(($rs['name'] != $sessionname) && ($id != 1)){
		echo"<script language='javascript'> alert('Ȩ�޲���');history.back();</script>";
		exit();
	}
}
$sql = "delete from ".$tbprefix."reply where id='$_GET[id]'";
mysql_query($sql);
mysql_close();
echo"<script language='javascript'> alert('�ɹ�ɾ��');location.href='index.php';</script>";
?>