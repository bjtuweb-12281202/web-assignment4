<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
$name = false;
@session_start();
if (isset($_SESSION['name']) && $_SESSION['name'] === true) {
   if($_GET['zx']='zx'){
		session_start();
		unset($_SESSION['name']);
		session_destroy();
		echo"<script language='javascript'> alert('�ɹ�ע��');location.href='index.php';</script>";
		}
	} else {
		 $_SESSION['name'] = false;
		 echo"<script language='javascript'> alert('�㻹û�е�¼');history.back();</script>";
		}
?>
