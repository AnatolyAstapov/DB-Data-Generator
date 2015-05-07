<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.15
 * Time: 18:10
 */

namespace App\Controller;

class Controller extends Collection {

    protected $consoleLen = 120;

    protected function CliPrintArray(array $array) {
        if(count($array) > 0) {

            foreach($array AS $str) {
                print "[*] ";
                print $str;
                print PHP_EOL;
            }
        }
    }

    private function PrintDots($len = 10) {
        print str_pad("", $len, ".");
    }

    protected  function ShowMessage($text) {
        print str_pad("", $this->consoleLen, "-").PHP_EOL;
        print "|".str_pad("".$text, $this->consoleLen - strlen($text), " ", STR_PAD_BOTH)."".PHP_EOL;
        print str_pad("", $this->consoleLen, "-").PHP_EOL;
    }

    protected function WaiteInput($ask = null) {
        print " - " . $ask ." : ";
        return trim(fgets(STDIN));
    }

    protected function _sleep() {
        usleep(500000);
    }

    protected function PrintText($text) {
        print $text.PHP_EOL;
    }

    protected function GetLenColsFromStructureTable($ar) {
        if(!is_array($ar)) {
            throw new \Exception("DATA FROM TABLE FAIL");
        }
        $result = [];
        foreach($ar AS $_ar) {
            if(!isset($_ar["Field"])) {
                continue;
            }
            if(isset($_ar["Type"]) && !empty($_ar["Type"])) {
                if(preg_match('/\d+/S', $_ar["Type"], $ars)) {
                    $result[$_ar["Field"]] = $ars[0];
                } else {
                    $result[$_ar["Field"]] = 50;
                }
            }
        }
        return $result;
    }

    protected function GetTypeTablesFromStructureTable($ar) {
        if(!is_array($ar)) {
            throw new \Exception("DATA FROM TABLE FAIL");
        }
        $result = [];
        foreach($ar AS $_ar) {
            if(!isset($_ar["Field"])) {
                continue;
            }
            if(isset($_ar["Type"]) && !empty($_ar["Type"])) {
                if(preg_match('/[\w]+/i', $_ar["Type"], $ars)) {
                    $result[$_ar["Field"]] = strtolower(trim($ars[0]));
                } else {
                    return "varchar";
                }

            }
        }
        return $result;
    }

    protected function GetKeysTablesFromStructureTable($ar) {
        if(!is_array($ar)) {
            throw new \Exception("DATA FROM TABLE FAIL");
        }
        $result = [];
        foreach($ar AS $_ar) {
            if(!isset($_ar["Field"])) {
                continue;
            }
            if(isset($_ar["Key"])/* && !empty($_ar["Key"])*/) {
                $result[$_ar["Field"]] = $_ar["Key"];
            }
            if(isset($_ar["Extra"]) && !empty($_ar["Extra"])) {
                $result[$_ar["Field"]] = $_ar["Extra"];
            }
        }
        return $result;
    }

    protected function GetFieldsTablesFromStructureTable($ar) {
        if(!is_array($ar)) {
            throw new \Exception("DATA FROM TABLE FAIL");
        }
        $result = [];
        foreach($ar AS $_ar) {
            if(!isset($_ar["Field"])) {
                continue;
            }
            $result[] = trim($_ar["Field"]);
        }
        return $result;
    }

    protected function ShowTableInfo($ar) {
        $array = $ar;
        $ArCols = array_keys(array_shift($ar));
        $cols_str = implode("  ", $ArCols);
        if(strlen($cols_str) > $this->consoleLen) {
            $this->consoleLen = 200;
        }
        if(strlen(implode(" ", array_values(array_shift($ar)))) > $this->consoleLen) {
            $this->consoleLen = 200;
        }
        print str_pad("", $this->consoleLen, "-").PHP_EOL;
        $pad = ceil($this->consoleLen / count($ArCols));
        foreach($ArCols AS $str) {
            $this->PrintLinePad($str, $pad);
        }
        print PHP_EOL;
        print str_pad("", $this->consoleLen, "-").PHP_EOL;

        foreach($array AS $arstr) {
            foreach($arstr AS $str) {
                $this->PrintLinePad($str, $pad);
            }
            print PHP_EOL;
        }
    }

    protected function ShowErrors($ar) {
        print_r($ar);
        exit;
    }

    protected function ShowHistory($ar) {

        $pad = ceil($this->consoleLen / count($ar["fields"])) + 2;
        print str_pad("", $pad * count($ar["fields"]), "-").PHP_EOL;
        $one_d = end($ar["history"]);
        foreach($ar["fields"] AS $str) {
            $_pad = strlen($one_d[$str]);
            $this->PrintLinePad($str, ($_pad > $pad ? $_pad + 2 : $pad));
        }
        print PHP_EOL;
        print str_pad("", $pad * count($ar["fields"]), "-").PHP_EOL;
        foreach($ar["history"] AS $_ar) {
            foreach($_ar as $str) {
                $this->PrintLinePad($str, $pad);
            }
            print PHP_EOL;
        }
        print str_pad("", $pad * count($ar["fields"]), "-").PHP_EOL;
    }
    protected function PrintLinePad($str, $pad = false) {
        if(!$pad) {
            $pad = $this->consoleLen;
        }
        print str_pad("| ".$str, ($pad),  " ", STR_PAD_RIGHT)."";
    }

    protected function ShowCountRows($count = 0) {
        $count = (int) $count;
        print str_pad("", $this->consoleLen, "-").PHP_EOL;
        print "| Total rows: ". $count . PHP_EOL;
        print str_pad("", $this->consoleLen, "-").PHP_EOL;
    }


} 