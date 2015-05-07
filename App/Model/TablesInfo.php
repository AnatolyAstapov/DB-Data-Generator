<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 17:20
 */

namespace App\Model;

use Core\Configuration;
use Core\Mysql;

class TablesInfo {

    private $db;
    private $config;

    function __construct() {
        $this->config = Configuration::GetConfig();
        $this->db = new Mysql($this->config["mysql"]);

    }

    function GetTableList() {
        $ar =  $this->db->GetRows("SHOW TABLES");
        if(is_array($ar)) {
            $result = [];
            foreach($ar AS $a) {
                $result[] = array_shift($a);
            }
            return $result;
        }
        return [];
    }

    function GetTableStructure($table) {
        return $this->db->GetRows("SHOW COLUMNS FROM $table");
    }

    function GetCountFromTable($table) {
        $res = ($this->db->GetRow("SELECT COUNT(*) AS count FROM $table"));
        return (int) $res["count"];
    }
} 