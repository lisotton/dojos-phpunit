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

        $this->basket[$version] = $this->basket[$version] ?? 0;
        $this->basket[$version] += $quantity;
    }

    function clear() {
        $this->basket = [];
    }

    function calculatePrice() {
        if (empty($this->basket)) {
            return 0;
        }

        $collections = $this->createCollections();
        $total = $this->calculateTotal($collections);

        if (count($collections) == 1) {
            return $total;
        }

        $redistributed_collections = $this->redistributeCollections($collections);
        $redistributed_total = $this->calculateTotal($redistributed_collections);

        return $redistributed_total < $total ? $redistributed_total : $total;
    }

    private function calculateTotal($collections) {
        $total = 0;
        foreach ($collections as $collection) {
            $quantity = array_sum($collection);
            $discount = self::DISCOUNT_RULE[$quantity] ?? 0;
            $total += ($quantity * self::BOOK_PRICE) * (1 - $discount);
        }

        return $total;
    }

    private function createCollections() {
        $collections = [];
        $basket = $this->basket;

        for ($i = 0; $i < max($this->basket); $i++) {
            $basket = array_filter($basket);
            foreach ($basket as $version => &$quantity) {
                $collections[$i][$version] = 1;
                $quantity--;
            }
        }

        return $collections;
    }

    private function redistributeCollections($collections) {
        foreach (array_keys($collections) as $i) {
            foreach (array_reverse(array_keys($collections)) as $j) {
                if ($i == $j || count($collections[$i]) <= count($collections[$j])) {
                    break;
                }

                foreach ($collections[$i] as $version => $quantity) {
                    if (!isset($collections[$j][$version])) {
                        $collections[$j][$version] = 1;
                        unset($collections[$i][$version]);
                    }

                    if (count($collections[$i]) <= count($collections[$j])) {
                        break;
                    }
                }
            }
        }

        return $collections;
    }
}
