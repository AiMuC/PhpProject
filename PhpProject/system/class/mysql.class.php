<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/1/28 下午4:53:55 
 * LastEditor:  AiMuC 
 * ModifyTime:  2021/2/12 下午2:32:12 
 * Description: 
*/

//默认创建一个MySql对象返回
$Mysql = new MySql(); //创建对象
$Mysql->MySqlInit(); //初始化对象

class MySql
{

    public $DB = null;

    function MySqlInit()
    {
        define('DIR', dirname(__DIR__));
        require(DIR . '/system/config.php');
        $pdo = new PDO("mysql:local=$config[host];dbname=$config[dbname]", $config["username"], $config["password"]);
        if (!$pdo) exit('数据库连接错误,请在Config.php中修改');
        $pdo->exec("set names utf8");
        $this->DB = $pdo;
    }

    function getexecsqlall($exec)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute();
        $row = $sql->fetchAll();
        return $row;
    }

    function getexecsql($exec)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute();
        $row = $sql->fetch();
        return $row;
    }

    function changedb($exec, $value)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute($value);
        $num = $sql->rowCount();
        if ($num) {
            return true;
        } else {
            return false;
        }
    }

    function getresult($exec, $value, $rowone)
    {
        $pdo = $this->DB;
        if (empty($rowone)) {
            $sql = $pdo->prepare("$exec");
            $sql->execute($value);
            $row = $sql->fetchAll();
            return $row;
        } else {
            $sql = $pdo->prepare("$exec");
            $sql->execute($value);
            while ($row = $sql->fetch()) {
                $arr = $row["$rowone"];
            }
            return $arr;
        }
    }
}
