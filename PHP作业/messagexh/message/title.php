<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
include './include/config.php';
require_once 'Myclass.php'; //ʹ��smarty��
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
$sql="select * from ".$tbprefix."title";
$result=mysql_query($sql);
while($rs=mysql_fetch_array($result)){
	$smarty->assign("title",$rs['title']);
	$smarty->assign("description",$rs['description']);
	$smarty->assign("keywords",$rs['keywords']);
	$smarty->assign("author",$rs['author']);
	$onpage=$rs['page'];
}
?>
