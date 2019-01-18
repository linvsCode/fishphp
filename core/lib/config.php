<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/10
 * Time: 19:23
 */

namespace core\lib;

class config
{
    static public $config = array();

    /**
     *
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     * @author llj <1063944289@qq.com>
     */
    static public function get($name, $file)
    {
        /**
         * 1 判断配置文件是否存在
         * 2 判断配置是否存在
         * 3 缓存配置
         */
        if (isset(self::$config[$file])) {
            if (isset(self::$config[$file][$name])) {
                return self::$config[$file][$name];
            } else {
                throw new \Exception($name . '配置项不存在' );
            }
        } else {
            $tmpFile = ROOT . '/core/config/' . $file . '.php';
            if (is_file($tmpFile)) {
                $conf = include $tmpFile;
                if (isset($conf[$name])) {
                    self::$config[$file] = $conf;
                    return $conf[$name];
                } else {
                    throw new \Exception($name . '配置项不存在');
                }
            } else {
                throw new \Exception('找不到对应配置文件' . $file);
            }
        }
    }

    /**
     *
     * @param $file
     * @return mixed
     * @throws \Exception
     * @author llj <1063944289@qq.com>
     */
    static public function all($file)
    {
        if (isset(self::$config[$file])) {
            return self::$config[$file];
        } else {
            $tmpFile = ROOT . '/core/config/' . $file . '.php';
            if (is_file($tmpFile)) {
                $conf = include $tmpFile;
                self::$config[$file] = $conf;
                return $conf;
            } else {
                throw new \Exception('找不到对应配置文件' . $file);
            }
        }
    }
}