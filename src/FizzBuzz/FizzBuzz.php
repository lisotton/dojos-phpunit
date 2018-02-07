<?php

/**
 * Solution for: http://codingdojo.org/kata/FizzBuzz/
 */

namespace Dojo\FizzBuzz;

class FizzBuzz {

    private $number;

    /**
     * Class constructor.
     *
     * @param int $number
     *   Number to be checked.
     */
    public function __construct(int $number) {
        $this->number = $number;
    }

    /**
     * Returns the text representation of given number.
     *
     * @return string
     *   The representation of given number:
     *   - Fizz: for numbers divisible by 3.
     *   - Buzz: for numbers divisible by 5.
     *   - FizzBuzz: for numbers divisible by 3 and 5.
     */
    public function toText(): string {
        if ($this->number % 3 === 0 && $this->number % 5 === 0) {
            return 'FizzBuzz';
        }
        elseif ($this->number % 3 === 0) {
            return 'Fizz';
        }
        elseif ($this->number % 5 === 0) {
            return 'Buzz';
        }

        return $this->number;
    }

    /**
     * Returns a list of representation from 1 to 100.
     *
     * @return array
     *   An array of representation.
     */
    public static function sequence(): array {
        return array_map(function($number) {
            $fb = new FizzBuzz($number);
            return $fb->toText();
        }, range(1, 100));
    }

}
