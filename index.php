<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:16:07 
 * LastEditor:  AiMuC 
 * ModifyTime:  2021/2/12 下午3:26:00 
 * Description: 
*/
require('system/init.php');
MySqlDemo();//数据库操作演示
ResponseData("内容返回成功");
ResponseData("内容返回成功","success",array(1,2,3,4,5));
ResponseData("这是一条警告内容","warning");
ResponseData("这是一条错误内容","error");
print_r(MyRequest("https://baidu.com/", "", "GET", "", ""));//请求Web演示
