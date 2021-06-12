<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/5/26下午11:20:29 
 * LastEditor:  AiMuC
 * ModifyTime:  2021/5/26下午11:56:18
 * Description: 
*/

class MySql
{

    public $DB = null;

    function MySql()
    {
        require(DIR . '/system/config.php');
        try {
            $pdo = new PDO("mysql:local=$config[host];port=$config[port];dbname=$config[dbname]", $config["username"], $config["password"]);
        } catch (PDOException $e) {
            echo "数据库连接错误请检查Config.php文件是否正确配置<br>";
            exit(print_r($e->getMessage()));
        }
        $pdo->exec("set names utf8");
        $this->DB = $pdo;
    }

    /* 
 * @Description: Mysql查询函数
 * @param: table 表名
 * @param: columu 列名
 * @param: value 需要带入查询的值
 * @return: array
*/
    function Select($table, $column, $value)
    {
        $pdo = $this->DB;
        $column = implode("=? and ", $column) . "=?";
        $sql = "select * from $table where $column";
        $sql = $pdo->prepare($sql);
        $sql->execute($value);
        $row = $sql->fetchAll(PDO::FETCH_ASSOC);
        $ReturnArr = [
            'count' => $sql->rowCount(),
            'data' => $row[0]
        ];
        return $ReturnArr;
    }
    /* 
 * @Description: 更新表内容
 * @param: table 表名
 * @param: column 需更新的列名
 * @param: value 更新的值 条件内的值需要跟在value中
 * @param: where 更新条件
 * @demo：print_r($Mysql1->update('表名',array('列名1','列名2'),array(值1,值2,条件值3),array(条件)));
 * @return: array
*/
    function Update($table, $column, $value, $where)
    {
        $pdo = $this->DB;
        $column = implode("=?,", $column) . "=?";
        $where = implode("=? and ", $where) . "=?";
        $sql = "update $table set $column where $where";
        $sql = $pdo->prepare($sql);
        $sql->execute($value);
        $ReturnArr = [
            'count' => $sql->rowCount()
        ];
        return $ReturnArr;
    }

    function GetExecSqlAll($exec)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute();
        $row = $sql->fetchAll(PDO::FETCH_ASSOC);
        $ReturnArr = [
            'count' => $sql->rowCount(),
            'data' => $row[0]
        ];
        return $ReturnArr;
    }

    function GetExecSql($exec)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function ChangeDb($exec, $value)
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

    function GetResult($exec, $value, $rowone)
    {
        $pdo = $this->DB;
        if (empty($rowone)) {
            $sql = $pdo->prepare("$exec");
            $sql->execute($value);
            $row = $sql->fetchAll(PDO::FETCH_ASSOC);
            $ReturnArr = [
                'count' => $sql->rowCount(),
                'data' => $row[0]
            ];
            return $ReturnArr;
        } else {
            $sql = $pdo->prepare("$exec");
            $sql->execute($value);
            $arr=$sql->fetchColumn(0);
            $ReturnArr = [
                'count' => $sql->rowCount(),
                'data' => $arr
            ];
            return $ReturnArr;
        }
    }
}
