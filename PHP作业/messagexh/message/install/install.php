<?php
/*
小海PHP留言板 V1.0
联系邮件：ad190929@163.com
模板源自：源码爱好者  经作者同意后使用 不得用于商业用途。
*/
error_reporting(E_ALL & ~E_NOTICE);
$rootpath = '../';

// ############################## INCLUDE VERSION ##############################

$book_version = '简单留言';
$default_server = "http://". $_SERVER['HTTP_HOST'] . str_replace("/install/install.php","",$_SERVER['SCRIPT_NAME']) . "/";

// ############################## HEADER AND FOOTER ############################

echo '<html>
      <head>
        <title>安装程序</title>
        <link rel="stylesheet" href="./styles.css" />
      </head>

      <body>

      <table width="480" cellpadding="0" cellspacing="1" border="0" align="center" class="box">
      <tr>
        <td class="title">留言本 '.$book_version.' 安装程序</td>
      </tr>
      <tr>
        <td valign="top" style="padding: 5px;"><br />';

// store the footer in a var since it will be used in different parts of this file
$footer = '  </td>
          </tr>
          </table>

          </body>
          </html>';


// ################# CHECK IF WEENCOMPANY IS ALREADY INSTALLED ##################

@include($rootpath . 'include/config.php');

if(defined('MCBOOKINSTALLED'))
{
  echo '<font class=ohred><b>留言本已经安装!</b></font><br />
        如果您希望删除原数据并重新安装，请先清除include目录下的config.php文件内容。';

  echo $footer;
  exit();
}


// #################### CHECK CONFIG EXISTS AND IS WRITABLE ####################

if(!file_exists($rootpath . 'include/config.php'))
{
  echo '<font class=ohred><b>配置文件config.php不存在!</b></font><br/>
       请用记事本编辑一个空文件并上传到include目录。<br /><br />
        Unix或Linux服务器系统下，需要先将config.php文件属性设置为766。<br />
        为了安全起见，安装完成后需将config.php文件属性设置为644。';

  echo $footer;
  exit();
}
else if(!is_writable($rootpath . 'include/config.php'))
{
  @chmod($rootpath . "include/config.php", 0776);

  if(!is_writable($rootpath . 'include/config.php'))
  {
    echo '<font class=ohred><b>config.php文件不可写!</b></font><br />
          config.php文件不可写! Unix或Linux服务器系统下，需要先将config.php文件属性设置为766。<br /><br />
          为了安全起见，安装完成后需将config.php文件属性设置为644。';
  }

  echo $footer;
  exit();
}
else
{
        // Also try and actually open the file in case we are running on Windows
        // as they user may not have access to the file
        if(!$fp = @fopen($rootpath . 'include/config.php', "w"))
        {
                echo '<font class=ohred><b>config.php文件不可写!</b></font><br />
          config.php文件不可写! 需要先将config.php文件属性设置为可写。<br /><br />
          为了安全起见，安装完成后需将config.php文件属性设置为不可写。';

                echo $footer;
                  exit();
        }
}


// ############################### GET POST VARS ###############################

$servername      = isset($_POST['install']) ? $_POST['servername']      : 'localhost';
$dbname          = isset($_POST['install']) ? $_POST['dbname']          : 'message_book';
$dbusername      = isset($_POST['install']) ? $_POST['dbusername']      : 'root';
$dbpassword      = isset($_POST['install']) ? $_POST['dbpassword']      : '';
$tableprefix     = isset($_POST['install']) ? $_POST['tableprefix']     : 'ad_';

$username        = isset($_POST['install']) ? $_POST['username']        : 'admin';
$password        = isset($_POST['install']) ? $_POST['password']        : '';
$confirmpassword = isset($_POST['install']) ? $_POST['confirmpassword'] : '';


// ############################ INSTALL WEENCOMPANY #############################

