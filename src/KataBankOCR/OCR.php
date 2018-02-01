<?php

namespace Dojo\KataBankOCR;

class OCR {

    private $input;

    function __construct($input) {
        $this->input = $input;
    }

    function convertToNumbers() {
        $digits = $this->splitDigits();
        $numbers = "";
        foreach ($digits as $digit) {
            $digit = new Digit($digit);
            $numbers .= $digit->convertToNumber();
        }
        return $numbers;
    }

    private function splitDigits() {
        $amountOfDigits = strlen($this->input) / 3 / 3;
        $digits = [];
        for ($i = 0; $i < $amountOfDigits * 3; $i++) {
            $digits[$i % $amountOfDigits] .= substr($this->input, $i * 3, 3);
        }
        return $digits;
    }
}
