<?php

use PHPUnit\Framework\TestCase;
use Dojo\PotterBasket\Basket;

class BasketTest extends TestCase {

    function testBasicBasket() {
        $basket = new Basket();
        $this->assertEquals(0, $basket->calculatePrice());

        $basket->addBooks(1, 1);
        $this->assertEquals(Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(2, 1);
        $this->assertEquals(Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(3, 1);
        $this->assertEquals(Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(4, 1);
        $this->assertEquals(Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(5, 1);
        $this->assertEquals(Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(1, 2);
        $this->assertEquals(Basket::BOOK_PRICE * 2, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(2, 3);
        $this->assertEquals(Basket::BOOK_PRICE * 3, $basket->calculatePrice());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInvalidBookVersion() {
        $basket = new Basket();
        $basket->addBooks(6, 1);
    }

    function testSimpleDiscounts() {
        $basket = new Basket();
        $basket->addBooks(1, 1);
        $basket->addBooks(2, 1);
        $this->assertEquals(Basket::BOOK_PRICE * 2 * 0.95, $basket->calculatePrice());

        $basket->addBooks(3, 1);
        $this->assertEquals(Basket::BOOK_PRICE * 3 * 0.90, $basket->calculatePrice());

        $basket->addBooks(4, 1);
        $this->assertEquals(Basket::BOOK_PRICE * 4 * 0.80, $basket->calculatePrice());

        $basket->addBooks(5, 1);
        $this->assertEquals(Basket::BOOK_PRICE * 5 * 0.75, $basket->calculatePrice());
    }

    function testSeveralDiscounts() {
        $basket = new Basket();
        $basket->addBooks(1, 2);
        $basket->addBooks(2, 1);
        $this->assertEquals((Basket::BOOK_PRICE * 2 * 0.95) + Basket::BOOK_PRICE, $basket->calculatePrice());

        $basket->addBooks(2, 1);
        $this->assertEquals((Basket::BOOK_PRICE * 2 * 0.95) * 2, $basket->calculatePrice());

        $basket->addBooks(3, 1);
        $basket->addBooks(4, 1);
        $this->assertEquals((Basket::BOOK_PRICE * 4 * 0.80) + (Basket::BOOK_PRICE * 2 * 0.95), $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(1, 2);
        $basket->addBooks(2, 1);
        $basket->addBooks(3, 1);
        $basket->addBooks(4, 1);
        $basket->addBooks(5, 1);
        $this->assertEquals((Basket::BOOK_PRICE * 5 * 0.75) + Basket::BOOK_PRICE, $basket->calculatePrice());
    }

    function testEdgeCases() {
        $basket = new Basket();
        $basket->addBooks(1, 2);
        $basket->addBooks(2, 2);
        $basket->addBooks(3, 2);
        $basket->addBooks(4, 1);
        $basket->addBooks(5, 1);
        $this->assertEquals((Basket::BOOK_PRICE * 4 * 0.80) * 2, $basket->calculatePrice());

        $basket->clear();
        $basket->addBooks(1, 5);
        $basket->addBooks(2, 5);
        $basket->addBooks(3, 4);
        $basket->addBooks(4, 5);
        $basket->addBooks(5, 4);
        $this->assertEquals(((Basket::BOOK_PRICE * 5 * 0.75) * 3) + ((Basket::BOOK_PRICE * 4 * 0.8) * 2), $basket->calculatePrice());
    }
}
