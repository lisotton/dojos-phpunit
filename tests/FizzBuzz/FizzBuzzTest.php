<?php

use PHPUnit\Framework\TestCase;
use Dojo\FizzBuzz\FizzBuzz;

final class FizzBuzzTest extends TestCase {

    public function testFizzForThree() {
        $fb = new FizzBuzz(3);
        $this->assertEquals('Fizz', $fb->toText());
    }

    public function testBuzzForFive() {
        $fb = new FizzBuzz(5);
        $this->assertEquals('Buzz', $fb->toText());
    }

    public function testFizzBuzzForFifteen() {
        $fb = new FizzBuzz(15);
        $this->assertEquals('FizzBuzz', $fb->toText());
    }

    public function testNumberForNotDivisible() {
        $fb = new FizzBuzz(4);
        $this->assertEquals(4, $fb->toText());
    }

    public function testFizzBuzzSequence() {
        $sequence = FizzBuzz::sequence();
        $this->assertEquals(100, count($sequence));

        $this->assertEquals($sequence[3], 4);
        $this->assertEquals($sequence[7], 8);

        $this->assertEquals($sequence[2], 'Fizz');
        $this->assertEquals($sequence[5], 'Fizz');

        $this->assertEquals($sequence[4], 'Buzz');
        $this->assertEquals($sequence[9], 'Buzz');

        $this->assertEquals($sequence[14], 'FizzBuzz');
        $this->assertEquals($sequence[29], 'FizzBuzz');
    }
}