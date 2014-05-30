<?php
/*
С��PHP���԰� V1.0
��ϵ�ʼ���ad190929@163.com
ģ��Դ�ԣ�Դ�밮����  ������ͬ���ʹ�� ����������ҵ��;��
*/
error_reporting(E_ALL & ~E_NOTICE);
$rootpath = '../';

// ############################## INCLUDE VERSION ##############################

$book_version = '������';
$default_server = "http://". $_SERVER['HTTP_HOST'] . str_replace("/install/install.php","",$_SERVER['SCRIPT_NAME']) . "/";

// ############################## HEADER AND FOOTER ############################

echo '<html>
      <head>
        <title>��װ����</title>
        <link rel="stylesheet" href="./styles.css" />
      </head>

      <body>

      <table width="480" cellpadding="0" cellspacing="1" border="0" align="center" class="box">
      <tr>
        <td class="title">���Ա� '.$book_version.' ��װ����</td>
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
  echo '<font class=ohred><b>���Ա��Ѿ���װ!</b></font><br />
        �����ϣ��ɾ��ԭ���ݲ����°�װ���������includeĿ¼�µ�config.php�ļ����ݡ�';

  echo $footer;
  exit();
}


// #################### CHECK CONFIG EXISTS AND IS WRITABLE ####################

if(!file_exists($rootpath . 'include/config.php'))
{
  echo '<font class=ohred><b>�����ļ�config.php������!</b></font><br/>
       ���ü��±��༭һ�����ļ����ϴ���includeĿ¼��<br /><br />
        Unix��Linux������ϵͳ�£���Ҫ�Ƚ�config.php�ļ���������Ϊ766��<br />
        Ϊ�˰�ȫ�������װ��ɺ��轫config.php�ļ���������Ϊ644��';

  echo $footer;
  exit();
}
else if(!is_writable($rootpath . 'include/config.php'))
{
  @chmod($rootpath . "include/config.php", 0776);

  if(!is_writable($rootpath . 'include/config.php'))
  {
    echo '<font class=ohred><b>config.php�ļ�����д!</b></font><br />
          config.php�ļ�����д! Unix��Linux������ϵͳ�£���Ҫ�Ƚ�config.php�ļ���������Ϊ766��<br /><br />
          Ϊ�˰�ȫ�������װ��ɺ��轫config.php�ļ���������Ϊ644��';
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
                echo '<font class=ohred><b>config.php�ļ�����д!</b></font><br />
          config.php�ļ�����д! ��Ҫ�Ƚ�config.php�ļ���������Ϊ��д��<br /><br />
          Ϊ�˰�ȫ�������װ��ɺ��轫config.php�ļ���������Ϊ����д��';

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
    $installerrors[] = '������ϵͳ�����û���.';

  if(strlen($password) == 0)
    $installerrors[] = '������ϵͳ��������.';

  if($password != $confirmpassword)
    $installerrors[] = '����������ȷ�����벻ƥ��.';


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
          $installerrors[] = '���ݿ� "' . $dbname . '" ������.<br />' . mysql_error();
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
      $installerrors[] = '�޷�����MySql���ݿ������, ��Ϣ:<br />' . mysql_error();
    }
  }
  else
  {
    // mysql extensions not installed
    $installerrors[] = '��վ������������֧��MySql��չ.';
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
  DB_Query ("INSERT INTO " . TABLE_PREFIX . "guestbook(typeid,title,content,name,time,time_1) VALUES ('0','�����װ���','��ϲ����װ�ɹ����뱣���ײ����ӣ�лл~_~','webmaster','".date('Y-m-d H:i:s')."','".time()."') ");
  DB_Query ("INSERT INTO " . TABLE_PREFIX . "title VALUES (1,'С��PHP���԰�','С��PHP���԰�','С��PHP���԰�','С��',5) ");


// д�������ļ�
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


  echo '<font class=ohblue>ף������ '.$book_version.' �Ѿ���װ�ɹ�!</font><br /><br />��ɾ����װĿ¼install�����!
        <br /><br />
        <a href="' . $rootpath . 'index.php"><b>�������������Ա�!</b></a>';

  }  // if !isset($installerrors)

}


function DB_Query($sql)
{
  $result = MYSQL_QUERY ($sql);

  if(!$result)
  {
    $message  = "���ݿ���ʴ���\r\n\r\n";
    $message .= $sql . " \r\n";
    $message .= "��������: ". mysql_error() ." \r\n";
    $message .= "�������: " . mysql_errno() . " \r\n";
    $message .= "ʱ��: ".gmdate("l dS of F Y h:i:s A"). "\r\n";
    $message .= "�ļ�: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

    echo '<b>���ݿ���ʴ���!</b> <br />
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
              <u><b>��װ����!</b></u><br /><br />
              ��װ�����з������´���:<br /><br />';

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
		  <td valign="top" align="right" style="padding-bottom: 3px;"><u>С��PHP���԰�</u></td>
		</tr>
        </table>
        <br />

      <b>1) �������ݿ�:</b><br /><br />
        <form method="post" action="install.php" name="installform">
        <table width="96%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td valign="top">���ݿ��������ַ:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="servername" value="' . $servername . '" /></td>
        </tr>
        <tr>
          <td valign="top">���ݿ���:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="dbname" value="' . $dbname . '" /></td>
        </tr>
        <tr>
          <td valign="top">�����û���:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="dbusername" value="' . $dbusername . '" /></td>
        </tr>
        <tr>
          <td valign="top">���ݿ�����:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="password" name="dbpassword" size="21"/></td>
        </tr>
        <tr>
          <td valign="top">���ݱ�ǰ׺:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="tableprefix" value="' . $tableprefix . '" /></td>
        </tr>
        </table>

        <br /><br />

        <b>2) ��������Ա�ʺ�:</b><br /><br />

        <table width="96%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td valign="top">��̨�����û���:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="text" name="username" value="' . $username . '" /></td>
        </tr>
        <tr>
          <td valign="top">��̨��������:</td>
          <td valign="top" align="right" style="padding-bottom: 3px;"><input type="password" name="password" size="21"/></td>
        </tr>
        <tr>
          <td valign="top">ȷ�Ϲ�������:</td>
          <td valign="top" align="right" style="padding-bottom: 6px;"><input type="password" name="confirmpassword" size="21"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="submit" name="install" value="��ʼ��װ���Ա�" class="submit" /></td>
        </tr>
        </table>

        </form>';
}

// ############################### PRINT FOOTER ################################

echo $footer;

?>