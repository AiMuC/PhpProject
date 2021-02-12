<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:50:15 
 * LastEditor:  AiMuC 
 * ModifyTime:  2021/2/12 下午3:25:41 
 * Description: 
*/
define('DIR', dirname(__DIR__));
include_once(DIR . '/system/class/mysql.class.php');

/* 
 * @Description: 操作数据库对象Mysql演示Demo
 * @return: string
*/
function MySqlDemo()
{
    //直接调用Mysql对象创建的$Mysql
    $Mysql = $GLOBALS['Mysql'];
    print_r($Mysql->getexecsql("select 1+1"));
    //重新初始化对象
    $Mysql1 = new MySql(); //创建对象
    $Mysql1->MySqlInit(); //初始化对象
    print_r($Mysql1->getexecsqlall("select 2+2,2*2"));
}

/* 
 * @Description: Web请求函数
 * @param: url 必填
 * @param: header 请求头 为空时使用默认值
 * @param: type 请求类型
 * @param: data 请求数据
 * @param: DataType 数据类型 分为1,2 1为数据拼接传参 2为json传参
 * @return: result
*/
function MyRequest($url, $header, $type, $data, $DataType)
{
    //常用header
    //$header = "user-agent:" . 1 . "\r\n" . "referer:" . 1 . "\r\n" . "AccessToken:" . 1 . "\r\n" . "cookie:" . 1 . "\r\n";
    if (empty($header)) $header = "user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.63\r\n";
    if (!empty($data)) {
        if ($DataType == 1) {
            $data = http_build_query($data); //数据拼接
        } else if ($DataType == 2) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE); //数据格式转换
        }
    }
    $options = array(
        'http' => array(
            'method' => $type,
            "header" => $header,
            'content' => $data,
            'timeout' => 15 * 60, // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
