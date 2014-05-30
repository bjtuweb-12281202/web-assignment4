<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
@session_start();
$sessionname=$_SESSION['name_1'];
include './include/config.php';
if(!defined('Has been building a database')){
	echo '留言本数据库没有正确安装!<br /><a href="install/install.php">请点击这里安装</a>';
	exit();
}
require_once 'Myclass.php'; //使用smarty类
include_once 'title.php';
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(连接错误！);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(不能连接数据库！);
if(isset($_GET['page'])){
	$page=intval($_GET['page']);
	}else{
		$page=1;
		}
	$pagesize=$onpage;
	$sql="select * from ".$tbprefix."guestbook";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	$smarty->assign("num",$num);
	if(!$num==0){
		if($num < $pagesize){$page_count=1;}
		if($num % $pagesize){
			$page_count=(int)($num / $pagesize)+1;
			}else{
			$page_count=$num / $pagesize;
			}
		}else{
		$page_count=o;
		}
	$page_string = '';
	if( $page == 1 ){
		$page_string .= '第一页|上一页|';
		}else{
			$page_string .= '<a href=?page=1>第一页</a>|<a href=?page='.($page-1).'>上一页</a>|';
   			}
		if( ($page == $page_count) || ($page_count == 0) ){
  		 $page_string .= '下一页|尾页';
			}else{
   			$page_string .= '<a href=?page='.($page+1).'>下一页</a>|<a href=?page='.$page_count.'>尾页</a>';
			}
	if( $num ){
   		$sql = "select * from ".$tbprefix."guestbook order by time_1 desc limit ". ($page-1)*$pagesize .", $pagesize";
   		$result = mysql_query($sql);
   		while($rs=mysql_fetch_array($result)){
  	 		$myquery[]=array('id'=>$rs['id'],'title'=>$rs['title'],'name'=>$rs['name'],'time'=>$rs['time'],'content'=>$rs['content']);
  	 		//if($rs['time']==date("Y-m-d")){
  	 		//	$smarty->assign("new",$img)
  	 		//};
 	  	}$smarty->assign("page",$page_string);
 	  }else{
  		 $rowset = array();
}
$smarty->assign("query",$myquery);
$smarty->assign("rss",$rss);
$smarty->assign("sessionname",$sessionname);
if (isset($_SESSION['name']) && $_SESSION['name'] === true){
	$smarty->display('index_1.html'); //调用模板
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('index.html'); //调用模板
		}
?>
