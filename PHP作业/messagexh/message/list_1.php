<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
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
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
if($pl){
	$name=false;
	@session_start();
	if (isset($_SESSION['name']) && $_SESSION['name'] === true) {
				    header("location:hueifu.php?id=$id");
				} else {
				    $_SESSION['name'] = false;
				    echo"<script language='javascript'> alert('���ȵ�½��');history.back();</script>";
				}
	}
$sql = "select * from ".$tbprefix."guestbook where id='$_GET[id]'";
   $result = mysql_query($sql);
   if(!mysql_num_rows($result) > 0){
   	echo"<script language='javascript'> alert('���һҳ��');history.back();</script>";
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
   $page_string .= '����ظ�>>';
}
else{
   $page_string .= "<a href=ghueifu.php?id=$id>����ظ�>></a>";
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
	$smarty->display('list_2.html'); //����ģ��
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('list_1.html'); //����ģ��
		}
?>