<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 17:31
 */
namespace app\controllers;

class indexController
{
    public function index()
    {
        p('index start');
        $model = new \core\lib\model();
        $sql = 'SELECT * FROM followers';
        $res = $model->query($sql);
        p($res);
        p($res->fetchAll());
    }
}