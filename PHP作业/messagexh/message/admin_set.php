<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
$name=$_SESSION['name_1'];
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	include './include/config.php';
	include_once 'title.php';
	$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
	mysql_query("SET NAMES'gb2312'",$link);
	mysql_select_db("$dbname")or die(不能连接数据库！);
	$sql = "select * from ".$tbprefix."user where name='$name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	$id=$row->id;
	if($id != 1){
		echo"<script language='javascript'> alert('用户权限不够');history.back();</script>";
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
	  echo"<script language='javascript'> alert('修改成功');history.back();</script>";
		}
	$smarty->assign("title",$title);
	$smarty->assign("description",$description);
	$smarty->assign("keywords",$keywords);
	$smarty->assign("author",$author);
	$smarty->assign("page",$page);
	$smarty->display('admin_set.html'); //调用front.html模板
	} else {
		 $_SESSION['name'] = false;
		 //echo"<script language='javascript'> alert('你还没有登录');location.href='http:/login_1.php';</script>";
		}
?>
