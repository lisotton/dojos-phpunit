<?php

namespace Dojo\BankOCR;

class Digit {

    private $number;

    function __construct($number) {
        $this->number = $number;
    }

    function convertToNumber() {
        $mapping = $this->getMapping();
        return isset($mapping[$this->number]) ? $mapping[$this->number] : "?";
    }

    function isValid() {
        return isset($this->getMapping()[$this->number]);
    }

    private function getMapping() {
        $mapping = [
            0 => " _ " .
                 "| |" .
                 "|_|",
            1 => "   " .
                 "  |" .
                 "  |",
            2 => " _ " .
                 " _|" .
                 "|_ ",
            3 => " _ " .
                 " _|" .
                 " _|",
            4 => "   " .
                 "|_|" .
                 "  |",
            5 => " _ " .
                 "|_ " .
                 " _|",
            6 => " _ " .
                 "|_ " .
                 "|_|",
            7 => " _ " .
                 "  |" .
                 "  |",
            8 => " _ " .
                 "|_|" .
                 "|_|",
            9 => " _ " .
                 "|_|" .
                 " _|",
        ];
        return array_flip($mapping);

    }

}