<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/18
 * Time: 11:29
 */
namespace app\model;

use core\lib\model;

class followersModel extends model
{
    public $table = 'followers';

    public function lists()
    {
        $ret = $this->select($this->table, '*');
        return $ret;
    }

    public function getOne($id)
    {
        if (empty($id)) {
            throw new \Exception('id不能为空');
        }
        $res = $this->get($this->table, '*', ['id' => $id]);
        return $res;
    }
}