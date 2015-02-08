<?php

require_once("StringExtensions.php");

class ArrayPrintRParser
{
    private $printRString;
    private $phpString;

    public function __construct($p_PrintRString)
    {
        $this->printRString = $p_PrintRString;
        $this->phpString = $this->buildPhpString($p_PrintRString);

    }

    public function PhpString()
    {
        return $this->phpString;
    }

    private function buildPhpString($p_PrintRString)
    {
        $temp = $p_PrintRString;
        $retVal = "";

        // Remove line breaks and remove blanks
        $temp = str_replace(array("\n", "\r"), "", $temp);
        $temp = str_replace("Array (", "Array(", $temp);
        $temp = str_replace(" => ", "=>", $temp);

        if (!StringExtensions::StartsWith($temp, "Array(")) {
            throw new exception("String does not start with Array.");
        }

        $this->splitPrintRString($retVal, $temp);

        return $retVal;
    }

    private function splitPrintRString(&$phpString, &$printRString)
    {
        $this->trim($printRString);
        $closingParanthesisNeeded = false;

        if (StringExtensions::StartsWith($printRString, "Array(")) {
            $phpString .= "Array(";
            $printRString = ltrim($printRString, "Array(");
            $closingParanthesisNeeded = true;
        }

        $oneKeyAlreadyWritten = false;

        do {

            $this->trim($printRString);

            if (StringExtensions::StartsWith($printRString, ")")) {
                $printRString = substr($printRString, 1);
            }

            if (strlen($printRString) === 0) {
                break;
            }

            // Check if an Array-Key is following...
            if (StringExtensions::StartsWith($printRString, "[")) {

                if ($oneKeyAlreadyWritten === true) {
                    $phpString .= ",";
                }

                $oneKeyAlreadyWritten = true;

                $closingBracketIdx = strpos($printRString, "]", 1);
                $keyValue = substr($printRString, 1, $closingBracketIdx - 1);

                $phpString .= "'" . $keyValue . "' => ";
                $printRString = substr($printRString, 4 + strlen($keyValue));

                $this->trim($printRString);

                // Read the value after the key...
                if (StringExtensions::StartsWith($printRString, "Array(")) {
                    $this->splitPrintRString($phpString, $printRString);
                } else {
                   // Search for next Array-Key or end of current Array...

                    $startingBracketIdx = strpos($printRString, "[");
                    $endingParanthesisIdx = strpos($printRString, ")");

                    if ($startingBracketIdx === false) {
                        $idx = $endingParanthesisIdx;
                    } else {
                        $idx = min($startingBracketIdx, $endingParanthesisIdx);
                    }

                    $phpString .= "'" . $this->trim(substr($printRString, 0, $idx)) . "'";
                    $printRString = substr($printRString, $idx);

                    // Check if it is the last key in the array...
                    if ($startingBracketIdx > $endingParanthesisIdx || $startingBracketIdx === false) {
                        break;
                    }
                }
            }

        } while (true);

        if ($closingParanthesisNeeded) {
            $phpString .= ")";
        }

    }

    private function trim(&$value)
    {
        $value = trim($value);
        return $value;
    }

}