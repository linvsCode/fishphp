<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 17:31
 */
namespace app\controllers;

use core\fish;
use core\lib\config;

class indexController extends fish
{
    public function index()
    {
//        $model = new \core\lib\model();
//        $sql = 'SELECT * FROM followers';
//        $res = $model->query($sql);
//        p($res);
//        p($res->fetchAll());


        $tmp = config::get('ACTION', 'route');
        $tmp = config::get('CONTROLLER', 'route');
        p($tmp);
        $data = 'Hello World';
        $this->assign('data', $data);
        $this->display('index/index.html');
    }
}