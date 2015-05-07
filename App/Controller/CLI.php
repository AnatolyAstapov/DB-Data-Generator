<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 17:19
 */

namespace App\Controller;

use App\Model\Generator;
use App\Model\TablesInfo;

class CLI extends Controller {

    function __construct() {
        $this->ModelTablesInfo = new TablesInfo();
    }

    public function cli_start() {

        // заранее получаем список таблиц
        $this->SetTables($this->ModelTablesInfo->GetTableList());

        // выводим список таблиц
        $this->ShowMessage("Tables list");
        $this->CliPrintArray(
            $this->GetTables()
        );
        $this->_sleep();

        // предложение про показ информацию про таблицы
        if(strtolower($this->WaiteInput("Show table details ? [y/n]")) == "y") {
            // входим в меню показа данных о таблицах
            $this->ShowTableStructure();
        }

        //$this->ShowMessage("Generation data");

        $this->GenerateDataInTable();

    }


    private function GenerateDataInTable() {
        $table = $this->WaiteInput("enter table for generation data [q - quit] ");
        if(strtolower($table) == "q") {
            return;
        }

        // проверка что таблица введина правлиьная
        if(!in_array($table, $this->GetTables())) {
            $this->PrintText("Table name is incorrect");
            $this->GenerateDataInTable();
        }

        // записываем таблицу уже выбранную
        $this->SetTableName($table);

        // получаем сколько записей нужно сгенерировать
        $this->InputCountGenData();

        // проверяем и записываем типы таблицы
        $this->GetTableFieldsKeys();

        // запускаем модель с генератором
        $ModelGenerator = new Generator(
            [
                "tableName" => $this->GetTableName(),
                "countRows" => $this->GetCountRows(),
                "ColsField" => $this->GetTableFields(),
                "ColMaxLen" => $this->GetColsMaxLen(),
                "ColsType"  => $this->GetColsType()
            ]
        );

        // получаем результаты
        $result = $ModelGenerator->Run();

        if(!isset($result["errors"]) || count($result["errors"]) == 0) {
            $this->ShowMessage("DONE");
        } else {
            $this->ShowErrors($result);
        }

        // показыаем результаты если нужно
        $this->ShowResult($result);

        $this->ShowMessage("Bye! =)");
    }

    private function ShowResult($ar) {
        if(isset($ar["history"])) {
            $str = $this->WaiteInput("show results ? [y/n] ");
            if(strtolower($str) == "y") {
                $this->ShowHistory($ar);
            }
        }
    }

    private function GetTableFieldsKeys() {
        $TableStructure = $this->ModelTablesInfo->GetTableStructure(
            $this->GetTableName()
        );

        // получаем длинну
        $ColsLend = $this->GetLenColsFromStructureTable(
            $TableStructure
        );
        $this->SetColsMaxLen($ColsLend);

        // получаем ключи
        $FieldsKeys = $this->GetKeysTablesFromStructureTable(
            $TableStructure
        );
        $this->SetTableFields($FieldsKeys);

        // получаем тип данных полей
        $ColsType = $this->GetTypeTablesFromStructureTable(
            $TableStructure
        );
        $this->SetColsType($ColsType);
    }

    private function InputCountGenData() {
        $count = $this->WaiteInput("enter count generate rows [q - quit] ");
        if(strtolower($count) == "q") {
            //return;
            $this->PrintText("Bye! =)");
            exit;
        }
        if((int) $count == 0) {
            $this->PrintText("Count rows is incorrect");
            $this->InputCountGenData();
        }
        $this->SetCountRows($count);
    }

    private function ShowTableStructure() {
        $table = $this->WaiteInput("enter table name for show structure [q - quit]");
        if(strtolower($table) == "q") {
            return;
        }

        // проверка что таблица правлиьная
        if(!in_array($table, $this->GetTables())) {
            $this->PrintText("Table name incorrect");
            $this->ShowTableStructure();
        }

        // показываем данные про таблицы
        $ar = $this->ModelTablesInfo->GetTableStructure($table);
        if(is_array($ar)) {
            $this->ShowTableInfo($ar);
        }

        // показывае сколько записей в таблице
        $this->ShowCountRows(
            $this->ModelTablesInfo->GetCountFromTable($table)
        );

        $this->ShowTableStructure();
    }



}