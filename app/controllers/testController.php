<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/16
 * Time: 17:59
 */
namespace app\controllers;

class testController
{
    public function index()
    {
        p(date('Y-m-d',strtotime('monday last week')));

        p(date('Y-m-d', strtotime('-' . (6+date('w')) . ' days')));

        p((int)((0.1+0.7)*10));

        $arr = [
            23,43,53,45,45,63,23,'',0
        ];
        p($arr);
        $array = array_unique(array_filter($arr));
        p($array);
        p(rsort($array));
        p($array);
        $arr = array_values($array);
        p($arr);



    }
}