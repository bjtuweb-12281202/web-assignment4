<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
@session_start();
$sessionname=$_SESSION['name_1'];
include './include/config.php';
if(!defined('Has been building a database')){
	echo '���Ա����ݿ�û����ȷ��װ!<br /><a href="install/install.php">�������ﰲװ</a>';
	exit();
}
require_once 'Myclass.php'; //ʹ��smarty��
include_once 'title.php';
$link=mysql_connect("$servername","$dbusername","$dbpassword")or die(���Ӵ���);
mysql_query("SET NAMES'gb2312'",$link);
mysql_select_db("$dbname")or die(�����������ݿ⣡);
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
		$page_string .= '��һҳ|��һҳ|';
		}else{
			$page_string .= '<a href=?page=1>��һҳ</a>|<a href=?page='.($page-1).'>��һҳ</a>|';
   			}
		if( ($page == $page_count) || ($page_count == 0) ){
  		 $page_string .= '��һҳ|βҳ';
			}else{
   			$page_string .= '<a href=?page='.($page+1).'>��һҳ</a>|<a href=?page='.$page_count.'>βҳ</a>';
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
	$smarty->display('index_1.html'); //����ģ��
	} else {
		 $_SESSION['name'] = false;
		 $smarty->display('index.html'); //����ģ��
		}
?>
