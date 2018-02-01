<?php

use PHPUnit\Framework\TestCase;
use Dojo\KataBankOCR\OCR;

final class OCRTest extends TestCase {

    public function testConvertAllZeros() {
        $input = " _  _  _  _  _  _  _  _  _ " .
                 "| || || || || || || || || |" .
                 "|_||_||_||_||_||_||_||_||_|";
        $ocr = new OCR($input);
        $this->assertEquals("000000000", $ocr->convertToNumbers());
    }

    public function testConvertNumberOne() {
        $input = " _  _  _  _  _  _  _  _    " .
                 "| || || || || || || || |  |" .
                 "|_||_||_||_||_||_||_||_|  |";
        $ocr = new OCR($input);
        $this->assertEquals("000000001", $ocr->convertToNumbers());
    }

    public function testConvertAllEight() {
        $input = " _  _  _  _  _  _  _  _  _ " .
                 "|_||_||_||_||_||_||_||_||_|" .
                 "|_||_||_||_||_||_||_||_||_|";
        $ocr = new OCR($input);
        $this->assertEquals("888888888", $ocr->convertToNumbers());
    }

    public function testConvertOneInvalidNumber() {
        $input = " _  _  _  _     _  _  _  _ " .
                 "|_||_||_||_|| ||_||_||_||_|" .
                 "|_||_||_||_|| ||_||_||_||_|";
        $ocr = new OCR($input);
        $this->assertEquals("8888?8888", $ocr->convertToNumbers());
    }

}
