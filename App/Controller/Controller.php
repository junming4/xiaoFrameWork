<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午11:07
 * Desc: 控制器基类
 */

namespace App\Controller;


use System\Lib\Tpl;

/**
 * Class Controller
 * @package App\Controller
 */
class Controller extends Tpl
{
    /**
     * @var
     */
    protected $require;

    /**
     * Controller constructor.
     */
    public function __construct()
    {

        global $input;
        $this->require = $input;
    }


    /**
     * 获取数据
     * @param string $item
     * @return string
     */
    public function input($item = '')
    {
        $item = trim($item);
        if (strlen($item) < 1) return $this->require;
        return isset($this->require[$item]) ? $this->require[$item] : '';
    }


    /**
     * @param $data
     */
    public function jsonEnCode($data)
    {
        exit(json_encode($data));
    }




}