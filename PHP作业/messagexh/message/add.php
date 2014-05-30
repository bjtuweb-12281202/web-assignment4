<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
include_once 'title.php';
@session_start();
$sessionname=$_SESSION['name_1'];
$smarty->assign("sessionname",$sessionname);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('add_1.html'); //调用front.html模板
	}else{
		 $_SESSION['name'] = false;
		$smarty->display('add.html'); //调用front.html模板
}
?>