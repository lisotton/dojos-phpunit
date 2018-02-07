<?php

/**
 * Solution for: http://codingdojo.org/kata/BankOCR/
 */

namespace Dojo\BankOCR;

class OCR {

    private $input;
    private $status;
    private $numbers;

    /**
     * Class constructor.
     *
     * @param string $input
     *   The representation.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $input) {
        if (strlen($input) % 9 !== 0) {
            throw new \InvalidArgumentException("Input should have 3 lines and columns should be multiple of 3.");
        }

        $this->input = $input;
    }

    /**
     * Covert into numeric numbers the given representation.
     *
     * @return string
     *   Return the list of numeric numbers.
     */
    public function convertToNumbers(): string {
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

    /**
     * Check the status of current numbers.
     *
     * @return string
     *   Status of current number. Possible values:
     *   - OK: valid number.
     *   - ILL: some representation were not readable.
     *   - ERR: checksum is invalid.
     */
    public function getStatus(): string {
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

    /**
     * Split given representation into array of digits.
     *
     * @return array
     *   List representation digits.
     */
    private function splitDigits(): array {
        $amountOfDigits = strlen($this->input) / 3 / 3;
        $digits = [];
        for ($i = 0; $i < $amountOfDigits * 3; $i++) {
            $digits[$i % $amountOfDigits] .= substr($this->input, $i * 3, 3);
        }
        return $digits;
    }

    /**
     * Calculate the checksum of numbers.
     *
     * @return int
     *   Checksum of numbers.
     */
    private function calculateChecksum(): int {
        $numbers = $this->convertToNumbers();

        $sum = 0;
        for ($i = 1; $i <= strlen($numbers); $i++) {
            $sum += substr($numbers, $i * -1, 1) * $i;
        }

        return $sum % 11;
    }
}
