<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
$pl=$_POST['pl'];
$id=$_GET[id];
$id1=$_GET[id]-1;
$id2=$_GET[id]+1;
require_once 'Myclass.php';
include_once 'title.php';
include './include/config.php';
@session_start();
$sessionname=$_SESSION['name_1'];
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
if($pl){
	$name=false;
	@session_start();
	if (isset($_SESSION['name']) && $_SESSION['name'] === true) {
				    header("location:hueifu.php?id=$id");
				} else {
				    $_SESSION['name'] = false;
				    echo"<script language='javascript'> alert('请先登陆！');history.back();</script>";
				}
	}
$sql = "select * from ".$tbprefix."guestbook where id='$_GET[id]'";
   $result = mysql_query($sql);
   if(!mysql_num_rows($result) > 0){
   	echo"<script language='javascript'> alert('最后一页了');history.back();</script>";
   	}else{
   while($rs=mysql_fetch_array($result)){
   	$content[]=array('id'=>$rs['id'],'title'=>$rs['title'],'name'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['content']);
   	}
  }
if(isset($_GET['page'])){
	$page=intval($_GET['page']);
	}else{
	$page=1;
		}
$pagesize=2;
$exec="select * from ".$tbprefix."reply where id_1='$_GET[id]'";
$result=mysql_query($exec);
$tong=mysql_num_rows($result);
if(!$tong==0){
	if($tong < $pagesize){$page_count=1;}
	if($tong % $pagesize){$page_count=(int)($tong / $pagesize)+1;
	}else{
		$page_count=$tong / $pagesize;
		}
	}else{
		$page_count=o;
		}
$page_string = '';
if( ($page == $page_count) || ($page_count == 0) ){
   $page_string .= '更多回复>>';
}
else{
   $page_string .= "<a href=ghueifu.php?id=$id>更多回复>></a>";
}
if( $tong ){
//echo "<br><hr>";
$sql = "select * from ".$tbprefix."reply where id_1='$_GET[id]' order by id desc limit ". ($page-1)*$pagesize .", $pagesize";
   $result = mysql_query($sql);
   while($rs=mysql_fetch_array($result)){
   	$reply[]=array('id_1'=>$rs['id'],'name_1'=>$rs['name'],'time_1'=>$rs['time'],'counner_1'=>$rs['counner']);
	  }$smarty->assign("page",$page_string);
   	}else{
   $rowset = array();
}
$smarty->assign("id1",$id1);
$smarty->assign("id2",$id2);
$smarty->assign("rss",$rss);
$smarty->assign("id",$id);
$smarty->assign("content",$content);
$smarty->assign("reply",$reply);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('list_2.html'); //调用模板
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('list_1.html'); //调用模板
		}
?>