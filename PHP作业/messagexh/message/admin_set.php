<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
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
		echo"<script language='javascript'> alert('�û�Ȩ�޲���');history.back();</script>";
	}
	$sql = "select * from ".$tbprefix."title";
	$result=mysql_query($sql);
	$rs=mysql_fetch_object($result);
	$title=$rs->title;
	$description=$rs->description;
	$keywords=$rs->keywords;
	$author=$rs->author;
	$page=$rs->page;
	if($_POST[tj]){
		$exec="update ".$tbprefix."title set title='".$_POST['title']."',description='".$_POST['description']."',keywords='".$_POST['keyworlds']."',author='".$_POST['author']."',page='".$_POST['page']."'";
	  $result=mysql_query($exec);
	  echo"<script language='javascript'> alert('�޸ĳɹ�');history.back();</script>";
		}
	$smarty->assign("title",$title);
	$smarty->assign("description",$description);
	$smarty->assign("keywords",$keywords);
	$smarty->assign("author",$author);
	$smarty->assign("page",$page);
	$smarty->display('admin_set.html'); //����front.htmlģ��
	} else {
		 $_SESSION['name'] = false;
		 //echo"<script language='javascript'> alert('�㻹û�е�¼');location.href='http:/login_1.php';</script>";
		}
?>
