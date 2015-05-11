<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 22:07
 */

namespace App\Model;


class Generator extends Model {

    private $data;
    private $collection;
    private $history;

    function __construct(array $data) {
        $this->data = $data;
        parent::GetConnection();
    }

    function Run() {

        if(count($this->data["ColsField"])  == 0) {
            return false;
        }

        $this->RegistrationFunction();

        $errors = [];
        // сам запрос одинаков, меняются только данные
        $SQL = "INSERT INTO ".$this->data["tableName"]."
                        (".implode(", ", array_keys($this->data["ColsField"])).")
                         VALUES (:".implode(", :", array_keys($this->data["ColsField"])).")";

        $comAr = array_combine(array_keys($this->data["ColsField"]), array_keys($this->data["ColsField"]));

        // запускаем цикл вставок
        for($i=1; $i<=$this->data["countRows"]; $i++) {

            printf("\r%3d%%", ceil($i / $this->data["countRows"] * 100));

            $DATA = array_map(function($str) {
                return $this->collection[$str]();
            }, $comAr);

            if(!$this->db->InsertRow($SQL, $DATA)) {
                $errors[] = $this->db->msg;
            }
            // если не писать в буфер а сразу выводить, то памяти точно хватит )
            $this->AddRowToHistory($DATA);
        }
        print PHP_EOL;
        return [
            "errors" => $errors,
            "history"   => $this->GetRowHistory(),
            "fields"    => $comAr
        ];
    }

    private function RegistrationFunction() {
        foreach($this->data["ColsField"] AS $col => $key) {
            $maxLen = $this->data["ColMaxLen"][$col];

            switch($key) {
                case "UNI" : $this->collection[$col] = function() use ($maxLen) {
                    return $this->GetUnig($maxLen);

                }; break;

                case "auto_increment" : $this->collection[$col] = function()  { return null; }; break;

                default : $this->collection[$col] = function() use ($maxLen, $col) {
                    switch($this->data["ColsType"][$col]) {
                        case "int" : return $this->GetUnigInt($maxLen);
                        case "tinyint" : return $this->GetUnigInt($maxLen);
                        case "bigint" : return $this->GetUnigInt($maxLen);
                        case "float" : return $this->GetUnigInt($maxLen);
                        case "timestamp" : return date("Y-m-d H:i:s");
                        case "datetime" : return date("Y-m-d H:i:s");
                        case "date" : return date("Y-m-d");
                        case "time" : return date("H:i:s");
                        case "year" : return date("Y");
                        default : {
                        if(preg_match('/email/i', $col)) {
                            return $this->GetUnig(10) . "@" . $this->GetUnig(5) .".com";
                        }
                        if(preg_match('/phone/i', $col)) {
                            return "+80" . mt_rand(4, 9999908889999);
                        }
                        return $this->GetUnig($maxLen);
                        }
                    }

                }; break;
            }
        }
    }

    public function AddRowToHistory($data) {
        $this->history[] = $data;
    }

    public function GetRowHistory() {
        return $this->history;
    }

    private function GetUnig($len = 32) {
        return substr(md5(mt_rand(0,9999999) .time() . microtime(1) . mt_rand(0,9999999)), 0, $len);
    }
    private function GetUnigInt($len = 5) {
        return substr(mt_rand(1, 9999999999), 0, $len);
    }

} 