if(isset($_POST['install']))
{
  // check for errors

  if(strlen($username) == 0)
    $installerrors[] = '请输入系统管理用户名.';

  if(strlen($password) == 0)
    $installerrors[] = '请输入系统管理密码.';

  if($password != $confirmpassword)
    $installerrors[] = '管理密码与确认密码不匹配.';


  // Determine if MySql is installed
  if(function_exists('mysql_connect'))
  {
    // attempt to connect to the database
    if($connection = @MYSQL_CONNECT($servername, $dbusername, $dbpassword))
    {

       $sqlversion = mysql_get_server_info();

       if($sqlversion >= '4.1'){
           mysql_query("set names 'gbk'");

       }

       if($sqlversion > '5.0.1') {
           mysql_query("SET sql_mode=''");
       }


      // connected, now lets select the database
      if(!@MYSQL_SELECT_DB($dbname, $connection))
      {

        // The database does not exist... try to create it:
        if(!@DB_Query("CREATE DATABASE $dbname"))
        {
          $installerrors[] = '数据库 "' . $dbname . '" 不存在.<br />' . mysql_error();
        }
        else
        {
		   if($sqlversion >= '4.1'){
			   mysql_query("set names 'gbk'");

		   }

		   if($sqlversion > '5.0.1') {
			   mysql_query("SET sql_mode=''");
		   }
          // Success! Database created
          MYSQL_SELECT_DB($dbname, $connection);
        }

      }
    }
    else
    {
      // could not connect
      $installerrors[] = '无法连接MySql数据库服务器, 信息:<br />' . mysql_error();
    }
  }
  else
  {
    // mysql extensions not installed
    $installerrors[] = '网站服务器环境不支持MySql扩展.';
  }

  if(!isset($installerrors))
  {

  define('TABLE_PREFIX', $tableprefix);


  DB_Query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "guestbook");
  DB_Query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "reply");
  DB_Query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "title");
  DB_Query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "user");

  DB_Query ("CREATE TABLE " . TABLE_PREFIX . "guestbook (
  id 			INT(15)   				UNSIGNED 	NOT NULL  AUTO_INCREMENT,
  typeid 		VARCHAR(3) 							NOT NULL  DEFAULT '',
  title 		VARCHAR(50) 		  				NOT NULL  DEFAULT '',
  content 		text 		  						NOT NULL  ,
  name			VARCHAR(50)							NOT NULL  ,
  time 			TIMESTAMP 	ON UPDATE CURRENT_TIMESTAMP			NOT NULL DEFAULT '0000-00-00 00:00:00',
  time_1 		INT(10)   				UNSIGNED	NOT NULL  ,
  PRIMARY KEY (id)
  )  DEFAULT CHARSET=gbk");

  DB_Query ("CREATE TABLE " . TABLE_PREFIX . "reply (
  id 			INT(11)   					UNSIGNED 	NOT NULL  AUTO_INCREMENT,
  id_1 			INT(20)   								NOT NULL  ,
  name 			VARCHAR(20) 					  		NOT NULL  ,
  counner 		VARCHAR(300) 						  	NOT NULL  ,
  time 			TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP 	NOT NULL  DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id)
  )  DEFAULT CHARSET=gbk");

  DB_Query ("CREATE TABLE " . TABLE_PREFIX . "title (
  id 			INT(10)   UNSIGNED 	NOT NULL  AUTO_INCREMENT,
  title 		VARCHAR(100) 	  	NOT NULL  DEFAULT '',
  description 	VARCHAR(500) 	  	NOT NULL  DEFAULT '',
  keywords 		VARCHAR(500) 	  	NOT NULL  DEFAULT '',
  author 		VARCHAR(200) 	  	NOT NULL  DEFAULT '',
  page			INT(2)				NOT NULL  ,
  PRIMARY KEY (id)
  )  DEFAULT CHARSET=gbk");

  DB_Query ("CREATE TABLE " . TABLE_PREFIX . "user (
  id 			INT(8)   			UNSIGNED 	NOT NULL  AUTO_INCREMENT,
  name 			VARCHAR(8) 	  	NOT NULL  DEFAULT '',
  password 		VARCHAR(12)   	NOT NULL  DEFAULT '',
  PRIMARY KEY (id)
  ) DEFAULT CHARSET=gbk");

  DB_Query ("INSERT INTO " . TABLE_PREFIX . "user VALUES (1,'$username','$password') ");
  DB_Query ("INSERT INTO " . TABLE_PREFIX . "guestbook(typeid,title,content,name,time,time_1) VALUES ('0','软件安装完成','恭喜您安装成功，请保留底部链接，谢谢~_~','webmaster','".date('Y-m-d H:i:s')."','".time()."') ");
  DB_Query ("INSERT INTO " . TABLE_PREFIX . "title VALUES (1,'小海PHP留言板','小海PHP留言板','小海PHP留言板','小海',5) ");


