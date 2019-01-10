<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 16:14
 */
namespace core;
use core\lib\route;
class fish
{
    //临时储存已经引进的类，防止重复引入
    public static $classMap = [];

    /**
     *
     * @throws \Exception
     * @author llj <1063944289@qq.com>
     */
    public static function run()
    {
        $route = new route();
        $className = $route->ctrl;
        $action = $route->action;
        $controller = APP . '/controllers/' . $className . 'Controller.php';
        if (is_file($controller)) {
            $controllerClass = '\\' . MODULE . '\\controllers\\' . $className . 'Controller';
            include $controller;
            $ctrl = new $controllerClass;
            if (!method_exists($ctrl, $action)) {
                throw new \Exception($action . '方法不存在');
            }
            $ctrl->$action();
        } else {
            throw new \Exception('找不到对应控制器' . $className);
        }
    }

    public static function load($class)
    {
        //自动加载类库
        $class = str_replace('\\', '/', $class);
        //判断是否重复引入
        //p($class);
        if (isset(self::$classMap[$class])) {   //已经存在引入类就无需再次引入
            return true;
        } else {
            $classPath = ROOT . '/' . $class . '.php';
            if (is_file($classPath)) {
                include $classPath;
                self::$classMap[$class] = $classPath;
                //p($classPath);
            } else {
                return false;
            }
        }

    }
}
