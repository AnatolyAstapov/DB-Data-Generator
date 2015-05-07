<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 17:27
 */

namespace Core;

class Configuration {

    static private $config = false;

    static private  function LoadConfig() {
        if(!self::$config) {
            self::$config = @parse_ini_file(ROOT . 'include/setup.ini', true);
            if(!self::$config) {
                throw new \Exception("Load config fail");
            }
        }
        return self::$config;
    }

    static public function GetConfig() {
        return self::LoadConfig();
    }

} 