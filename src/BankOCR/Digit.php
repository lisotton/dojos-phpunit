<?php

/**
 * Solution for: http://codingdojo.org/kata/BankOCR/
 */

namespace Dojo\BankOCR;

class Digit {

    private $number;

    /**
     * Class constructor.
     *
     * @param string $number
     *   Receives the representation of number.
     */
    public function __construct(string $number) {
        $this->number = $number;
    }

    /**
     * Converts representation number into a numeric or question mark.
     *
     * @return string
     *   Returns a numeric or question mark if number is not identifiable.
     */
    public function convertToNumber(): string {
        $mapping = $this->getMapping();
        return isset($mapping[$this->number]) ? $mapping[$this->number] : "?";
    }

    /**
     * Check if representation if valid or not.
     *
     * @return bool
     *   True if we where able to convert representation into numeric.
     */
    public function isValid(): bool {
        return isset($this->getMapping()[$this->number]);
    }

    /**
     * Returns the list of all known representations.
     *
     * @return array
     *   Map of all known representations.
     */
    private function getMapping(): array {
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