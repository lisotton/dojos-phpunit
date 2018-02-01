<?php

namespace Dojo\KataBankOCR;

class OCR {

    private $input;
    private $status;
    private $numbers;

    function __construct($input) {
        $this->input = $input;
    }

    function convertToNumbers() {
        if (isset($this->numbers)) {
            return $this->numbers;
        }

        $digits = $this->splitDigits();
        $this->numbers = "";
        foreach ($digits as $digit) {
            $digit = new Digit($digit);
            $this->numbers .= $digit->convertToNumber();
        }
        return $this->numbers;
    }

    function getStatus() {
        if (isset($this->status)) {
            return $this->status;
        }

        $numbers = $this->convertToNumbers();
        if (strpos($numbers, '?') !== FALSE) {
            return $this->status = 'ILL';
        }

        $checksum = $this->calculateChecksum();
        if ($checksum !== 0) {
            return $this->status = "ERR";
        }

        return $this->status = 'OK';
    }

    private function splitDigits() {
        $amountOfDigits = strlen($this->input) / 3 / 3;
        $digits = [];
        for ($i = 0; $i < $amountOfDigits * 3; $i++) {
            $digits[$i % $amountOfDigits] .= substr($this->input, $i * 3, 3);
        }
        return $digits;
    }

    private function calculateChecksum() {
        $numbers = $this->convertToNumbers();

        $sum = 0;
        for ($i = 1; $i <= strlen($numbers); $i++) {
            $sum += substr($numbers, $i * -1, 1) * $i;
        }

        return $sum % 11;
    }
}
