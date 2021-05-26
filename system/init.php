<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:15:41 
 * LastEditor:  AiMuC
 * ModifyTime:  2021/5/26下午11:56:28
 * Description: 
*/
error_reporting(0); //关闭错误报告
date_default_timezone_set('PRC'); //设置时区
header('Content-type:text/html;charset=utf8'); //设置网页返回编码
define('DIR', dirname(__DIR__)); //定义常量DIR为运行目录
include_once(DIR . '/system/function.php');//引入所有函数
