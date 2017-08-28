<?php
/**
 *  PHP version 7.0+
 *
 * @copyright  Copyright (c) 2012-2015 EELLY Inc. (http://www.eelly.com)
 * @link       http://www.eelly.com
 * @license    衣联网版权所有
 */


namespace App\Controller;


use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {

        $userObj = new User();
        $start_time = microtime(true);


        for ($i=0; $i <= 10000; $i++){
            $userObj->getUserInfoByIdOrOther(1, 0, '*',true);
        }

        $end_time = microtime(true);

        echo 'slo';
        echo $end_time-$start_time."\r\n";
        $start_time = microtime(true);
        for ($i=0; $i <= 10000; $i++) {
            $userObj->getUserInfoByIdOrOther(1, 0, '*', true);
        }
        $end_time = microtime(true);
        echo 'upl';
        echo $end_time-$start_time."\r\n";

    }
}