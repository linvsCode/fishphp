<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 16:14
 */
namespace core;
use core\lib\log;
use core\lib\route;
class fish
{
    //临时储存已经引进的类，防止重复引入
    public static $classMap = [];
    public $assign;
    public static $controller;
    public static $action;
    /**
     *
     * @throws \Exception
     * @author llj <1063944289@qq.com>
     */
    public static function run()
    {
//        log::init();
//        log::log([234324,3434], 'test');
        $route = new route();
        self::$controller =  $className = $route->ctrl;
        self::$action = $action = $route->action;
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

    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    /**
     * 旧版
     * @param $file
     * @author llj <1063944289@qq.com>
     */
//    public function display($file)
//    {
//        $file = APP . '/views/' . $file;
//        if (is_file($file)) {
//            extract($this->assign);
//            include $file;
//        }
//    }

    /**
     * twig模板
     * @param $file
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @author llj <1063944289@qq.com>
     */
    public function display($file)
    {
        $tmpfile = APP . '/views/' . self::$controller .'/' .$file;
        if (is_file($tmpfile)) {
            $loader = new \Twig_Loader_Filesystem(APP . '/views/' . self::$controller);
            $templateCachePath = ROOT . '/path/to/compilation_cache';
            if (!is_dir($templateCachePath)) {
                mkdir($templateCachePath, 0777, true);
            }
            $twig = new \Twig_Environment($loader, [
                'cache' => $templateCachePath,
                'debug' => DEBUG,
            ]);
            $template = $twig->load($file);
            $template->display($this->assign?$this->assign: '');
        }
    }
}
