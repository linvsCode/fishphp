<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 17:31
 */
namespace app\controllers;

use core\fish;

class indexController extends fish
{
    public function index()
    {
//        p('index start');
//        $model = new \core\lib\model();
//        $sql = 'SELECT * FROM followers';
//        $res = $model->query($sql);
//        p($res);
//        p($res->fetchAll());
        $data = 'Hello World';
        $this->assign('data', $data);
        $this->display('index/index.html');
    }
}