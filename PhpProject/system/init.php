<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:15:41 
 * LastEditor:  AiMuC 
 * ModifyTime:  2021/2/12 下午3:26:32 
 * Description: 
*/
error_reporting(0);
date_default_timezone_set('PRC');
header('Content-type:text/html;charset=utf8');
define('DIR', dirname(__DIR__));
include_once(DIR . '/system/class/mysql.class.php');
include_once(DIR . '/system/function.php');
foreach ($_GET as $k => $v) CheckInput($v); //检查传入字符串
foreach ($_POST as $k => $v) CheckInput($v); //检查传入字符串
