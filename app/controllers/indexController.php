<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 17:31
 */
namespace app\controllers;

use app\model\followersModel;
use core\fish;
use core\lib\config;
use Michelf\Markdown;

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
        $file_path = ROOT . '/Doc/linvscode.md';
        if (file_exists($file_path)) {
            $data = file_get_contents($file_path);
            $html = Markdown::defaultTransform($data);
            $this->assign('data', $html);
            $this->display('index.html');
        } else {
            http_response_code(403);
        }
    }

    public function test()
    {
       $model = new followersModel();
       $res1 = $model->lists();
       $res2 = $model->getOne(1);
       dd($res2);
    }

    public function getTwig()
    {

    }
}