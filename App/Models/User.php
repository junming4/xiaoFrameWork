<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午11:09
 * Desc: 用户类
 */

namespace App\Models;


/**
 * Class User
 * @package App\Models
 */
/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $tableName = 'user';

    public $allHobbies = [
        0 => ['id' => 1, 'name' => '足球'],
        1 => ['id' => 2, 'name' => '篮球'],
        2 => ['id' => 3, 'name' => '旅游'],
        3 => ['id' => 4, 'name' => '看电影'],
        4 => ['id' => 5, 'name' => '上网']
    ];


    /**
     * 通过id/用户名/邮箱 获取一条数据
     * @param $param int|string (可以是id,用户名，邮箱)
     * @param int $type (0:user_id,1用户名,2++邮箱)
     * @param string $field (查询的字段,默认查询所有'*',格式可以是'user_id,user_name')
     * @return array
     * @since  2017/05/17
     */
    public function getUserInfoByIdOrOther($param, $type = 0, $field = '*', $select= true)
    {
        $type = (int)$type;
        if ($type < 0 || empty($param)) {
            return [];
        }
        //判断是类型
        $where = $type == 0 ? 'user_id=' . (int)$param : ($type == 1
            ? "user_name ='" . mysqli_real_escape_string($this->conn_id,trim($param)) . "'"
            : "email ='" . mysqli_real_escape_string($this->conn_id,trim($param)) . "'");

        if($select == true){
            return $this->getUserInfoV2($where, $field);
        }

        return $this->getUserInfo($where, $field);
    }

    /**
     * 更新数据
     * @param $id
     * @param $data
     * @return bool|int
     */
    public function updateInfo($user_id, $data)
    {
        $user_id = (int)$user_id;
        if ($user_id < 1) return false;
        if (empty($data)) return false;

        $where = "user_id = " . $user_id;

        $set = '';

        foreach ($data as $key => $val) {
            if (strlen($set) > 0) $set .= ',';
            $set .= $key . "='" . mysqli_real_escape_string($this->conn_id,$val) . "'";
        }
        $sql_str = sprintf("UPDATE {$this->tableName} SET %s WHERE %s", $set, $where);
        return $this->update($sql_str);

    }

    /**
     * 插入数据
     * @param $data
     * @return bool|int
     */
    public function insetInfo($data)
    {
        if (empty($data)) return false;
        $keys = array_keys($data);
        $values = array_map('addQuotes', array_values($data));
        $sql_str = sprintf("INSERT INTO {$this->tableName} (%s) VALUES (%s)", implode(',', $keys), implode(',', $values));
        return $this->save($sql_str);
    }

    /**
     * 获取单条信息
     * @param string $where
     * @param string $field
     * @return array
     */
    private function getUserInfo($where = '', $field = '*')
    {
        $where = trim($where);
        $where_str = strlen($where) > 0 ? " WHERE " . $where : '';

        $sql = sprintf("SELECT %s FROM {$this->tableName} %s LIMIT %d,%d", $field, $where_str, 0, 1);
        $res = $this->getOne($sql);
        if (empty($res)) return [];
        return $res;
    }


    /**
     * 获取单条信息
     * @param string $where
     * @param string $field
     * @return array
     */
    private function getUserInfoV2($where = '', $field = '*')
    {
        $where = trim($where);
        $where_str = strlen($where) > 0 ? " where " . $where : '';

        $sql = sprintf("select %s from {$this->tableName} %s limit %d,%d", $field, $where_str, 0, 1);
        $res = $this->getOne($sql);
        if (empty($res)) return [];
        return $res;
    }


}