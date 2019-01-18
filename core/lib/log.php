<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/10
 * Time: 20:33
 */
namespace core\lib;
class log
{
    public static $class;
    /**
     * 1. 确定日志存储方式
     *
     * 2. 写日志
     */
    public static function init()
    {
        //确定存储方式
        $drive = config::get('DRIVE', 'log');
        $class = '\core\lib\drive\log\\' . $drive;
        self::$class = new $class;
    }

    public static function log($data, $file = '')
    {
        self::$class->log($data, $file);
        return true;
    }
}