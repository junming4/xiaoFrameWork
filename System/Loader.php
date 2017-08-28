<?php

/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午9:50
 * Desc: 自动加载去
 */

namespace System;

class Loader
{


    public static function startLoader()
    {
        spl_autoload_register('self::loaderController');
    }

    /**
     * 加载控制器
     * @param $controller
     * @return bool
     */
    public static function loaderController($controller)
    {
        if (strpos($controller, 'controller') !== false) return false;
        $fileName = $controller.'.php';
        $path = ROOT_PATH.'/App/'.$fileName;
        if(is_file($path)){
            require_once ($path);
            return new $controller;
        }
        $fileName = str_replace('\\','/',$fileName);
        $path = ROOT_PATH.'/'.$fileName;
        if (is_file($path)){
            require_once ($path);
            return new $controller;
        }
    }


}