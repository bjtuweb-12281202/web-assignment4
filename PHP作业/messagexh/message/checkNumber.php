<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
srand(microtime()  *  100000);
$login_check_number  =  strval(rand("1111","9999"));
$_SESSION['long']=$login_check_number;
$h_img  =  imagecreate(40,17);
$c_black  =  ImageColorAllocate($h_img,  0,0,0);
$c_white  =  ImageColorAllocate($h_img,  255,255,255);
imageline($h_img,  1,  1,  350,  25,  $c_black);
imagearc($h_img,  200,  15,  20,  20,  35,  190,  $c_white);
imagestring($h_img,  5,  2,  1,  $login_check_number,  $c_white);
ImagePng($h_img);
ImageDestroy($h_img);
//die();
?>
