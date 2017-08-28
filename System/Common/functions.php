<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 下午4:49
 * Desc: 常见函数处理
 */

if (!function_exists('addQuotes')) {
    /**
     * 给数组添加单引号
     * @param $values
     * @return string
     */
    function addQuotes($values)
    {
        return "'" . htmlspecialchars($values) . "'";
    }
}

if (!function_exists('checkEmail')) {
    function checkEmail($email)
    {
        $mailPreg = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
        if (preg_match($mailPreg, $email, $macth)) {
            return true;
        }
        return false;
    }
}