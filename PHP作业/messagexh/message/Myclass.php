<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/

require_once 'smarty/libs/Smarty.class.php'; //ʹ��smarty��
$smarty = new Smarty(); //��ʼ����
$smarty->template_dir = "smarty/templates/templates"; //����ģ��Ŀ¼
$smarty->compile_dir = "smarty/templates/templates_c"; //���ñ���Ŀ¼
$smarty->config_dir = "smarty/templates/config"; //�����ļ�Ŀ¼
$smarty->cache_dir = "smarty/templates/cache";  //�趨����Ŀ¼
$smarty->caching = false; //���û���
?>
