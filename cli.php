<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 17:16
 */


define ('ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);


function __autoload($class_name) {
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    if(file_exists(ROOT.$class_name.".php")) {
        include_once ROOT.$class_name.".php";
    } else {
        return false;
    }
}

$ar = new \App\Controller\CLI();

try {
    $ar->cli_start();
} catch (Exception $e) {

    print "ERROR: " . $e->getMessage() . PHP_EOL;
    exit;
}
