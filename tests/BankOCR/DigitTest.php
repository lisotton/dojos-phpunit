<?php

use PHPUnit\Framework\TestCase;
use Dojo\BankOCR\Digit;

final class DigitTest extends TestCase {

    public function testZero() {
        $number = " _ " .
                "| |" .
                "|_|";
        $digit = new Digit($number);
        $this->assertEquals(0, $digit->convertToNumber());
        $this->assertTrue($digit->isValid());
    }

    public function testOne() {
        $number = "   " .
                "  |" .
                "  |";
        $digit = new Digit($number);
        $this->assertEquals(1, $digit->convertToNumber());
        $this->assertTrue($digit->isValid());
    }

    public function testInvalidNumber() {
        $number = "_____||||";
        $digit = new Digit($number);
        $this->assertEquals("?", $digit->convertToNumber());
        $this->assertFalse($digit->isValid());
    }

    /**
     * @dataProvider digitsProvider
     */
    public function testConvertToNumber($expected, $representation) {
        $digit = new Digit($representation);
        $this->assertEquals($expected, $digit->convertToNumber());
    }

    public function digitsProvider() {
        return [
            [0, " _ | ||_|"],
            [1, "     |  |"],
            [2, " _  _||_ "],
            [3, " _  _| _|"],
            [4, "   |_|  |"],
            [5, " _ |_  _|"],
            [6, " _ |_ |_|"],
            [7, " _   |  |"],
            [8, " _ |_||_|"],
            [9, " _ |_| _|"],
        ];
    }

}
