<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
$name = false;
@session_start();
if (isset($_SESSION['name']) && $_SESSION['name'] === true) {
   if($_GET['zx']='zx'){
		session_start();
		unset($_SESSION['name']);
		session_destroy();
		echo"<script language='javascript'> alert('成功注销');location.href='index.php';</script>";
		}
	} else {
		 $_SESSION['name'] = false;
		 echo"<script language='javascript'> alert('你还没有登录');history.back();</script>";
		}
?>
