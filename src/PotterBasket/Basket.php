<?php

namespace Dojo\PotterBasket;

class Basket {

    const BOOK_PRICE = 8;
    const AVAILABLE_VERSIONS = [1, 2, 3, 4, 5];
    const DISCOUNT_RULE = [2 => 0.05, 3 => 0.1, 4 => 0.20, 5 => 0.25];

    private $basket = [];

    function addBooks(int $version, int $quantity) {
        if (!in_array($version, self::AVAILABLE_VERSIONS)) {
            throw new \InvalidArgumentException("Invalid book version.");
        }

        $this->basket[$version - 1] = $this->basket[$version - 1] ?? 0;
        $this->basket[$version - 1] += $quantity;
    }

    function clear() {
        $this->basket = [];
    }

    function calculatePrice() {
        if (empty($this->basket)) {
            return 0;
        }

        $collections = [];
        $basket = $this->basket;

        for ($i = 0; $i < max($this->basket); $i++) {
            $basket = array_filter($basket);
            foreach ($basket as $version => &$quantity) {
                $collections[$i][$version] = 1;
                $quantity--;
            }
        }

        $total = 0;
        foreach ($collections as $collection) {
            $quantity = array_sum($collection);
            $discount = self::DISCOUNT_RULE[$quantity] ?? 0;
            $total += ($quantity * self::BOOK_PRICE) * (1 - $discount);
        }

        return $total;
    }
}
