<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午9:38
 * Desc: 自动加载文件
 */

namespace System;
global $input;
!defined(ROOT_PATH) or define('ROOT_PATH', dirname(__DIR__)); //如果不存在定义根目录则定义
require_once(ROOT_PATH . '/System/Common/functions.php');
require_once(ROOT_PATH . '/System/Loader.php');
require_once(ROOT_PATH . '/System/Router.php');
Loader::startLoader();
Router::parseParam();