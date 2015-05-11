<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.05.15
 * Time: 23:55
 */

namespace App\Model;

use Core\Configuration;
use Core\Mysql;
use Core\Register;

class Model {

    protected $db;
    protected $config;

    protected function GetConnection() {

        if(null === ($this->config = Register::GetVal("config"))) {
            $this->config = Configuration::GetConfig();
            Register::SetVal("config", $this->config);
        }

        if(null === ($this->db = Register::GetVal("db"))) {
            $this->db = new Mysql($this->config["mysql"]);
            Register::SetVal("db", $this->db);
        }

    }
} 