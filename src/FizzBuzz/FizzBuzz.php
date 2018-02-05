<?php

namespace Dojo\FizzBuzz;

class FizzBuzz {

    private $number;

    function __construct($number) {
        $this->number = $number;
    }

    function toText() {
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

    static function sequence() {
        return array_map(function($number) {
            $fb = new FizzBuzz($number);
            return $fb->toText();
        }, range(1, 100));
    }

}