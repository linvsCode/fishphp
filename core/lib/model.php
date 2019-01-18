<?php
/**
 * Created by PhpStorm.
 * User: linvscode
 * Date: 2019/1/9
 * Time: 17:56
 */
namespace core\lib;

//class model extends \PDO
use Medoo\Medoo;

class model extends Medoo
{
    public function __construct()
    {
        $temp = config::all('databases');
        parent::__construct($temp);

//        $dsn = $temp['dsn'];
//        $username = $temp['username'];
//        $passwd = $temp['password'];
//        try {
//            parent::__construct($dsn, $username, $passwd);
//        } catch (\PDOException $e) {
//            p($e->getMessage());
//        }
    }
}