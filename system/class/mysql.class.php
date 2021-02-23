<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/1/28 下午4:53:55 
 * LastEditor:  AiMuC
 * ModifyTime:  2021/2/19 下午9:43:44
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
        require(DIR . '/system/config.php');
        try {
            $pdo = new PDO("mysql:local=$config[host];port=$config[port];dbname=$config[dbname]", $config["username"], $config["password"]);
        } catch (PDOException $e) {
            exit('数据库连接错误请检查Config.php文件是否正确配置');
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
    function select($table, $column, $value)
    {
        $pdo = $this->DB;
        $column = implode("=? and ", $column) . "=?";
        $sql = "select * from $table where $column";
        $sql = $pdo->prepare($sql);
        $sql->execute($value);
        $row = $sql->fetchAll();
        $num = $sql->rowCount();
        $ReturnArr = array(
            'count' => $num,
            'data' => $row
        );
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
    function update($table, $column, $value, $where)
    {
        $pdo = $this->DB;
        $column = implode("=?,", $column) . "=?";
        $where = implode("=? and ", $where) . "=?";
        $sql = "update $table set $column where $where";
        $sql = $pdo->prepare($sql);
        $sql->execute($value);
        $row = $sql->fetchAll();
        $num = $sql->rowCount();
        $ReturnArr = array(
            'count' => $num,
            'data' => $row
        );
        return $ReturnArr;
    }

    function getexecsqlall($exec)
    {
        $pdo = $this->DB;
        $sql = $pdo->prepare("$exec");
        $sql->execute();
        $row = $sql->fetchAll();
        $num = $sql->rowCount();
        $ReturnArr = array(
            'count' => $num,
            'data' => $row
        );
        return $ReturnArr;
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
            $num = $sql->rowCount();
            $ReturnArr = array(
                'count' => $num,
                'data' => $row
            );
            return $ReturnArr;
        } else {
            $sql = $pdo->prepare("$exec");
            $sql->execute($value);
            while ($row = $sql->fetch()) {
                $arr = $row["$rowone"];
            }
            $num = $sql->rowCount();
            $ReturnArr = array(
                'count' => $num,
                'data' => $arr
            );
            return $ReturnArr;
        }
    }
}
