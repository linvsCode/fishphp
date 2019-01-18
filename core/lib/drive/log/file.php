<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/17
 * Time: 19:07
 */
namespace core\lib\drive\log;
use core\lib\config;

class file
{
    public $path;

    public function __construct()
    {
        $this->path = config::get('OPTION', 'log');
    }

    public function log($data, $file = '')
    {
        /**
         * 1. 确定存储路径是否存在，否则新建目录
         *
         * 2. 写入日志
         *
         */
        $path = $this->path['PATH'];

        if (!is_dir($path)) {
            mkdir($path, '0777', true);
        }

        if (empty($file)) {
            $file = date('Ymd') ;
        }

        $filePath = $path . $file . '.log';
        $message = date('Y-m-d H:i:s ') . json_encode( $data) . PHP_EOL ;
//        if (file_exists($filePath)) {
//            return file_put_contents($path . $file, $message, FILE_APPEND);
//        }
        return file_put_contents($filePath, $message, FILE_APPEND);
    }
}