<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.05.15
 * Time: 23:28
 */

namespace Core;


class Register {

    static private $data;

    private function __construct() {

    }

    private function __clone() {

    }

    static public function SetVal($k, $v) {
        if(isset(self::$data[$k])) {
            throw new \Exception("Register $k Already defined");
        }
        self::$data[$k] = $v;
    }

    static public function GetVal($k) {
        if(isset(self::$data[$k])) {
            return self::$data[$k];
        }
        return null;
    }
} 