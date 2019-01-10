<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 16:18
 */
namespace core\lib;

class route
{
    public $ctrl;
    public $action;
    public function __construct()
    {
        /**
         * 1. 隐藏index.php
         * 2. 获取URl 参数部分
         * 3. 返回对应控制器和方法
         */
        //默认值
        $this->ctrl = 'index';
        $this->action = 'index';

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = $_SERVER['REQUEST_URI'];
            // trim() 函数移除字符串两侧的空白字符或其他预定义字符
            $pathArray = explode('/', trim($path, '/'));
            if (isset($pathArray[0])) {
                $this->ctrl = $pathArray[0];
                unset($pathArray[0]);
            }
            if (isset($pathArray[1])) {
                $this->action = $pathArray[1];
                unset($pathArray[1]);
            }

            //url 多余部分转换成 GET
            // id/1/str/2/test/3
//            p($pathArray);
            $count = count($pathArray) + 2;
            $i = 2;
            while ($i < $count) {
                if (isset($pathArray[$i + 1])) {
                    $_GET[$pathArray[$i]] = $pathArray[$i + 1];
                }
                $i = $i + 2;
            }
//            p($_GET);
        }
    }
}