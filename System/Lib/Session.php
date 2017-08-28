<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 下午7:11
 * Desc: 类简单描述一下
 */

namespace System\Lib;

/**
 * Class Session
 * @package System\Lib
 */
class Session
{
    protected static $sessionSavePath = ROOT_PATH.'/tmp';

    public static function start()
    {

        session_set_save_handler('self::open','self::close','self::read', 'self::write', 'self::destroy','self::gc');
        session_start();
    }

    public static function open($save_path = '', $session_name)
    {
        if (strlen($save_path) > 0) {

            self::$sessionSavePath = $save_path;
        }
        return true;
    }

    public static function close()
    {
        return true;
    }


    public static function read($id)
    {
        $sesFile = self::$sessionSavePath . "/glf_" . $id;
        return (string)@file_get_contents($sesFile);
    }


    /**
     * 结束时和session_write_close()强制提交SESSION数据 $_SESSION[]="aaa";
     * @param $id
     * @param $sess_data
     * @return bool|int
     */
    public static function write($id, $sesData)
    {
        $sesFile = self::$sessionSavePath . "/glf_" . $id;

        if ($fp = @fopen($sesFile, "w")) {
            $return = @fwrite($fp, $sesData);
            @fclose($fp);
            return $return;
        } else {
            return false;
        }
    }


    /**
     * session_destroy()
     * @param $id
     * @return bool
     */
    public static function destroy($id)
    {
        $sesFile = self::$sessionSavePath . "/glf_" . $id;
        return @unlink($sesFile);
    }


    /**
     * ession.gc_probability和session.gc_divisor值决定的，open(), read() session_start也会执行gc
     * @param $maxLifetime
     * @return bool
     */
    public static function gc($maxLifetime)
    {

        foreach (glob(self::$sessionSavePath . "/glf_*") as $filename) {
            if (filemtime($filename) + $maxLifetime < time()) {
                @unlink($filename);
            }
        }
        return true;
    }
}


