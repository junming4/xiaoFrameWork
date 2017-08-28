<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: DB操作类
 */

namespace System;
/**
 * Class MySql
 * @package System\DB
 */
/**
 * Class DB
 * @package System
 */
class DB
{
    /**
     * @var array
     */
    public $queries = [];
    /**
     * @var
     */
    protected $conn_id = null;
    /**
     * @var
     */
    protected $db;

    /**
     * @param $config
     */
    public function connect($config = [])
    {
        if (empty($config)) {
            $config = ['server' => '127.0.0.1', 'username' => 'root', 'password' => '12345446', 'db' => 'user_db'];
        }

        $this->db = trim($config['db']);

        $this->conn_id = @mysqli_connect($config['server'], $config['username'], $config['password'], $this->db);

        if (!$this->conn_id) {
            die('Could not connect: ' . mysqli_error($this->conn_id));
        }
    }

    /**
     *
     */
    public function setDb()
    {
        mysql_select_db($this->db, $this->conn_id) or die("数据库选择失败");
    }


    /**
     * @param $sql
     * @return array
     */
    public function getAll($sql)
    {
        array_push($this->queries, $sql);
        $result = mysqli_query($this->conn_id, $sql);

        $res = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $res[] = $row;
        }
        mysqli_free_result($result);
        return $res;
    }

    /**
     * @param $sql
     * @return array
     */
    public function getOne($sql)
    {
        array_push($this->queries, $sql);

        $result = mysqli_query($this->conn_id, $sql);

        if (empty($result)) return [];

        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        }

        return [];
    }

    /**
     * 保存
     * @param $sql_str
     * @return int
     */
    public function save($sql_str)
    {
        if (strlen($sql_str) < 1) return 0;
        array_push($this->queries, $sql_str);
        mysqli_query($this->conn_id, $sql_str);

        return (int)mysqli_insert_id($this->conn_id);
    }

    /**
     * 更新
     * @param $sql_str
     * @return int
     */
    public function update($sql_str)
    {
        if (strlen($sql_str) < 1) return 0;
        array_push($this->queries, $sql_str);

        mysqli_query($this->conn_id,$sql_str);

        return (int)mysqli_affected_rows($this->conn_id);
    }

    /**
     *
     */
    public function __destruct()
    {
        if(!is_null($this->conn_id))
        {
            mysqli_close($this->conn_id);
        }
    }


}