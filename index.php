<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 15:55
 */


/**
 * 入口文件
 * 1. 定义常量
 * 2. 加载函数库
 * 3. 启动框架
 */
//定义常量
define('ROOT', realpath('./'));
define('CORE', ROOT . '/core');
define('APP', ROOT . '/app');
define('MODULE',  'app');
define('DEBUG', true);

if (DEBUG) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);  // E_STRICT 编码标准化警告(建议如何修改以向前兼容)
} else {
    ini_set('display_errors', 'Off');
}
//加载函数库
include CORE . '/common/function.php';

include CORE . '/fish.php';

//spl_autoload_register函数是实现自动加载未定义类功能的的重要方法，
//所谓的自动加载意思就是 我们的new 一个类的时候必须先include或者require的类文件，如果没有include或者require，则会报错。
spl_autoload_register('\core\fish::load');

//启动框架
\core\fish::run();