// 写入配置文件
$configfile="<"."?php

\$servername  = '$servername';
\$dbname  = '$dbname';
\$dbusername  = '$dbusername';
\$dbpassword  = '$dbpassword';
\$tbprefix='$tableprefix';


define('Has been building a database', true);
define('TABLE_PREFIX', \"$tableprefix\");

if (PHP_VERSION > '5.0.0'){
date_default_timezone_set('PRC');
}

?".">";


  // write the config file
  $filenum = fopen ($rootpath . "include/config.php","w");
  ftruncate($filenum, 0);
  fwrite($filenum, $configfile);
  fclose($filenum);


  echo '<font class=ohblue>祝贺您！ '.$book_version.' 已经安装成功!</font><br /><br />请删除安装目录install后继续!
        <br /><br />
        <a href="' . $rootpath . 'index.php"><b>点击这里浏览留言本!</b></a>';

  }  // if !isset($installerrors)

}


function DB_Query($sql)
{
  $result = MYSQL_QUERY ($sql);

  if(!$result)
  {
    $message  = "数据库访问错误\r\n\r\n";
    $message .= $sql . " \r\n";
    $message .= "错误内容: ". mysql_error() ." \r\n";
    $message .= "错误代码: " . mysql_errno() . " \r\n";
    $message .= "时间: ".gmdate("l dS of F Y h:i:s A"). "\r\n";
    $message .= "文件: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

    echo '<b>数据库访问错误!</b> <br />
          <p><form><textarea rows="15" cols="60">'.htmlspecialchars($message).'</textarea></form></p>';

    exit;
  }
  else
  {
    return true;
  }
}


// ############################### INSTALL FORM ################################

if(!isset($_POST['install']) OR isset($installerrors))
{
  if(isset($installerrors))
  {
    echo '<table width="97%" border="0" cellpadding="5" cellspacing="0" align="center">
          <tr>
            <td style="border: 1px solid #FF0000; font-size: 12px;" bgcolor="#FFE1E1">
              <u><b>安装错误!</b></u><br /><br />
              安装过程中发现以下错误:<br /><br />';

    for($i = 0; $i < count($installerrors); $i++)
    {
      echo '<b>' . ($i + 1) . ') ' . $installerrors[$i] . '</b><br /><br />';
    }

    echo '  </td>
          </tr>
          </table><br /><br />';
  }

  echo '<table width="96%" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
		  <td valign="top"></td>
		  <td valign="top" align="right" style="padding-bottom: 3px;"><u>小海PHP留言板</u></td>
		</tr>
        </table>
        <br />

      <b>1) 创建数据库:</b><br /><br />
        <form method="post" action="install.php" name="installform">
        <table width="96%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td valign="top">数据库服务器地址:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="servername" value="' . $servername . '" /></td>
        </tr>
        <tr>
          <td valign="top">数据库名:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="dbname" value="' . $dbname . '" /></td>
        </tr>
        <tr>
          <td valign="top">数据用户名:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="dbusername" value="' . $dbusername . '" /></td>
        </tr>
        <tr>
          <td valign="top">数据库密码:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="password" name="dbpassword" size="21"/></td>
        </tr>
        <tr>
          <td valign="top">数据表前缀:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="tableprefix" value="' . $tableprefix . '" /></td>
        </tr>
        </table>

        <br /><br />

        <b>2) 创建管理员帐号:</b><br /><br />

        <table width="96%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td valign="top">后台管理用户名:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="username" value="' . $username . '" /></td>
        </tr>
        <tr>
          <td valign="top">后台管理密码:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="password" name="password" size="21"/></td>
        </tr>
        <tr>
          <td valign="top">确认管理密码:</td>
          <td valign="top" align="right" style="padding-bottom: 6px;"><input type="password" name="confirmpassword" size="21"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="submit" name="install" value="开始安装留言本" class="submit" /></td>
        </tr>
        </table>

        </form>';
}

// ############################### PRINT FOOTER ################################

echo $footer;

?>