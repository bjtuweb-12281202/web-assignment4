<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
include_once 'title.php';
@session_start();
$sessionname=$_SESSION['name_1'];
$smarty->assign("sessionname",$sessionname);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('add_1.html'); //����front.htmlģ��
	}else{
		 $_SESSION['name'] = false;
		$smarty->display('add.html'); //����front.htmlģ��
}
?>