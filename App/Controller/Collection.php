<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 19:04
 */

namespace App\Controller;


class Collection {

    /*
     * работа с список таблиц
     */
    private $Tables;
    protected function SetTables($data) {
        $this->Tables = $data;
    }
    protected  function GetTables() {
        if(isset($this->Tables)) {
            return $this->Tables;
        }
        return [];
    }

    /*
     * Сколько генерировать данных
     */
    private $countRows;
    protected function SetCountRows($data) {
        $this->countRows = (int) $data;
    }
    protected function GetCountRows() {
        if(isset($this->countRows)) {
            return $this->countRows;
        }
        return 0;
    }

    /*
     * Таблица с которой работаем
     */
    private $TableName;
    protected function SetTableName($data) {
        $this->TableName = (string) $data;
    }
    protected function GetTableName() {
        if(isset($this->TableName)) {
            return $this->TableName;
        }
        return null;
    }

    /*
     * Список колонок и ключи полей
     */
    private $FieldsKeys;
    protected function SetTableFields($data) {
        $this->FieldsKeys = $data;
    }
    protected function GetTableFields() {
        if(isset($this->FieldsKeys)) {
            return $this->FieldsKeys;
        }
        return null;
    }

    /*
     * Список колонок и max len
     */
    private $colsMaxLen;
    protected function SetColsMaxLen($data) {
        $this->colsMaxLen = $data;
    }
    protected function GetColsMaxLen() {
        if(isset($this->colsMaxLen)) {
            return $this->colsMaxLen;
        }
        return null;
    }

    /*
     * Список колонок и их типов
     */
    private $colsType;
    protected function SetColsType($data) {
        $this->colsType = $data;
    }
    protected function GetColsType() {
        if(isset($this->colsType)) {
            return $this->colsType;
        }
        return null;
    }
} 