<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午11:22
 * Desc: 路由解析
 */

namespace System;


/**
 * Class Router
 * @package System
 */
class Router
{
    /**
     *解析参数
     */
    public static function parseParam()
    {
        global $input;

        foreach ($_POST as $key => $val) {
            $input[$key] = $val;
        }

        foreach ($_GET as $key => $val) {
            $input[$key] = $val;
        }
        self::loaderController();
    }

    /**
     *去加载控制器里的数据
     */
    public static function loaderController()
    {
        global $input;

        $m = trim(@$input['m']);
        $a = trim(@$input['a']);

        if (strlen($m) < 1) $m = 'index';
        if (strlen($a) < 1) $a = 'index';

        $m = ucfirst($m);

        $controller = sprintf("%sController", $m);

        $fileName = $controller . '.php';
        $path = ROOT_PATH . '/App/' . $fileName;
        if (is_file($path)) {
            require_once($path);
            $className = sprintf("\\App\\%s", $controller);
        }
        $path = ROOT_PATH . '/App/Controller/' . $fileName;
        if (is_file($path)) {
            require_once($path);
            $className = sprintf("\\App\\Controller\\%s", $controller);
        }

        if (!isset($className) || strlen($className) < 1) exit("path 不存在！");

        if (!class_exists($className)) exit("class is not exists");

        $classObj = new $className;

        if (!method_exists($className, $a)) exit($a . "method is not exist");

        call_user_func([$classObj,$a]);
    }


}