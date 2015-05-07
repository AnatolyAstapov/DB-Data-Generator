<?php

namespace Core;

class Mysql {
    
    public $isConnected = false;
    private $datab;
    public $msg;

    public function __construct($conf){
        if($this->isConnected && $this->datab) return true;
        try {
            $this->datab = new \PDO("mysql:host=".$conf["host"].";dbname=".$conf["name"].";charset=".$conf["charset"], $conf["user"], $conf["passwd"]);
            $this->datab->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->datab->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->isConnected = true;
        }
        catch(\PDOException $e) {
            $this->isConnected = false;
            throw new \Exception($e->getMessage());
        }
    }

    public function Disconnect(){
        $this->datab = null;
        $this->isConnected = false;
    }

    public function GetRow($query, $params=array()){
        try{
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        }catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function GetRows($query, $params=array()){
        try{
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function InsertRow($query, $params){
        try{
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return true;
        }catch(\PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }

    public function ReplaceRow($query, $params){
        try{
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return true;
        }catch(\PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }

    public function GetInsertedId() {
        return $this->datab->lastInsertId();
    }

    public function UpdateRow($query, $params){
        return $this->insertRow($query, $params);
    }

    public function DeleteRow($query, $params){
        return $this->insertRow($query, $params);
    }
}

	




