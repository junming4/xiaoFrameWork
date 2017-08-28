<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午11:10
 * Desc: model 基础类
 */

namespace App\Models;


use System\DB;

/**
 * Class Model
 * @package App\Models
 */
class Model extends DB
{

    /**
     * @var string
     */
    protected $server = '127.0.0.1'; //服务地址
    /**
     * @var string
     */
    protected $username = 'root';  //用户名
    /**
     * @var string
     */
    protected $password = '123456';  //密码
    /**
     * @var string
     */
    protected $db = 'user_db'; //数据名

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $config = ['server' => $this->server, 'username' => $this->username,
            'password' => $this->password, 'db' => $this->db];
        $this->connect($config);
    }
}