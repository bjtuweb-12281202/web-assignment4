<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/

require_once 'smarty/libs/Smarty.class.php'; //使用smarty类
$smarty = new Smarty(); //初始化类
$smarty->template_dir = "smarty/templates/templates"; //设置模板目录
$smarty->compile_dir = "smarty/templates/templates_c"; //设置编译目录
$smarty->config_dir = "smarty/templates/config"; //配置文件目录
$smarty->cache_dir = "smarty/templates/cache";  //设定缓存目录
$smarty->caching = false; //设置缓存
?>
